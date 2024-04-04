<?php

error_reporting(0);

// -----------------------------------------
$is_login3 = 1;
$login3_captil = "CUST";
$login3 = "cust";
$login3_title = "Customer";
// $login3_captil_login = $$login3_captil."_LOGIN";
define('LOGIN3_CAPTITAL_LOGIN', $login3_captil . '_LOGIN');
//---------------------------------------------
$pdf_path = 'assets/uploaded/pdf/';
// --------------------------------

define('PROJECT_NAME', 'RK Industries'); //imp
define('LOGO_NAME', 'RK INDUSTRIES'); //imp
define('BUSI_MAIL', 'contact@mrgrouptins.com');
define('PASS', 'mr*Ma3i$er(*(1)');
define('GMAIL','mrindustries40@gmail.com'); //imp

/*------------------------------------------------------*/
function get_safe_value($str)
{
	global $con;
	if ($str != '') {
		$str = trim($str);
		return mysqli_real_escape_string($con, $str);
	}
}
function redirect($link)
{
?>
	<script>
		window.location.href = '<?php echo $link ?>';
	</script>
<?php
	die();
}
function alert($varr)
{
?>
	<script>
		alert('<?php echo $varr ?>');
	</script>
<?php
}
function alertd($varr)
{
?>
	<script>
		alert('<?php echo $varr ?>');
	</script>
<?php
	die();
}



function prx($varr)
{
	print_r($varr);
	die();
}

//BACKEND VALIDATION
function common_validate($regex, $var)
{
	if (!preg_match($regex, $var)) {
		return 0; //false
	} else {
		return 1; //true
	}
}

function IsEmail($email)
{
	return common_validate("/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/", $email);
}
function IsMobile($mobile)
{
	return common_validate("/^[6-9]\d{9}$/", $mobile);
}
function IsOnlyDigit($num)
{
	return common_validate("/^[1-9][0-9]*$/", $num);
}
function IsFloat($num)
{
	return common_validate("/^-?(?:\d+|\d*\.\d+)$/", $num);
}
function IsPincode($num)
{
	return common_validate("/^[1-9][0-9]{5}$/", $num);
}
function IsGST($num)
{
	return common_validate("/\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}$/", $num);
}

/*------------------*/
function isAdmin()
{
	if (!isset($_SESSION['ADMIN_LOGIN'])) {
		redirect('login');
	}
	if (!$_SESSION['ADMIN_LOGIN'] == 'yes') {
		redirect('index');
	}
}

function isEmpAdmin()
{
	if (!isset($_SESSION['EMP_LOGIN'])) {
		redirect('login');
	}
	if (!$_SESSION['EMP_LOGIN'] == 'yes') {
		redirect('index');
	}
}
function isLogin3Admin()
{
	if (!isset($_SESSION[LOGIN3_CAPTITAL_LOGIN])) {
		redirect('login');
	}
	if (!$_SESSION[LOGIN3_CAPTITAL_LOGIN] == 'yes') {
		redirect('index');
	}
}


function isAdminAndEmpAdmin()
{
	if ((!$_SESSION['EMP_LOGIN'] == 'yes') && (!$_SESSION['ADMIN_LOGIN'] == 'yes')) {
		redirect('index');
	}
}
function isAdminAndLogin3Admin()
{
	if ((!$_SESSION[LOGIN3_CAPTITAL_LOGIN] == 'yes') && (!$_SESSION['ADMIN_LOGIN'] == 'yes')) {
		redirect('index');
	}
}

/*--------------------------------------------------------------------------------------*/
/*1 = from email | 0 =  to download*/
function generate_pdf($html, $is_email)
{
	include('vendor/autoload.php');
	$mpdf = new \Mpdf\Mpdf();
	$mpdf->autoScriptToLang = true;
	$mpdf->baseScript = 1;
	$mpdf->autoVietnamese = true;
	$mpdf->autoArabic = true;
	$mpdf->autoLangToFont = true;
	$mpdf->WriteHTML($html);
	if ($is_email == 1) { //from smtp_mailer
		return $mpdf->Output("", 'S'); //for email only
	} else if ($is_email == 0) { //for download
		$file = time() . '.pdf'; //pdf name
		$mpdf->Output($file, 'D'); //for download
	}
}

