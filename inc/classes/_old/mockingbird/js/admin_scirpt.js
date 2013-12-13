jQuery(document).ready(function($){

	//Remove No JS Message
	$('.sc-nojs-message').remove();

	//jQuery Sortable / Change Item Order
    $('.sc-mockingbird-container').sortable({ appendTo: document.body });

	//Add Item
	$('.sc-mockingbird-selectbox').on('change', function(){

		var $selectBox = $(this),
			$container = $selectBox.parents('.inside'),
			$selectionList = $container.find('.sc-mockingbird-container'),
			value = $selectBox.val(),
			label = $.trim($selectBox.children('option[value=' + value + ']').text());

		if(value){

			//Prepare and Add New Item to List
			var newItem = $($selectionList.find('.sc-mockingbird-template').html());
			newItem.children('input.sc-title-input, input.sc-original-input').val(label);
			newItem.children('span.sc-mockingbird-label').text( label.length > 27 ? label.substring(0, 27) + '...' : label );
			newItem.children('input.sc-id-input').val(value);
			newItem.appendTo($selectionList).fadeIn();

			//Disable Selected Option, Reset Select Box
			$selectBox.children('option[value=' + value + ']').prop('disabled', 'disabled');
			$selectBox.children('option:first-child').attr('selected', true).blur();

		}

		return false;

	});

	//Remove Item
	$('.sc-mockingbird-container').on('click', 'span.remove', function(){

		var $item = $(this).parent('li'),
			$selectBox = $item.parents('.inside').find('.sc-mockingbird-selectbox');

		//Fade Out, Remove Item From List
		$item.fadeOut(300, function(){
			$(this).remove();
		});

		//Reactivate Option to Select Box
		$selectBox.children('option[value=' + $(this).siblings('input.sc-id-input').val() + ']').removeAttr('disabled');

		return false;

	});

	//Rename Item
	$('.sc-mockingbird-container').on('click', '.sc-mockingbird-label', function(){

		var $item = $(this),
			$titleInput = $item.siblings('.sc-title-input');

		$item.text('').hide();
		$titleInput.prop('type', 'text').focus();

		return false;

	});

	$('.sc-mockingbird-container').on('blur', '.sc-title-input', function(){

		var $titleInput = $(this),
			$titleOriginalInput = $titleInput.siblings('.sc-original-input'),
			$titleLabel = $titleInput.siblings('.sc-mockingbird-label'),
			value = $titleInput.val() != '' ? $titleInput.val() : $titleOriginalInput.val();

		//Hide Input, Fade-in Label
		$titleLabel.fadeIn(150, function(){
			$titleInput.val(value).prop('type', 'hidden');
			value = value.length > 27 ? value.substring(0, 27) + '...' : value ;
			$titleLabel.text(value);
		});

		return false;

	});


    //Filter Tab
    // $('.sc-mockingbird-filter-btns li').on('click', function(){

    // 	var button = $(this),
    // 		selected = button.parents('.inside').find('.sc-mockingbird-filter-selects li[data-type=' + button.attr('data-type') + ']');

    // 	button.addClass('active').siblings('li').removeClass('active');
    // 	selected.show().siblings('li').hide();
    // 	return false;

    // });

    //Filter Tabs
    $('.sc-mockingbird-filter-btns li').on('click', function(){

    	var $button = $(this),
    		$container = $button.parents('.inside'),
    		$select = $container.find('.sc-mockingbird-selectbox'),
    		$loadingImage = $container.find('.sc-loading-image'),
    		postType = $button.attr('data-type'),
    		idArray = [],
    		selectOptions = "";

		//Return If Tab Already Active
		if( $button.hasClass('active') ){
			return false;
		}

		//Disable Select, Show Loading Indicator, Apply Active Class To Tab
		$button.addClass('active').siblings('li').removeClass('active');
		$select.attr('disabled', 'disabled');
		$loadingImage.show();

		//Populate Set Id Array
		$container.find('.sc-mockingbird-container .sc-id-input').each(function(){
			idArray.push(parseInt($(this).val()));
		});

		//Clear Select Box
		$select.html("");

		if( postType.split(',').length > 1 ){
			var postTypeName = 'All'
		} else {
			var postTypeName = postType.charAt(0).toUpperCase() + postType.slice(1);
			postTypeName += postType.slice(-1) == 's' ? '' : 's';
		}

		$select.append("<option value=''>- - Select "+postTypeName+" - -</option>");

		//Query Post Type
    	$.ajax({
			url: AjaxObject.ajaxurl,
			data: {
				action: 'sc_mockingbird_search',
				posttype: postType
			},
			type: 'post',
			dataType: 'json'
		}).done(function(data, status, response){

			// Re-activate Select Box, Hide Loading Indicator
			$select.removeAttr('disabled');
			$loadingImage.hide();

			//Build List
			if(data.length > 0){
				for(i=0; i<data.length;i++){
					var display = $.inArray(parseInt(data[i].ID), idArray) == -1 ? '' : 'disabled="disabled"';
					selectOptions += '<option '+display+' value="'+data[i].ID+'">';
					//selectOptions += data[i].post_title.length > 30 ? data[i].post_title.substr(0, 30)+"..." : data[i].post_title;
					selectOptions += data[i].post_title;
					selectOptions += '</option>';
				}
			} else {
				$select.attr('disabled', 'disabled').html("<option value=''>-- No "+postTypeName+" Available --</option>");
			}

			//Add Option(s)
			$select.append(selectOptions);

		}).fail(function(data, status, response){

			$select.attr('disabled', 'disabled').html("<option value=''>-- No "+postTypeName+" Available --</option>");

		});

    	return false;

    });


});