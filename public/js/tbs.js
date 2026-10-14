(function () {
    'use strict';

    // Material ripple on buttons
    document.addEventListener('pointerdown', function (event) {
        var target = event.target.closest('.btn, .seat, .demo-account');
        if (!target || target.disabled) return;

        var rect = target.getBoundingClientRect();
        var size = Math.max(rect.width, rect.height) * 2;
        var ripple = document.createElement('span');
        ripple.className = 'ripple';
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = (event.clientX - rect.left - size / 2) + 'px';
        ripple.style.top = (event.clientY - rect.top - size / 2) + 'px';
        target.appendChild(ripple);
        ripple.addEventListener('animationend', function () { ripple.remove(); });
    });

    // Mobile navigation
    var toggle = document.querySelector('[data-nav-toggle]');
    var nav = document.getElementById('site-nav');
    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            var open = nav.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    // Close the account menu on outside click or Escape
    document.addEventListener('click', function (event) {
        document.querySelectorAll('details.menu[open]').forEach(function (menu) {
            if (!menu.contains(event.target)) menu.removeAttribute('open');
        });
    });
    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') return;
        document.querySelectorAll('details.menu[open]').forEach(function (menu) {
            menu.removeAttribute('open');
        });
    });

    // Dialogs
    document.querySelectorAll('[data-dialog-open]').forEach(function (opener) {
        opener.addEventListener('click', function (event) {
            var dialog = document.getElementById(opener.getAttribute('data-dialog-open'));
            if (!dialog || !dialog.showModal) return;
            event.preventDefault();
            dialog.showModal();
        });
    });
    document.querySelectorAll('[data-dialog-close]').forEach(function (closer) {
        closer.addEventListener('click', function () { closer.closest('dialog').close(); });
    });
    document.querySelectorAll('dialog[data-open-on-load]').forEach(function (dialog) {
        if (dialog.showModal) dialog.showModal();
    });

    // Buttons that should not be pressed twice
    document.querySelectorAll('form[data-once]').forEach(function (form) {
        form.addEventListener('submit', function () {
            var button = form.querySelector('button[type="submit"]');
            if (button) {
                button.disabled = true;
                if (button.dataset.busy) button.textContent = button.dataset.busy;
            }
        });
    });
})();
