/**
 * Created by ffk27 on 27-6-2017.
 */
function enable() {
    $.ajax({
        url: '../controller.php?c=twofactor&a=enable',
        success: function(json) {
            if (json.uri) {
                let html = `<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${json.uri}">`;
                html += '<p>Scan deze QR-code met de FreeOTP-app op uw telefoon</p>';
                html += '<button onclick="setContent(\'\')">Klaar</button>';
                $('#otpcontent').html(html);
                $('#btn_enableotp').hide();
            }
        },
        method: 'GET',
        dataType: 'json'
    });
}

function disable() {
    $.ajax({
        url: '../controller.php?c=twofactor&a=disable',
        success: function(json) {
            if (json.disabled) {
                $('#btn_disableotp').hide();
                html = '<p>Succesvol uitgeschakeld</p>';
                html += '<a href="#" onclick="setContent(\'\')">Ga terug</a>';
                $('#otpcontent').html(html);
            }
        },
        method: 'GET',
        dataType: 'json'
    });
}