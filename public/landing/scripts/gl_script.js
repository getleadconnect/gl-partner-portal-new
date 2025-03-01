
$('.side-col .show-signup-form').click(function() {
    $('#sign-up-form').show(500);
    $('#login-form').hide(0);
});
$('.side-col .sign-up-cancel').click(function() {
    $('#login-form').show(500);
    $('#sign-up-form').hide(0);
});