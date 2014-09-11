<?php

	$flickr = get_transient( 'sc_flickr_list' );

	if( !$flickr ){

		$api_key = '';
		$photoset_id = '';
		$extras ='&extras=url_sq,url_t,url_s,url_m,url_o';

		//extras (Optional)
    	//license,
    	// date_upload,
    	// date_taken,
    	// owner_name,
    	// icon_server,
    	// original_format,
    	// last_update,
    	// geo,
    	// tags,
    	// machine_tags,
    	// o_dims,
    	// views,
    	// media,
    	// path_alias,
    	// url_sq,
    	// url_t,
    	// url_s,
    	// url_m,
    	// url_o

		//$flickr = array();

		$response = (object)wp_remote_get("https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key={$api_key}&format=json&nojsoncallback=1&photoset_id={$photoset_id}{$extras}");
		$response = json_decode($response->body);

		$flickr = $response->photoset->photo;

		// //Cache Response
		if( $flickr && is_array( $flickr ) ){
			set_transient( 'sc_flickr_list', $flickr, 60*60 );
		}

	}

?>

<div class="flickr-feed">

<?php foreach( $flickr as $image) : ?>

	<img  src="<?php echo $image->url_s; ?>" />

<?php endforeach; ?>

</div>