function smtp_mailer($to, $subject, $msg, $is_attachment)
{
	include('smtp/PHPMailerAutoload.php');
	$mail = new PHPMailer();
	// $mail->SMTPDebug=3;
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->Host = "smtp.hostinger.com";
	$mail->Port = 465;
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = BUSI_MAIL;
	$mail->Password = PASS;
	$mail->SetFrom(BUSI_MAIL);
	if ($is_attachment == 1) {
		$mail->addStringAttachment(generate_pdf($msg, 1), time() . '.pdf');
		$mail->Body = "Download the PDF";
	} else {
		$mail->Body = $msg;
	}
	$mail->Subject = $subject;
	$mail->AddAddress($to);

	$mail->SMTPOptions = array('ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => false
	));
	if (!$mail->Send()) {
		return 0;
	} else {
		return 1;
	}
}

function timeAgo($time_ago)
{
	$time_ago = strtotime($time_ago);
	$cur_time   = time();
	$time_elapsed   = $cur_time - $time_ago;
	$seconds    = $time_elapsed;
	$minutes    = round($time_elapsed / 60);
	$hours      = round($time_elapsed / 3600);
	$days       = round($time_elapsed / 86400);
	$weeks      = round($time_elapsed / 604800);
	$months     = round($time_elapsed / 2600640);
	$years      = round($time_elapsed / 31207680);
	// Seconds
	if ($seconds <= 60) {
		return "just now";
	}
	//Minutes
	else if ($minutes <= 60) {
		if ($minutes == 1) {
			return "one minute ago";
		} else {
			return "$minutes minutes ago";
		}
	}
	//Hours
	else if ($hours <= 24) {
		if ($hours == 1) {
			return "an hour ago";
		} else {
			return "$hours hrs ago";
		}
	}
	//Days
	else if ($days <= 7) {
		if ($days == 1) {
			return "yesterday";
		} else {
			return "$days days ago";
		}
	}
	//Weeks
	else if ($weeks <= 4.3) {
		if ($weeks == 1) {
			return "a week ago";
		} else {
			return "$weeks weeks ago";
		}
	}
	//Months
	else if ($months <= 12) {
		if ($months == 1) {
			return "a month ago";
		} else {
			return "$months months ago";
		}
	}
	//Years
	else {
		if ($years == 1) {
			return "one year ago";
		} else {
			return "$years years ago";
		}
	}
}
/*----------------------------------------------------*/

