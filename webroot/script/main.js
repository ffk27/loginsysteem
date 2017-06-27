var currentResources = [];

$(document).ready(function() {
    var page = window.location.hash.substring(2);
	setContent(page);
});

function setContent(c) {
	$.get({
		url: 'controller.php',
		data: {'c': c},
		success: function(data) {
		    if (data.html) {
                window.location.hash = '#/' + data.page;
                loadResources(data.resource);
                $('main').html(data.html);
            } else {
                $('main').html(data);
            }
        },
		dataType: 'json'
	}).fail(function (data) {
	    let html = 'Fout: ' + data.status + ' ' + data.statusText;
	    html += data.responseText;
        $('main').html(html);
    });
}

function isEmpty(str) {
    return (!str || 0 === str.length);
}

function hasAsCurrentResource(resource) {
    for (let i = 0; i < currentResources.length; i++) {
        if (currentResources[i].type === resource.type && currentResources[i].url === resource.url) {
            return i;
        }
    }
    return -1;
}

function loadResources(resources) {
    for (let resource of resources) {
        const index = hasAsCurrentResource(resource);
        if (index !== -1) {
            currentResources.splice(index, 1);
        } else {
            addResource(resource)
        }
    }
    removeResources(currentResources);
    currentResources = resources;
}

function removeResources(resources) {
    for (let resource of resources)  {
        removeResource(resource);
    }
}

function removeResource(resource) {
    let tagName;
    let url;
    //console.log(resource);
    switch (resource.type) {
        case 'script':
            tagName = 'SCRIPT';
            url = 'src';
            break;
        case 'style':
            tagName = 'LINK';
            url = 'href';
            break;
    }
    for (let i = 0; i < document.head.children.length; i++) {
        let element = document.head.children[i];
        let resurl = resource.url;
        if (resurl.substr(0,7) !== 'http://' || resurl.substr(0,8) !== 'https://') { resurl = location.origin + '/' + resource.url; }
        if (element.tagName === tagName && element[url] === resurl) {
            document.head.removeChild(element);
            break;
        }
    }
}

function addResource(resource) {
    switch (resource.type) {
        case 'script':
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = resource.url;
            document.head.appendChild(script);
            break;
        case 'style':
            var style = document.createElement('link');
            style.rel = 'stylesheet';
            style.type = 'text/css';
            style.href = resource.url;
            document.head.appendChild(style);
            break;
    }
}
