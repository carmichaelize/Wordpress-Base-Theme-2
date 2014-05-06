//Get Dynamic Variables
var wp_version = screenwriter_js_object.wp_version,
    selector = screenwriter_js_object.selector,
	directory = screenwriter_js_object.directory,
	config = screenwriter_js_object.config,
	count = parseInt(screenwriter_js_object.count);

//Init Editors
tinymce.init({
    selector: "textarea."+selector,
    content_css : directory+"/css/inline.css",
    resize: config.resize,
    width: config.width,
    height : config.height,
    statusbar : config.statusbar,
    menubar : config.menubar,
    plugins: config.plugins,
    toolbar: config.toolbar
});

//Fix Custom WP Errors Pre 3.9
if( parseFloat(wp_version) < 3.9 ){
    tinymce.DOM.files = function(){};
    tinymce.DOM.events.add = function(){};
    tinymce.onAddEditor = {add: function(){}};
}