function input_col_lg_4_with_val($var1, $var2, $val)
{
?>
	<div class="col-md-6 col-lg-4">
		<div class="form-group">
			<label for="<?php echo $var1 ?>"><?php echo $var2; ?></label>
			<input type="text" class="form-control" id="<?php echo $var1 ?>" name="<?php echo $var1 ?>" value="<?php echo $val ?>" placeholder="<?php echo $var2; ?>">
			<small id="error_<?php echo $var1 ?>" class="form-text text-danger"></small>
		</div>
	</div>
<?php
}
function input_col_lg_4_readonly($var1, $var2, $val)
{
?>
	<div class="col-md-6 col-lg-4">
		<div class="form-group">
			<label for="<?php echo $var1 ?>"><?php echo $var2; ?></label>
			<input type="text" class="form-control" id="<?php echo $var1 ?>" name="<?php echo $var1 ?>" value="<?php echo $val ?>" readonly>
			<small id="error_<?php echo $var1 ?>" class="form-text text-danger"></small>
		</div>
	</div>
<?php
}
function input_col_12_with_val($var1, $var2, $val)
{
?>
	<div class="col-12">
		<div class="form-group">
			<label for="<?php echo $var1 ?>"><?php echo $var2; ?></label>
			<input type="text" class="form-control" id="<?php echo $var1 ?>" name="<?php echo $var1 ?>" value="<?php echo $val ?>" placeholder="<?php echo $var2; ?>">
			<small id="error_<?php echo $var1 ?>" class="form-text text-danger"></small>
		</div>
	</div>
<?php
}
function textarea_col_lg_6($var1, $var2, $val)
{
?>
	<div class="col-md-6 col-lg-6">
		<div class="form-group">
			<label for="<?php echo $var1 ?>"><?php echo $var2; ?></label>
			<textarea name="<?php echo $var1 ?>" id="<?php echo $var1 ?>">
				<?php echo $val ?>
			</textarea>
			<small id="error_<?php echo $var1 ?>" class="form-text text-danger"></small>
		</div>
	</div>
<?php
}
function radio_col_lg_4($var1, $var2, $checked)
{
	$checked == 1 ? $checked1 = "checked" : $checked1 = "";
	$checked == 0 ? $checked0 = "checked" : $checked0 = "";
?>
	<div class="col-md-6 col-lg-4">
		<div class="form-group">
			<label class="form-label"><?php echo $var2 ?></label>
			<div class="selectgroup w-100">
				<label class="selectgroup-item">
					<input type="radio" name="<?php echo $var1 ?>" value="1" class="selectgroup-input" <?php echo $checked1 ?>>
					<span class="selectgroup-button">Yes</span>
				</label>
				<label class="selectgroup-item">
					<input type="radio" name="<?php echo $var1 ?>" value="0" class="selectgroup-input" <?php echo $checked0 ?>>
					<span class="selectgroup-button">No</span>
				</label>
			</div>
			<small id="error_<?php echo $var1 ?>" class="form-text text-danger"></small>
		</div>
	</div>
	<?php
}

//-------------------------------------------------------------------------------------

//CHECK AVAILABILITY OF ID
function check_availability_of_id($id, $table, $redirect_url)
{
	global $con;
	$res = mysqli_query($con, "select * from $table where id='$id'");
	if (mysqli_num_rows($res) == 0) {
		alert("not Exist");
		redirect($redirect_url);
		die();
	}
}
//CHECK OWNERSHIP
function check_ownership($id, $table, $column, $id2, $redirect_url)
{
	global $con;
	$res = mysqli_query($con, "select * from $table where id='$id' and $column = '$id2'");
	if (mysqli_num_rows($res) == 0) {
		alert("NO OWNERSHIP");
		redirect($redirect_url);
		die();
	}
}

/*-----------------------------*/
//CONTACT FORM
function res_contact_form()
{
	global $con;
	return mysqli_query($con, "select * from contact order by id desc");
}
/*-----------------------------*/
//COMMON SQL

function row_table_by_id($table, $id)
{
	global $con;
	return mysqli_fetch_assoc(mysqli_query($con, "select * from $table where id='$id'"));
}
function row_table_by_column_limit($table,$var, $id)
{
	global $con;
	return mysqli_fetch_assoc(mysqli_query($con, "select * from $table where $var='$id' order by id desc limit 1"));
}
function res_table_desc($table)
{
	global $con;
	return mysqli_query($con, "select * from $table order by id desc");
}
function res_table_asc($table)
{
	global $con;
	return mysqli_query($con, "select * from $table order by id asc");
}
function row_table_desc($table)
{
	global $con;
	return mysqli_fetch_assoc(mysqli_query($con, "select * from $table order by id desc"));
}

function column_by_id($table, $column, $id)
{
	global $con;
	$row =  mysqli_fetch_assoc(mysqli_query($con, "select * from $table where id='$id'"));
	return $row[$column];
}
function column_by_var_limit($table, $column, $var,$id)
{
	global $con;
	$row =  mysqli_fetch_assoc(mysqli_query($con, "select * from $table where $var='$id' order by id desc limit 1"));//where (column_name_id = id)
	return $row[$column];
}
function res_table_status_desc($table)
{
	global $con;
	return mysqli_query($con, "select * from $table where status = 1 order by id desc");
}
function res_table_status_asc($table)
{
	global $con;
	return mysqli_query($con, "select * from $table where status = 1 order by id asc");
}
function count_column_status($table, $column)
{
	global $con;
	$row = mysqli_fetch_assoc(mysqli_query($con, "select COUNT($column) as count from $table where status = 1"));
	return $row['count'];
}



