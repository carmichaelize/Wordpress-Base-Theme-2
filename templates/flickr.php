<?php

	// Key: 58f93e0e393a13702c9e6d485c894838
	// Secret: ef8f9a01aa8ea1a6

	$flickr = get_transient( 'sc_flickr_list' );

	if( !$flickr ){

		$api_key = '58f93e0e393a13702c9e6d485c894838';
		$photoset_id = '72157638610407105';
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

		$response = (object)wp_remote_get("http://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key={$api_key}&format=json&nojsoncallback=1&photoset_id={$photoset_id}{$extras}");
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