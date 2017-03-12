$(document).ready(function() {
	setContent('login');
});

function setContent(p) {
	$.get({
		url: 'controller.php',
		data: {'p': p},
		success: function(html) {
			if (p=='login') {
            	addResource('style','views/style/forms.css');
            	addResource('script','views/script/login.js');
			}
			if (p=='registreer') {
                addResource('style','views/style/forms.css');
                addResource('script','views/script/registreer.js');
            }
			$('main').html(html);
		},
		dataType: 'html',
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
