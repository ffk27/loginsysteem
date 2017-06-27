/**
 * Created by ffk27 on 27-6-2017.
 */
function enable() {
    $.ajax({
        url: '../controller.php?c=twofactor&a=enable',
        success: function(json) {
            if (json.uri) {
                //$('#uriimg').html('<img src=\'\''>;
            }
        },
        method: 'GET',
        dataType: 'json'
    });
}