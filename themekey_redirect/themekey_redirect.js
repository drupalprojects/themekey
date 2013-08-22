jQuery(document).ready(function($) {
    var state = $.cookie('themekey_redirect_state');
    if (state != 1 && state != 2) {
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
    }
    else if (state == 1) {
        $('#block-themekey-redirect-domain-selector').show();
        $.cookie('themekey_redirect_state', 2, { path: '/'});
    }
});
