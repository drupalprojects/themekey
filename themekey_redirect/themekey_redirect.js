(function ($) {
    $.ajax({
        // add the current path and query to the url for ThemeKey's rule matching
        url: '/themekey/redirect_callback' + window.location.pathname + window.location.search,
        dataType: 'json',
        type: 'GET',
        success: function(target) {
            if (target) {
                window.location.href = target;
            }
        }
    });
})(jQuery);
