jQuery(document).ready(function($) {
    $(document).on('click', 'a.custom-logout', function(e) {
        e.preventDefault();             // Prevent the default behavior
        var logoutUrl = $(this).attr('href'); // Get the original logout URL
        window.location.href = logoutUrl;     // Redirect immediately
    });
});