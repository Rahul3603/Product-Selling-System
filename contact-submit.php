<?php
require('connection.php');
require('admin/functions.php');
if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['msg']))
{
	
	$name=get_safe_value($_POST['name']);
	$email=get_safe_value($_POST['email']);
	$mobile=get_safe_value($_POST['mobile']);
	$msg=get_safe_value($_POST['msg']);

	date_default_timezone_set('Asia/Kolkata');

	$added_on=date('Y-m-d H:i:s');

	mysqli_query($con,"insert into contact(name,email,mobile,msg,added_on) values('$name','$email','$mobile','$msg','$added_on')");

	echo "Thank you for contacting us.";

		$html="<table style='border: 1px solid'><tr><td>Name</td><td>$name</td></tr><tr><td>Email</td><td>$name</td></tr><tr><td>Mobile</td><td>$mobile</td></tr><tr><td>Message</td><td>$msg</td></tr></table>";
	
        smtp_mailer(GMAIL,'Contact Form Entry',$html,0);
}
else
{
	redirect('index');
}
