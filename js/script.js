//Process Wordpress Variables
var isFrontPage = parseInt(ajaxObject.isFrontPage) ? true : false,
	isPage = parseInt(ajaxObject.isPage) ? true : false,
	isSingle = parseInt(ajaxObject.isSingle) ? true : false,
	pageID = parseInt(ajaxObject.pageID),
	postType = ajaxObject.postType;

//Responsive Menu
//$('.responsive-menu-btn').bigSlide({menu: '.responsive-nav', side: 'right', menuWidth: '185px'});


//$("#content").load(url+" #content");

//Load Content Via Ajax
// (function(){
// 	var contentArea = '#content',
// 		ajaxEnabled = true;
// 	if( ajaxEnabled ){
// 		$('body').on('click', 'a', function(){
// 			var url = $(this).attr('href');
// 			$.ajax({
// 				url: url,
// 				type: 'GET'
// 			}).done(function(data){
// 				var content = $(data).find(contentArea).html();
// 				$(contentArea).css({marginTop: 1000}).html(content).animate({marginTop: '0'}, 500);
// 				//$(contentArea).hide().html(content).fadeIn();
// 				return false;
// 			}).fail(function(data){
// 				console.log('Page Load Fail');
// 				return false;
// 			});
// 			return false;
// 		});
// 	}

// }());