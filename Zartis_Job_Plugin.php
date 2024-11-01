<?php
/*
Plugin Name: HireHive Job Plugin
Plugin URI: https://hirehive.com
Description: Easily add your own secure jobs and careers page to your WordPress site. Includes full access to professional candidate management and posting to twitter, facebook and free job aggregation sites.
Version: 2.9.0
Author: HireHive
Author URI: https://hirehive.com
Tags: jobs, job, career, manager, vacancy, hiring, hire,listing, social, media, recruiting, recruitment, ats, employer, application, board, hirehive
License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
add_action('init', 'HireHive_Setup');

function HireHive_Setup()
{
    // Create the global path
    define('HireHive_Folder', 'zartis-job-plugin');
    if (!defined('Zartis_Url'))
        define('Zartis_Url', WP_PLUGIN_URL . '/' . HireHive_Folder);

    // Add jquery core and our css styles
    if (is_admin()) {
        wp_enqueue_style('zartis_wp', Zartis_Url . '/css/zartis_wp.css');
        wp_enqueue_script('zartis_functions', Zartis_Url . '/js/zartis_functions.js');

        // The styles for the widget
        wp_enqueue_style('hirehive_wp_widget', Zartis_Url . '/css/hirehive-widget-styles.css');
        wp_enqueue_style('hirehive_wp_fonts', 'https://fonts.googleapis.com/css?family=Roboto:700,500,400italic,300,400');
    }
}

/* Runs when plugin is activated */
register_activation_hook(__FILE__, 'HireHive_Activate');
/* Runs on plugin deactivation*/
register_deactivation_hook(__FILE__, 'HireHive_Deactivate');
/*Runs when the user deletes the plugin */
register_uninstall_hook(__FILE__, 'HireHive_UnInstall');

function HireHive_Activate()
{
    //Stores Company Identifier
    update_option("Zartis_Unique_ID", 'False', '', 'yes');
    //Stores Page ID
    update_option("Zartis_Page_ID", 'False', '', 'yes');
    //Flag to show the message
    update_option("Zartis_Notice", 'False', '', 'yes');
    //Flag to store job grouping
    update_option("Zartis_Group", 1, '', 'yes');
}

function HireHive_Message()
{
    //This calls the Zartis Message when activated
    echo ("<script type='text/javascript'>");
    echo ("HireHive_Message();");
    echo ("</script>");
}

function HireHive_Deactivate()
{
    /*Cleans out everything from the DB */
    global $wpdb;
    $zartis_page_ID = get_option('Zartis_Page_ID');

    // Clean up DB fields
    HireHive_CleanUp_DB();

    //  the id of our page...
    $page_ID = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE ID = '" . $zartis_page_ID . "'");
    if ($page_ID != 'False') {
        wp_delete_post($page_ID, true);
    }
}

function HireHive_UnInstall()
{
    /*Cleans out everything from the DB */
    HireHive_Deactivate();
}

function HireHive_CleanUp_DB()
{
    // We still have old customers so keep old naming conventions
    delete_option('Zartis_Unique_ID');
    delete_option('Zartis_Page_ID');
    delete_option('Zartis_Notice');
    delete_option('Zartis_Width');
    delete_option('Zartis_Group');
}

if (is_admin()) {
    /* Calls the function to add the HireHive Menu */
    add_action('admin_menu', 'Add_HireHive_Admin_Menu');
    $Zartis_Notice = get_option('Zartis_Notice');

    //checks if this is an activation and then displays the zartis message
    if ($Zartis_Notice == "False") {
        add_action('admin_notices', 'HireHive_Message');
        update_option('Zartis_Notice', 'True');
    }
}

function Add_HireHive_Admin_Menu()
{
    //Page Title, Word Shown, Permission, Menu, Slug, Function, icon, pos
    add_menu_page(_('HireHive'), _('HireHive Jobs'), 'administrator', 'Zartis_Menu', 'hirehive_settings', 'https://zartis.blob.core.windows.net/public-icons/wp-menu-icon.png');
}

add_shortcode('zartis_jobs', 'Display_HireHive_Widget');
add_shortcode('hirehive_jobs', 'Display_HireHive_Widget');

