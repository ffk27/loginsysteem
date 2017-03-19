/**
 * Created by Gebruiker on 3/12/2017.
 */

$(document).ready(function () {
    var form=$('#registreerform');
    form.submit(function (e) {
        e.preventDefault();
        validate();
    });
});

function validate() {
    var naam = $('[name="naam"]').val().trim();
    var gebnaam = $('[name="gebnaam"]').val().trim();
    var email = $('[name="email"]').val().trim();
    var ww1 = $('[name="wachtwoord"]').val().trim();
    var ww2 = $('[name="wachtwoordh"]').val().trim();

    var errors = [];

    if (ww1!=ww2) {
        errors[errors.length]=('Fout: wachtwoorden komen niet overeen');
    }

    if (errors.length>0) {
        setErrors(errors);
    }
    else {
        $('#foutmelding').html(null);
        registreer(naam,gebnaam,email,ww1);
    }
}

function registreer(naam,gebnaam,email,ww) {
    $.ajax({
        url: 'controller.php?post=registreer',
        data: {'naam': naam, 'gebnaam': gebnaam, 'email': email, 'ww': ww},
        method: 'POST',
        success: function (json) {
            if (json.antwoordcode>1) {
                setErrors([json.melding]);
            }
            switch (json.antwoordcode) {
                case 1:
                    setContent('login');
                    break;
            }
        },
        dataType: 'json'
    });
}

function setErrors(errors) {
    var html = '<ul>';
    for (var i=0; i<errors.length; i++) {
        html += '<li>' + errors[i] + '</li>';
    }
    html += '</ul>';
    $('#foutmelding').html(html);
}