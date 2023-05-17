@if(env('GOOGLE_RECAPTCHA_KEY'))
<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
<script
    src="https://www.google.com/recaptcha/api.js?onload=ReCaptchaCallbackV3&render={{  env('GOOGLE_RECAPTCHA_KEY') }}"
    async defer></script>
<script>
    var ReCaptchaCallbackV3 = function() {
    grecaptcha.ready(function() {
        setInterval(function() {
            if(!$('#g-recaptcha-response').val()){
                grecaptcha.execute("{{  env('GOOGLE_RECAPTCHA_KEY') }}", {action:'validate_captcha'}).then(function(token) {
                    $('#g-recaptcha-response').val(token);
                });
            }
        }, 1000);
    });
};
</script>
@endif
