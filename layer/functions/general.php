<?php

function sanitize ($data){
	$db = $GLOBALS['db_connect'];
	return $db->real_escape_string($data);
}

function output_error ($errors){
	$output =array ();
	
	foreach($errors as $error){
		$output[] =  $error;
	}
	return join('',$output);
}

function contact_us_email($email_to, $first_name, $last_name, $email_from, $subject,$comments ){
	// CHANGE THE TWO LINES BELOW
	$email_to = "bakhshb@gmail.com";
	$email_subject = "website html form submissions";
	$email_message .= "First Name: ".$first_name."\n";
	$email_message .= "Last Name: ".$last_name."\n";
	$email_message .= "Email: ".$email_from."\n";
	$email_message .= "Subject: ".$subject."\n";
	$email_message .= "Comments: ".$comments."\n";
	// create email headers
	$headers = 'From: '.$email_from."\r\n".
	'Reply-To: '.$email_from."\r\n" .
	'X-Mailer: PHP/' . phpversion();
	@mail($email_to, $email_subject, $email_message, $headers);  
}
?>