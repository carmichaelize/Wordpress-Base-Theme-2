<?php

$validation_message = "";

if( isset($_POST['submit']) ){

	$passes = true;
	$validation_template = "<div class='alert %s'><i class='fa %s'></i> %s</div>";

	// Verify nonce before proceeding
	if( !isset( $_POST['sc_contact_form_nonce'] ) || !wp_verify_nonce( $_POST['sc_contact_form_nonce'], basename( __FILE__ ) ) ){
		$validation_message = sprintf($validation_template, 'alert-error', 'fa-times-circle', 'Sorry Something went wrong, please try again.');
		$passes = false;
	}

	if( !$_POST['form_name'] || !$_POST['form_email'] || !$_POST['form_message'] ){
		$validation_message = sprintf($validation_template, 'alert-error', 'fa-times-circle', 'Please fill in all fields.');
		$passes = false;
	} elseif( !preg_match('/(^.*@.*$)/', $_POST['form_email']) ){
		$validation_message = sprintf($validation_template, 'alert-error', 'fa-times-circle', 'Please provide a valid email address.');
	 	$passes = false;
	}

	if( $passes ) {
		//Build Message
		$message = 'Name: '.$_POST['form_name']."\n";
		$message .= 'Email: '.$_POST['form_email']."\n";
		$message .= "Message:\n".$_POST['form_message'];

		$validation_message = sprintf($validation_template, 'alert-success', 'fa-check-circle', 'Thank you for your enquiry, we\'ll get back to you soon.');

		//add_filter( 'wp_mail_content_type', 'set_html_content_type' );
		$headers = "From: ".get_bloginfo('name')." <".get_bloginfo('admin_email').">";
		wp_mail(get_bloginfo('admin_email'), "Website Enquiry", $message, $headers );

	}

} else {
	$passes = false;
}

?>

<?php echo $validation_message; ?>

<form id="contact_form" class="form left" method="POST" <?php echo $passes ? 'style="display:none;"' : '' ; ?>>

	<?php wp_nonce_field( basename( __FILE__ ), 'sc_contact_form_nonce' ); ?>

	<label for="contact_name">Name</label>
	<input id="contact_name" type="text" name="form_name" value="<?php echo isset($_POST['form_name']) ? $_POST['form_name'] : '' ; ?>" />

	<br />

	<label for="contact_email">Email</label>
	<input id="contact_email" type="text" name="form_email" value="<?php echo isset($_POST['form_email']) ? $_POST['form_email'] : '' ; ?>" />

	<br />

	<label for="contact_message">Message</label>
	<textarea id="contact_message" name="form_message"><?php echo isset($_POST['form_message']) ? $_POST['form_message'] : '' ; ?></textarea>

	<br />

	<button class="button" name="submit">Submit</button>

</form>

<div class="sidebar right">

	<?php if($global_options->name || $global_options->address) : ?>
		<i class="fa fa-map-marker"></i> <?php echo $global_options->name; ?>
		<br />
		<?php echo nl2br($global_options->address); ?>
		<br />
	<?php endif; ?>

	<?php if($global_options->email) : ?>
		<i class="fa fa-envelope"></i> <a href="mailto:<?php echo $global_options->email; ?>"><?php echo $global_options->email; ?></a>
		<br />
	<?php endif; ?>

	<?php if($global_options->phone) : ?>
		<i class="fa fa-phone"></i> <?php echo $global_options->phone; ?>
		<br />
	<?php endif; ?>

</div>