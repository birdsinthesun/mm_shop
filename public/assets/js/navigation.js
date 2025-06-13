(function($) {
  $.fn.mmShopDropdown = function(options) {
    const settings = $.extend({
      submenuSelector: '.dropdown-1',
      submenuSelector2: '.dropdown-2',
      toggleSelector: '[data-toggle="submenu-1"]',
      toggleSelector2: '[data-toggle="submenu-2"]',
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
      // Dropdown öffnen/schließen 2
      $nav.find(settings.toggleSelector2).on('click', function(e) {
        e.preventDefault();
        const $toggle = $(this);
        const $submenu = $toggle.next(settings.submenuSelector2);

        const isVisible = $submenu.is(':visible');
        
        $nav.find(settings.submenuSelector2).fadeOut(settings.animationSpeed).hide().attr('aria-hidden', 'true');
        $nav.find(settings.toggleSelector2).attr('aria-expanded', 'false');

        if (!isVisible) {
          $submenu.fadeIn(settings.animationSpeed).show().attr('aria-hidden', 'false');
          $toggle.attr('aria-expanded', 'true');
        }
      });
      

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
     
     
        $('#menu-toggler').click(function(){
            $('#main-mobile-nav').toggle();
            });
     
    
        $('#main-dropdown-menu').mmShopDropdown();
     
    
  });