function add_hirehive_webcomponent_script($tag, $handle, $src)
{
    if ('hirehive-wc-module' === $handle) {
        $tag = '<script src="' . esc_url($src) . '" type="module"></script>';
    }

    if ('hirehive-wc-nomodule' === $handle) {
        $tag = '<script type="text/javascript" src="' . esc_url($src) . '" nomodule></script>';
    }

    return $tag;
}

// Function for basic field validation (present and neither empty nor only white space
function IsNullOrEmptyString($str)
{
    return (!isset($str) || trim($str) === '');
}

function Display_HireHive_Widget($atts, $content = null)
{
    $companySubdomain = '';
    $category = '';
    $countryCode = '';
    $group = '';

    $skip = 0;
    $take = 500;

    if (isset($atts['company']) && $atts['company']) {
        $companySubdomain = $atts['company'];
    }

    if (IsNullOrEmptyString($companySubdomain)) {
        $companySubdomain = get_option('Zartis_Unique_ID');
    }

    if ($companySubdomain == "False" || IsNullOrEmptyString($companySubdomain)) {
        return false;
    }

    if (isset($atts['category']) && $atts['category']) {
        $category = $atts['category'];
    }

    if (isset($atts['skip']) && $atts['skip']) {
        $skip = $atts['skip'];
    }

    if (isset($atts['take']) && $atts['take']) {
        $take = $atts['take'];
    }

    if (isset($atts['country']) && $atts['country']) {
        $countryCode = $atts['country'];
    }

    if (isset($atts['group']) && $atts['group']) {
        $group = $atts['group'];
    }

    $Zartis_Group = get_option('Zartis_Group');

    if (IsNullOrEmptyString($group)) {
        // None = 1,
        // Location = 2,
        // Category = 3

        if ($Zartis_Group == 2) {
            $group = 'country';
        }

        if ($Zartis_Group == 2) {
            $group = 'category';
        }
    }

    try {
        // Listen for scripts loading so we can add the module/nomodule type
        add_filter('script_loader_tag', 'add_hirehive_webcomponent_script', 10, 3);

        wp_enqueue_script('hirehive-wc-module', 'https://cdn1.hirehive.com/web-components/wp/job-listings/@latest/dist/hirehive-job-listing/hirehive-job-listing.esm.js', null, false, false);
        wp_enqueue_script('hirehive-wc-nomodule', 'https://cdn1.hirehive.com/web-components/wp/job-listings/@latest/dist/hirehive-job-listing/hirehive-job-listing.js', null, false, false);

        // group-by="category" category="Marketing" country-code="GB"
        $customElement = '<hirehive-job-listing subdomain="' . $companySubdomain . '" group-by="' . $group . '" take="' . $take . '" skip="' . $skip . '" country-code="' . $countryCode . '" category="' . $category . '">';
        if (!IsNullOrEmptyString($content)) {
            $customElement .= '<div slot="no-results">' . $content . '</div>';
        }
        $customElement .= '</hirehive-job-listing>';

        return $customElement;

    } catch (Exception $e) {

        $script = '<!-- Jobs for - ' . $companySubdomain . ' -->';
        $script .= '<!-- Chosen group - ' . $Zartis_Group . ' -->';
        $script .= '<!-- Category - ' . $category . ' -->';
        $script .= '<!-- Version - 2.9.0 -->';

        $script .= '<!--' . $e . message . '-->';

        return $script;
    }
}

function hirehive_settings()
{
    //checks if there is a UrlIdentifier already in the DB
    $Zartis_ID = get_option('Zartis_Unique_ID');
    if ($Zartis_ID != "False") {
        //Shows my.zartis.com
        has_hirehive_account();
    } else {
        //Gets the user to Register/Login
        no_hirehive_account();
    }
}

function has_hirehive_account()
{
    $Company_Zartis_ID = get_option('Zartis_Unique_ID');
    $Token             = substr($Company_Zartis_ID, -20);
    if (substr_count($Token, "-") == 4) {
        $Company_Zartis_ID_REVERSE = strrev($Company_Zartis_ID);
        $Company_Zartis_ID_REVERSE = substr($Company_Zartis_ID_REVERSE, 20);
        $Company_Zartis_ID         = strtolower(strrev($Company_Zartis_ID_REVERSE));
        update_option('Zartis_Unique_ID', $Company_Zartis_ID);
    }
    include("Zartis_Job_Landing.php");
}

function no_hirehive_account()
{
    include("Zartis_Job_Landing.php");
}
