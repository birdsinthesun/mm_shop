(function($) {
  $.fn.mmShopDropdown = function(options) {
    const settings = $.extend({
      submenuSelector: 'ul',
      toggleSelector: '[data-toggle="submenu"]',
      animationSpeed: 200,
      focusClass: 'focus'
    }, options);

    return this.each(function() {
      const $nav = $(this);

      // Fokus sichtbar machen
      $nav.find('a').on('focus', function() {
        $(this).parents('li').addClass(settings.focusClass);
      }).on('blur', function() {
        $(this).parents('li').removeClass(settings.focusClass);
      });

      // Dropdown öffnen/schließen
      $nav.find(settings.toggleSelector).on('click', function(e) {
        e.preventDefault();
        const $toggle = $(this);
        const $submenu = $toggle.next(settings.submenuSelector);

        const isVisible = $submenu.is(':visible');

        $nav.find(settings.submenuSelector).slideUp(settings.animationSpeed).attr('aria-hidden', 'true');
        $nav.find(settings.toggleSelector).attr('aria-expanded', 'false');

        if (!isVisible) {
          $submenu.slideDown(settings.animationSpeed).attr('aria-hidden', 'false');
          $toggle.attr('aria-expanded', 'true');
        }
      });
      $nav.find('li').has('ul').hover(
          function() {
            $(this).children('ul').first().stop(true, true).fadeIn(200).attr('aria-hidden', 'false');
          },
          function() {
            $(this).children('ul').first().stop(true, true).fadeOut(200).attr('aria-hidden', 'true');
          }
        );

      // Schließen beim Klick außerhalb
      $(document).on('click', function(e) {
        if (!$(e.target).closest($nav).length) {
          $nav.find(settings.submenuSelector).slideUp(settings.animationSpeed).attr('aria-hidden', 'true');
          $nav.find(settings.toggleSelector).attr('aria-expanded', 'false');
        }
      });
    });
  };
})(jQuery);
 $(function() {
    $('#main-dropdown-nav').mmShopDropdown();
  });