// ---------------------------------------------------------------------
//EMP
function row_emp_by_emp_id($emp_id)
{
	global $con;
	return mysqli_fetch_assoc(mysqli_query($con, "select * from emp where id='$emp_id'"));
}
function get_emp_name_by_emp_id($emp_id)
{
	global $con;
	$row =  mysqli_fetch_assoc(mysqli_query($con, "select * from emp where id='$emp_id'"));
	return $row['name'];
}
function res_emp_list()
{
	global $con;
	return mysqli_query($con, "select * from emp order by id desc");
}
function get_emp_access($emp_id)
{
	global $con;
	$row =  mysqli_fetch_assoc(mysqli_query($con, "select * from emp where id='$emp_id'"));
	return $row['access']; // 1 = true ..0 = false here only
}

//CUST
function row_cust_by_cust_id($cust_id)
{
	global $con;
	return mysqli_fetch_assoc(mysqli_query($con, "select * from cust where id='$cust_id'"));
}
function res_cust_list()
{
	global $con;
	return mysqli_query($con, "select * from cust order by id desc");
}

function res_cust_list_sorted_by_emp($emp_id)
{
	global $con;
	return mysqli_query($con, "select * from cust where emp_id = '$emp_id' order by id desc");
}

function res_cust_account_by_cust_id($cust_id)
{
	global $con;
	return  mysqli_query($con, "SELECT * FROM `cust_account` WHERE cust_id = '$cust_id' ORDER BY id DESC");
}

function check_ownership_cust_selling($order_id, $cust_id, $redirect_url)
{
	global $con;
	$res = mysqli_query($con, "select * from selling where order_id='$order_id' and cust_id = '$cust_id'");
	if (mysqli_num_rows($res) == 0) {
		alert("NO OWNERSHIP");
		redirect($redirect_url);
		die();
	}
}

//CUST BALANCE
function get_cust_account_latest_balance($cust_id, $cost, $var)
{
	/*$var = plus or minus*/
	global $con;
	$balance_of_cust = 0;
	$res_cust_account = mysqli_query($con, "select * from cust_account where cust_id = '$cust_id' ORDER by id desc limit 1"); // latest entry

	if (mysqli_num_rows($res_cust_account) > 0) {
		$row_cust_account = mysqli_fetch_assoc($res_cust_account);
		if ($var == "plus") {
			$balance_of_cust = ($row_cust_account['balance'] + $cost); //rupees
		} else if ($var == "minus") {
			$balance_of_cust = ($row_cust_account['balance'] - $cost); //rupees
		}
	} else {
		if ($var == "minus") {
			$balance_of_cust = -$cost; // if no entry in cust_account then new balance add
		} else if ($var == "plus") {
			$balance_of_cust = $cost; // if no entry in cust_account then new balance add
		}
	}
	return $balance_of_cust;
}

function get_cust_account_latest_balance_without_cost($cust_id)
{
	global $con;
	$res_cust_account = mysqli_query($con, "select * from cust_account where cust_id = '$cust_id' ORDER by id desc limit 1"); // latest entry
	$balance_of_cust = 0;
	if (mysqli_num_rows($res_cust_account) > 0) {
		$row_cust_account = mysqli_fetch_assoc($res_cust_account);
		$balance_of_cust = $row_cust_account['balance'];
	}
	return $balance_of_cust;
}

function get_cust_account_latest_balance_with_id($cust_id)
{
	global $con;
	$res_cust_account = mysqli_query($con, "select * from cust_account where cust_id = '$cust_id' ORDER by id desc limit 1"); // latest entry
	$balance_of_cust = 0;
	if (mysqli_num_rows($res_cust_account) > 0) {
		$row_cust_account = mysqli_fetch_assoc($res_cust_account);
		$balance_of_cust = $row_cust_account['balance'];
		$cust_account_id = $row_cust_account['id'];
	}
	return $balance_of_cust . "_" . $cust_account_id;
}

