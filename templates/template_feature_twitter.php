<?php

	$tweets = get_transient( 'sc_tweet_list' );

	if( !$tweets ){

		include(dirname(__FILE__).'/../inc/classes/oath/tmhOAuth.php');

		//Account Token (Log into Twitter Developers Account)
		$tmhOAuth = new tmhOAuth(array(
		  'host' => 'api.twitter.com',
		  'consumer_key'    => '',
		  'consumer_secret' => '',
		  'user_token'      => '',
		  'user_secret'     => ''
		));

		$query_options = array(
				'screen_name'     => '',
				'count'		      => 3,
				'exclude_replies' => true,
				'include_rts'	  => true
			);

		$tmhOAuth->request('GET', $tmhOAuth->url('1.1/statuses/user_timeline'), $query_options);

		$response = $tmhOAuth->response;

		$tweets = json_decode($response['response']);

		//Cache Response
		if( $tweets && is_array( $tweets ) ){
			set_transient( 'sc_tweet_list', $tweets, 60*60 );
		}

	}

?>

<?php if($tweets) : ?>

	<h3 class="tweet-list-head calendar-head">
		<a target="_blank" href="https://twitter.com/<?php echo $tweets[0]->user->screen_name; ?>">Latest Tweets</a>
	</h3>

	<ul class="no-list tweet-list">

		<?php foreach( $tweets as $tweet) : ?>

			<li>
				<?php
					$string = preg_replace('/(http[^\s]+)/', '<a target="_blank" class="tweet-link" href="$1">$1</a>', $tweet->text);
					echo preg_replace('/#([^\s|,|.]+)/', '<a title="#$1" target="_blank" href="https://twitter.com/search?q=%23$1&src=hash" class="tweet-hashtag">#$1</a>', $string);
				?>
			</li>

		<?php endforeach; ?>

	</ul>

<?php endif; ?>