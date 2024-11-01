function HireHive_Message() {
  setTimeout('Display_Message()', 700);
}

function fadeIn(el) {
  el.style.opacity = 0;

  var last = +new Date();
  var tick = function () {
    el.style.opacity = +el.style.opacity + (new Date() - last) / 400;
    last = +new Date();

    if (+el.style.opacity < 1) {
      (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16);
    }
  };

  tick();
}

function Display_Message() {
  var p = document.querySelector('[class*=Zartis_Menu]');

  var rect = p.getBoundingClientRect();

  var offset = {
    top: rect.top + document.body.scrollTop,
    left: rect.left + document.body.scrollLeft
  };

  var left = p.offsetWidth + offset.left;
  var top = offset.top;

  var body = document.querySelector('body');
  var bubble = document.createElement('div');
  bubble.innerHTML = "Now sign up to install jobs on your site. <div class='zar_message_arrow'> </div>";
  bubble.classList.add('zar_info-txt');  

  body.insertBefore(bubble, body.firstChild);
  
  bubble.style.top = top + 'px';
  bubble.style.left = left + 'px';
  
  fadeIn(bubble);

  setTimeout(function () {
    bubble.style.display = 'none';
  }, 3000);
}

document.addEventListener("DOMContentLoaded", function () {

  var saveBtn = document.querySelector('.zar_next');

  if (saveBtn != null) {
    saveBtn.addEventListener('click', function (event) {
      var Val = document.getElementById('Zartis_Unique_ID').value;
      if (Val.length == 0) {
        document.querySelector('div.hint').style.display = '';
        event.preventDefault();
      }
    });
  }

  function HireHive_Preview() {

    var exampleLists = document.querySelectorAll('.hh-list');
    Array.prototype.forEach.call(exampleLists, function (el, i) {
      el.style.display = 'none';
    });

    var selected = document.getElementById('hirehive-group').value;

    document.getElementById('jobs-' + selected).style.display = '';
  }

  var grpOption = document.getElementById('hirehive-group');

  if (grpOption != null) {
    grpOption.addEventListener('change', function () {
      HireHive_Preview();
    });
  }

  var catOption = document.getElementById('hirehive-categories');

  if (catOption != null) {
    catOption.addEventListener('change', function () {
      HireHive_Category_Preview();
    });
  }

  function HireHive_Category_Preview() {
    var selected = document.getElementById('hirehive-categories').value;

    document.getElementById('hh-code').innerHTML = '[hirehive_jobs category="' + selected + '"]';
  }

  var tabContents = document.querySelectorAll('.tab_content');
  Array.prototype.forEach.call(tabContents, function (el, i) {
    el.style.display = 'none';
  });

  var firstTab = document.querySelector('ul.tabs li');
  var firstTabContent = document.querySelector('.tab_content');

  if (firstTab != null) {
    firstTab.classList.add('active');
    firstTabContent.style.display = '';
  }

  var tabs = document.querySelectorAll('ul.tabs li');
  Array.prototype.forEach.call(tabs, function (el, i) {
    el.addEventListener('click', function () {

      Array.prototype.forEach.call(tabs, function (el, i) {
        el.classList.remove('active');
      });

      el.classList.add('active');

      Array.prototype.forEach.call(tabContents, function (el, i) {
        el.style.display = 'none';
      });

      var tabId = el.querySelector('a').attributes.href.value;

      document.querySelector(tabId).style.display = '';

      if (tabId == '#tab2') {
        HireHive_Preview();
      }

    })
  });

});