//SELLING
function check_availability_of_order_id($order_id, $redirect_url)
{
	global $con;
	$res = mysqli_query($con, "select * from selling where order_id='$order_id'");
	if (mysqli_num_rows($res) == 0) {
		alert("not Exist");
		redirect($redirect_url);
		die();
	}
}
function selling_orders_row($order_id, $column) //product_id,qty,price
{
	global $con;
	$op = "";
	$res = mysqli_query($con, "select * from selling where order_id='$order_id'");
	if (mysqli_num_rows($res) >= 0) {
		while ($row = mysqli_fetch_assoc($res)) {
			if ($column == 'product_id') {
				$op .=  "<hr>" . column_by_id('product', 'name', $row[$column]);
			} else if ($column == 'qty') {
				$op .=  "<hr>" . $row[$column];
			} else if ($column == 'price') {
				$op .=  "<hr>" . $row[$column];
			}
		}
	}
	return $op . "<hr>";
}
function selling_orders_details_row($order_id) //product_id,qty,price
{
	global $con;
	$op = "";
	$res = mysqli_query($con, "select * from selling where order_id='$order_id'");
	if (mysqli_num_rows($res) >= 0) {
		while ($row = mysqli_fetch_assoc($res)) {
			$op .=  "<hr>" . column_by_id('product', 'name', $row['product_id']) . " - " . $row['qty'];
		}
	}
	return $op . "<hr>";
}

//GET SELLING COST
function selling_cost($order_id)
{
	global $con;
	$sum = 0;
	$gst = 0;
	$total_cost = 0;
	$gst_type = "";
	$res = mysqli_query($con, "select * from selling where order_id='$order_id'");
	if (mysqli_num_rows($res) >= 0) {
		while ($row = mysqli_fetch_assoc($res)) {
			$sum += ($row['qty'] * $row['price']);
			$gst_type = $row['gst_type'];
		}
		if ($gst_type == 1) {
			$gst = ((column_by_id('gst_type', 'perc', '1') / 100) * $sum);
			$total_cost = $sum + ($gst * 2);
		} else 	if ($gst_type == 2) {
			$gst = ((column_by_id('gst_type', 'perc', '2') / 100) * $sum);
			$total_cost = $sum + $gst;
		}
	}
	return round($sum) . "_" . round($total_cost) . "_" . round($gst);
}
//ORDER STATUS
function update_order_status($order_id, $order_status_id)
{
	global $con;
	$added_on = date('Y-m-d H:i:s');
	if ($order_status_id == 2 || $order_status_id == 3) {
		mysqli_query($con, "update selling set order_status='$order_status_id',accepted_date = '$added_on' where order_id='$order_id'");
	} else if ($order_status_id == 4) {
		mysqli_query($con, "update selling set order_status='$order_status_id',dispatched_date = '$added_on' where order_id='$order_id'");
	} else {
		mysqli_query($con, "update selling set order_status='$order_status_id' where order_id='$order_id'");
	}
	return "";
}

