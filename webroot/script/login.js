$(document).ready(function() {
	$('#inlogknop').click(function() {
		var gebruikersnaam = $('[name="gebruikersnaam"]').val();
		var wachtwoord = $('[name="wachtwoord"]').val();

		if (isEmpty(gebruikersnaam)) {
            zetFoutmelding("Fout: Gebruikersnaam niet ingevuld.");
		}
		else if (isEmpty(wachtwoord)) {
            zetFoutmelding("Fout: Wachtwoord niet ingevuld.");
		}
		else {
			var captcha = '';
			var captchafield = $('[name="g-recaptcha-response"]');

            if (captchafield.length>0) {
                captcha=captchafield.val();
				if (isEmpty(captcha)) {
                    zetFoutmelding("Fout: Verifieer dat u geen robot bent.");
                }
			}
			if (captchafield.length===0 || (captchafield.length>0 && !isEmpty(captcha))) {
                login(gebruikersnaam,wachtwoord,captcha);
            }
        }
	});
});

function login(gebruikersnaam,wachtwoord,captcha) {
	$.ajax({
		url: '../controller.php?c=login&a=POST',
		data: {'gebruiker': gebruikersnaam, 'ww': wachtwoord, 'g-recaptcha-response': captcha},
		success: function(json) {
			if (json.antwoordcode>1) {
                zetFoutmelding(json.melding);
            }
			switch (json.antwoordcode) {
				case 1:
					setContent('index');
                    break;
				case 3:
                    if ($('#captcha').html().trim() === '') {
						$.get({ 
							url: '../controller.php',
							data: {'html': 'captcha'},
							success: function(html) {
								$('#captcha').html(html);
							}, 
							dataType: 'html',
							async: true
						});
					}
					break;
				case 4:
                    grecaptcha.reset();
                    break;
			}
		},
		method: 'POST',
		dataType: 'json'
	});
}

function zetFoutmelding(fout) {
    $('#foutmelding').html(fout);
}