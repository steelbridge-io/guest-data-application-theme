
    grecaptcha.ready(function() {
    grecaptcha.execute('6Lf-pYQqAAAAACH2PMrn77ojtGqtJ27peYjCHGdz', {action: 'homepage'}).then(function(token) {
        // Add the token to your form
        var loginForm = document.querySelector('.login-form form');
        var registerForm = document.querySelector('.registration-form form');

        var recaptchaLoginField = document.createElement('input');
        recaptchaLoginField.setAttribute('type', 'hidden');
        recaptchaLoginField.setAttribute('name', 'recaptcha_response');
        recaptchaLoginField.setAttribute('value', token);
        loginForm.appendChild(recaptchaLoginField);

        var recaptchaRegisterField = document.createElement('input');
        recaptchaRegisterField.setAttribute('type', 'hidden');
        recaptchaRegisterField.setAttribute('name', 'recaptcha_response');
        recaptchaRegisterField.setAttribute('value', token);
        registerForm.appendChild(recaptchaRegisterField);
    });
});
