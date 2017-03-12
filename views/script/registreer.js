/**
 * Created by Gebruiker on 3/12/2017.
 */
$(document).ready(function () {
    $('#registreerknop').click(function () {
        validate();
    });
});

function validate() {
    var naam = $('[name="naam"]').val().trim();
    var gebnaam = $('[name="gebnaam"]').val().trim();
    var email = $('[name="email"]').val().trim();
    var ww1 = $('[name="wachtwoord"]').val().trim();
    var ww2 = $('[name="wachtwoordh"]').val().trim();

    if (isEmpty(naam) || isEmpty(gebnaam) || isEmpty(email) || isEmpty(ww1) || isEmpty(ww2)) {
        zetFoutmelding('Fout: vul alle velden in.');
    }
    else if (naam.length<2 || naam.length>45) {
        zetFoutmelding('Fout: naam moet tussen 2 tot 45 tekens zijn.');
    }
    else if (gebnaam.length<2 || gebnaam.length>30) {
        zetFoutmelding('Fout: gebruikersnaam moet tussen 2 tot 30 tekens zijn.');
    }
    else if (email.length<6 || email.length>254) {
        zetFoutmelding('Fout: e-mailadres moet tussen 2 tot 254 tekens zijn.');
    }
    else if (ww1 != ww2) {
        zetFoutmelding('Fout: wachtwoorden komen niet overeen.');
    }
    else if (ww1==ww2) {

    }
    else {
        registreer(naam,gebnaam,email,ww1);
    }
}

function registreer(naam,gebnaam,email,ww) {
    $.ajax({
        url: 'controllers/registreer.php',
        data: {'naam': naam, 'gebnaam': gebnaam, 'email': email, 'ww': ww},
        method: 'POST',
        success: function (json) {

        },
        dataType: 'json'
    });
}

function zetFoutmelding(fout) {
    $('#foutmelding').html(fout);
}