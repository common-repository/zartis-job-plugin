=== Plugin Name ===
Contributors: noel_zartis
Donate link: https://hirehive.com
Tags: jobs, job, career, manager, vacancy, hiring, hire, listing, recruiting, recruitment, ats, employer, application, board
Requires at least: 2.9
Tested up to: 5.8.0
Stable tag: 2.9.0

Easily add job listings and secure candidate management to your Wordpress site.

== Description ==

= Prices start from $49 per month =

= Hiring made easy =

*Recruiting software that helps you find and
hire the best candidates.*

Have your own jobs page directly in your WordPress site. Easily add and edit your job vacancies and securely manage candidates that apply for these jobs all in one online app.

The HireHive Job Plugin lets you quickly and easily create your own jobs page and automate much of the recruitment process.

= Features =
* Customize how your job page looks on your WordPress site
* All candidates profiles are stored in one central place. No more searching for email attachments!
* Post jobs to all major job boards with just one click
* Your very own branded careers site
* Easily tweet your job positions
* Easily put your jobs into Facebook

When candidates apply for a role, you will receive a notification email and they receive an immediate acknowledgment.

You can then log in to HireHive and view their application and manage them through the recruitment process.

For more information see: https://hirehive.com

== Installation ==

This section describes how to install the plugin and get it working.

1. Download HireHive Job Plugin.
2. Activate "Jobs from HireHive" in the "Plugins" admin panel using the Activate link.
3. Create your account through the Sign Up page. If you already have a HireHive account you can just login with your existing details.
4. Just copy the shortcode given to you into any page where you want the jobs list to appear.
5. The job listing will automatically use your sites theme and colouring

== Screenshots ==

1. An example of jobs in a WordPress site

== Frequently Asked Questions ==

= Do I need an existing HireHive account? =

If you have an existing HireHive account you can log in with those details. If you don't have an account you can sign up for a new one from within the Plugin. It takes approximately 60 seconds.

= Where can I get support questions answered? =

email support@hirehive.com

== Changelog ==
= 1.0 =
* Initial Release

= 1.0.1 =
* Fixed JQuery conflicts
* Fixed CSS styles overriding global styles
* Minor text changes

= 1.0.2 =
* Minor style updates
* Add FAQ to the Zartis Jobs tab in the WordPress Admin

= 1.1 =
* Redesign of admin dashboard
* Added use of shortcode
* Added option to change width of job listings

= 2.0 =
* Redesign of admin dashboard
* Rebranded to HireHive
* Added option to change grouping of jobs (Location/Categories)

= 2.1 =
* Added option to only show a category of jobs so they can be place on certain pages

= 2.2 =
* Bug fix for $atts null

= 2.2.1 =
* Bug fix for characters with an umlaut or accent to appear

= 2.2.2 =
* Minor text change

= 2.3.0 =
* Added more exception handling
* Added a fallback if JSON fails

= 2.3.1 =
* Added informational output to page when rendering
* Can add a HireHive token using an input box

= 2.3.2 =
* Added a fallback for file_get_contents not working

= 2.3.3 =
* Check if group name is not empty before adding the h3 tag

= 2.3.4 =
* Don't throw an error is JSON_DECODE is null

= 2.4.0 =
* Remove jQuery dependency
* Updated style layout to use flexbox
* Added StateCode to the job list row

= 2.4.1 =
* Fixed missing js file

= 2.5.0 =
* Bump version for update prompt

= 2.6.0 =
* If styles aren't added then add them inline, can happen on custom themes missing wp_head

= 2.6.1 =
* Always inline styles when printing the job list

= 2.6.2 =
* Fix to ensure the token field is updated on activation

= 2.7.0 =
* Allow multiple accounts via the shortcode eg [hirehive_jobs company="NAME_HERE"]

= 2.8.0 =
* Use wp_remote_get function to get list of jobs and better handling of query parameters

= 2.9.0 =
* Update domain for api endpoint and use a web component to list jobs