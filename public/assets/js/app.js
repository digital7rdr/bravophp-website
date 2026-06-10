(function () {
  var body = document.body;
  var toggle = document.getElementById('nav-toggle');
  var openBtn = document.getElementById('nav-open');
  var overlay = document.getElementById('nav-overlay');
  var chevron = document.getElementById('nav-chevron');

  try { if (localStorage.getItem('navCollapsed') === '1') body.classList.add('nav-collapsed'); } catch (e) {}

  function syncChevron() {
    if (chevron) chevron.style.transform = body.classList.contains('nav-collapsed') ? 'rotate(180deg)' : '';
  }
  syncChevron();

  if (toggle) toggle.addEventListener('click', function () {
    if (window.innerWidth < 1024) { body.classList.remove('nav-open'); return; }
    body.classList.toggle('nav-collapsed');
    try { localStorage.setItem('navCollapsed', body.classList.contains('nav-collapsed') ? '1' : '0'); } catch (e) {}
    syncChevron();
  });

  if (openBtn) openBtn.addEventListener('click', function () { body.classList.add('nav-open'); });
  if (overlay) overlay.addEventListener('click', function () { body.classList.remove('nav-open'); });

  document.querySelectorAll('#sidebar a').forEach(function (a) {
    a.addEventListener('click', function () { if (window.innerWidth < 1024) body.classList.remove('nav-open'); });
  });

  // Request panel service tabs
  var tabWrap = document.querySelector('[data-tabs]');
  if (tabWrap) {
    var tabs = tabWrap.querySelectorAll('[data-tab]');
    var hidden = document.getElementById('reqServiceType');
    tabs.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var key = btn.getAttribute('data-tab');
        if (hidden) hidden.value = key;
        tabs.forEach(function (b) {
          var on = b === btn;
          b.classList.toggle('text-white', on);
          b.classList.toggle('text-t-muted', !on);
          var u = b.querySelector('.tab-underline');
          if (u) u.classList.toggle('hidden', !on);
        });
        document.querySelectorAll('[data-fields]').forEach(function (g) {
          g.classList.toggle('hidden', g.getAttribute('data-fields') !== key);
        });
      });
    });
  }
})();
