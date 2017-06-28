/**
 * Created by Topicus on 28-6-2017.
 */
function sendOtpCode() {
    const code = $('#input_otpcode').val();
    vert(code);
}

function vert(code) {
    $.ajax({
        url: '../controller.php?c=otp&a=vert&i=' + code,
        success: function(json) {
            if (json.success) {
                setContent('index');
            } else {
                $('#otp_error').html('Code is ongeldig');
            }
        },
        method: 'GET',
        dataType: 'json'
    });
}