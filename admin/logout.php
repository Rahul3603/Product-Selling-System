<?php
session_start();

//---------------------------------------------------------------
$is_login3 = 1;
$login3_captil = "CUST";
//---------------------------------------------------------------

unset($_SESSION['LAST_ACTIVE_TIME']);
 if(isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!=''){
	unset($_SESSION['ADMIN_LOGIN']);
	unset($_SESSION['ADMIN_ID']);
	unset($_SESSION['ADMIN_MOBILE']);
	unset($_SESSION['ROLE']);
}
else if(isset($_SESSION['EMP_LOGIN']) && $_SESSION['EMP_LOGIN']!=''){
	unset($_SESSION['EMP_LOGIN']);
	unset($_SESSION['EMP_ID']);
	unset($_SESSION['EMP_MOBILE']);
	unset($_SESSION['ROLE']);
}
else if($is_login3 && isset($_SESSION[$login3_captil.'_LOGIN']) && $_SESSION[$login3_captil.'_LOGIN']!=''){
	unset($_SESSION[$login3_captil.'_LOGIN']);
	unset($_SESSION[$login3_captil.'_ID']);
	unset($_SESSION[$login3_captil.'_MOBILE']);
	unset($_SESSION['ROLE']);
}

header('location:login.php');
die();
?>

