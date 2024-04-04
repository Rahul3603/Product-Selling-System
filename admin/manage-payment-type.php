<?php
define('VAR_NO_DIRECT_ACCESS_HEADER', true);
require 'header.php';

isAdmin();

// ==============================================================================
$table_name = "payment_type";
$redirect_to = "payment-type-list";
$title = "Payment Modes";
// ==============================================================================

$id = "";
$name = "";


if (isset($_GET['id']) && $_GET['id'] > 0) {
	$id = get_safe_value($_GET['id']);

	//CHECK AVAILABILITY OF ID AND REDIRECT
	check_availability_of_id($id, $table_name, $redirect_to);

    $row = row_table_by_id($table_name,$id);

	$name = $row['name'];
} else {
	redirect($redirect_to);
}

if (isset($_POST['submit'])) {
	$name = get_safe_value($_POST['name']);

	$added_on = date('Y-m-d H:i:s');

	//BACKEND VALIDATION
	if ($name == '') {
		alert("Incomplete");
		redirect($redirect_to);
		die();
	}

	if (mysqli_query($con, "update $table_name set name='$name',added_on='$added_on' where id='$id'")) {
		echo "<script>
					window.addEventListener('load', function() {
						swal_alert_with_redirect('" . $title . " Added', 'success', '" . $redirect_to . "', 1000)
					});
				</script>";
	}
}
?>
<div class="main-panel">
	<div class="content">
		<div class="page-inner">
			<div class="page-header">
				<h4 class="page-title"><?php echo $title ?></h4>
				<ul class="breadcrumbs">
					<li class="nav-home">
						<a href="index">
							<i class="flaticon-home"></i>
						</a>
					</li>
					<li class="separator">
						<i class="flaticon-right-arrow"></i>
					</li>
					<li class="nav-item">
						<a href="manage-feed-mill-production"><?php echo $title ?> </a>
					</li>
					<li class="separator">
						<i class="flaticon-right-arrow"></i>
					</li>
					<li class="nav-item">
						<a href="#">Change in <?php echo $title ?></a>
					</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12">
					<form method="post" >
						<div class="card">
							<div class="card-header">
								<div class="card-title"><?php echo $title ?></div>
							</div>

							<div class="card-body">
								<div class="row">
									<?php
									input_col_lg_4_with_val('name', 'Payment Mode', $name);
									?>
								</div>

							</div>
							<div class="card-action">
								<button class="btn btn-success" type="submit" name="submit" onclick="return <?php echo $table_name?>_submit()">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	require 'footer.php';
	?>