//PDF upload
function pdf_upload_selling($order_id, $table_name, $redirect_to, $pdf_name, $old_pdf_name)
{ //order_id,table_name,redirect_to,mr_order_no,pdf_name, old_pdf_name
	global $con;
	$type = $_FILES[$pdf_name]['type'];
	$size = $_FILES[$pdf_name]['size'];
	$mr_order_no = basename($_FILES[$pdf_name]['name'],'.pdf');
	if ($type != 'application/pdf') {
		// $deliver_receipt_error = "Invalid PDF format";
	?>
		<script>
			window.addEventListener('load', function() {
				swal_alert_without_redirect('Invalid PDF format', 'warning')
			});
		</script>
	<?php
	} else if ($size > 153600) //1024*150kb = 153600
	{
		// $deliver_receipt_error = "Size More than 150KB";
	?>
		<script>
			window.addEventListener('load', function() {
				swal_alert_without_redirect('PDF Size More than 150KB', 'warning')
			});
		</script>
		<?php
	} else {
		$pdf_path = 'assets/uploaded/pdf/';
		//REMOVING OLD PDF
		// $row_single_order[$pdf_name] != '' ? unlink($pdf_path . $row_single_order[$pdf_name]) : '';
		$old_pdf_name != '' ? unlink($pdf_path . $old_pdf_name) : '';

		//ADDING NEW / FIRST PDF
		$final_pdf_name =$mr_order_no. '_' .$pdf_name. '_' . time().'.pdf';
		move_uploaded_file($_FILES[$pdf_name]['tmp_name'], $pdf_path . $final_pdf_name);

		$pdf_name == 'deliver_receipt' || $pdf_name == 'original_invoice'
			?
			mysqli_query($con, "update $table_name set  mr_order_no='$mr_order_no',$pdf_name='$final_pdf_name'  where order_id='$order_id'")
			:
			mysqli_query($con, "update $table_name set  $pdf_name='$final_pdf_name'  where order_id='$order_id'");

		?>
			<script>
				window.addEventListener('load', function() {
					swal_alert_with_redirect('Details Updated', 'success', '<?php echo $redirect_to ?>', 1000)
				});
			</script>
		<?php
	}
}

// *****************************************************************************************************
function pdf_upload_fun1($id1,$id1_var,$id2,$table_name, $redirect_to, $pdf_name, $old_pdf_name,$pdf_path)
{ //order_id,table_name,redirect_to,mr_order_no,pdf_name, old_pdf_name
	global $con;
	$type = $_FILES[$pdf_name]['type'];
	$size = $_FILES[$pdf_name]['size'];
	if ($type != 'application/pdf') {
	?>
		<script>
			window.addEventListener('load', function() {
				swal_alert_without_redirect('Invalid PDF format', 'warning')
			});
		</script>
	<?php
	} else if ($size > 153600) //1024*150kb = 153600
	{
		// $deliver_receipt_error = "Size More than 150KB";
	?>
		<script>
			window.addEventListener('load', function() {
				swal_alert_without_redirect('PDF Size More than 150KB', 'warning')
			});
		</script>
		<?php
	} else {
		//REMOVING OLD PDF
		// $row_single_order[$pdf_name] != '' ? unlink($pdf_path . $row_single_order[$pdf_name]) : '';
		$old_pdf_name != '' ? unlink($pdf_path . $old_pdf_name) : '';

		//ADDING NEW / FIRST PDF
		$final_pdf_name =$id2. '_' .$pdf_name. '_' . time().'.pdf';
		move_uploaded_file($_FILES[$pdf_name]['tmp_name'], $pdf_path . $final_pdf_name);

		if (mysqli_query($con, "update $table_name set $pdf_name='$final_pdf_name'  where $id1_var='$id1'")) {
		?>
			<script>
				window.addEventListener('load', function() {
					swal_alert_with_redirect('Details Updated', 'success', '<?php echo $redirect_to ?>', 1000)
				});
			</script>
		<?php
		}
	}
}

//GST FILE STAUS
function res_gst_file_cust_name()
{
	global $con;
	return mysqli_query($con, "SELECT gst_file.*,cust.name FROM gst_file,cust WHERE gst_file.cust_id = cust.id ORDER BY gst_file.id DESC");
}
function res_gst_file_cust_name_by_id($id)
{
	global $con;
	return mysqli_query($con, "SELECT gst_file.*,cust.name FROM gst_file,cust WHERE cust.id = '$id' and gst_file.cust_id = cust.id ORDER BY gst_file.id DESC");
}


//PRODUCT
function row_product_by_product_id($product_id)
{
	global $con;
	return mysqli_fetch_assoc(mysqli_query($con, "select * from product where id='$product_id'"));
}

function res_product_list()
{
	global $con;
	return mysqli_query($con, "select * from product order by id desc");
}
function res_product_list_status()
{
	global $con;
	return mysqli_query($con, "select * from product where status='1' order by id desc");
}
// *****************************************************************************************************
// 
// 
// 
// 
// 
// 
// 
// 
// 
// 
// 
// 
// 
// 
// 
// ********************************************************************************************************




/*----------------------------------------------------*/
?>