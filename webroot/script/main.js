$(document).ready(function() {
    var content = window.location.search.substring(1);
	setContent(content);
});

function setContent(p) {
    if (isEmpty(p)) {
        p='index';
    }
	$.get({
		url: 'controllers/controller.php',
		data: {'p': p},
		success: function(json) {
            window.location.search.replace('?'+json.page);
			//todo: remove resource
            if (json.resource.length>0) {
            	for (var i=0; i<json.resource.length; i++) {
            		addResource(json.resource[i].type,json.resource[i].url);
				}
			}
			$('main').html(json.html);
		},
		dataType: 'json',
		async: true
	});
}

function isEmpty(str) {
    return (!str || 0 === str.length);
}

function addResource(type,url) {
    switch (type) {
        case 'script':
            $('head').append('<script src="'+url+'"></script>');
            break;
        case 'style':
            $('head').append('<link rel="stylesheet" href="'+url+'"/>');
            break;
    }
}