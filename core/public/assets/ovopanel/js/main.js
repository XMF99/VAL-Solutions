"use strict";

(function($) {
    if (typeof $ === 'undefined') return;

    $(function() {

        // ==============================================
        // SIDEBAR TOGGLE (Mobile)
        // ==============================================
        $('.navigation-bar, .sidebar-menu__close').on('click', function(e) {
            e.preventDefault();
            $('.dashboard__sidebar, .sidebar-menu').toggleClass('active');
            $('.sidebar-overlay').toggleClass('active');
        });

        $('.sidebar-overlay').on('click', function() {
            $('.dashboard__sidebar, .sidebar-menu, .sidebar-overlay').removeClass('active');
        });

        // ==============================================
        // SUBMENU TOGGLE (has-dropdown)
        // ==============================================
        $('.dashboard-nav__items.has-dropdown > .dashboard-nav__link').on('click', function(e) {
            e.preventDefault();
            var parent = $(this).parent();
            parent.siblings('.has-dropdown.open').removeClass('open');
            parent.toggleClass('open');
        });

        // Auto-open if has active child
        $('.sidebar-submenu .dashboard-nav__link.active').each(function() {
            $(this).closest('.has-dropdown').addClass('open');
        });

        // ==============================================
        // HEADER DROPDOWNS (notifications, user)
        // ==============================================
        $('.header-dropdown__icon.dropdown-toggle').on('click', function(e) {
            e.stopPropagation();
            var menu = $(this).siblings('.dropdown-menu');
            $('.dropdown-menu.show').not(menu).removeClass('show');
            menu.toggleClass('show');
        });

        $(document).on('click', function() {
            $('.dropdown-menu.show').removeClass('show');
        });

        $('.dropdown-menu').on('click', function(e) {
            e.stopPropagation();
        });

        // ==============================================
        // PASSWORD SHOW/HIDE
        // ==============================================
        $('.toggle-password').on('click', function() {
            var input = $(this).siblings('input');
            var type = input.attr('type') === 'password' ? 'text' : 'password';
            input.attr('type', type);
            $(this).toggleClass('fa-eye fa-eye-slash');
        });

        // ==============================================
        // CMD+K / CTRL+K SEARCH (Spotlight)
        // ==============================================
        function openSearch() {
            $('.header-search').addClass('open');
            setTimeout(function() {
                $('.header-search input').focus();
            }, 100);
        }
        function closeSearch() {
            $('.header-search').removeClass('open');
            $('.header-search input').val('');
            $('.search-card__item').show();
            $('.search-empty-message').addClass('d-none');
        }

        // Open on click of search trigger
        $('.open-search, .header-search-filed').on('click', function(e) {
            e.preventDefault();
            openSearch();
        });

        // Open on Ctrl+K / Cmd+K
        $(document).on('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                openSearch();
            }
            // Close on Escape
            if (e.key === 'Escape') {
                closeSearch();
            }
        });

        // Close on outside click
        $('.header-search').on('click', function(e) {
            if (e.target === this) closeSearch();
        });

        // Search filter
        $('.header-search input').on('input', function() {
            var q = $(this).val().toLowerCase().trim();
            var items = $('.search-card__item');
            var matched = 0;
            items.each(function() {
                var text = $(this).text().toLowerCase();
                var keyword = ($(this).attr('data-keyword') || '').toLowerCase();
                if (!q || text.includes(q) || keyword.includes(q)) {
                    $(this).show();
                    matched++;
                } else {
                    $(this).hide();
                }
            });
            if (matched === 0) {
                $('.search-empty-message').removeClass('d-none');
            } else {
                $('.search-empty-message').addClass('d-none');
            }
        });

        // Keyboard nav in search
        $(document).on('keydown', function(e) {
            if (!$('.header-search').hasClass('open')) return;
            var items = $('.search-card__item:visible');
            var active = items.filter('.active');
            var idx = items.index(active);

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                items.removeClass('active');
                var next = idx + 1 < items.length ? idx + 1 : 0;
                items.eq(next).addClass('active');
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                items.removeClass('active');
                var prev = idx - 1 >= 0 ? idx - 1 : items.length - 1;
                items.eq(prev).addClass('active');
            } else if (e.key === 'Enter' && active.length) {
                e.preventDefault();
                var link = active.find('a').attr('href');
                if (link) window.location.href = link;
            }
        });

        // ==============================================
        // SELECT2 INIT
        // ==============================================
        if ($.fn.select2) {
            $('.select2').select2({ dir: 'rtl', width: '100%' });
        }

        // ==============================================
        // CSS for dropdown.show
        // ==============================================
        var style = document.createElement('style');
        style.innerHTML = '.dropdown-menu.show { display: block !important; position: absolute; top: 100%; }';
        document.head.appendChild(style);

    });
})(window.jQuery);
