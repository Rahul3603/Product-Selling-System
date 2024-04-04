<?php
define('VAR_NO_DIRECT_ACCESS_HEADER', true);
require 'header.php';

isAdminAndLogin3Admin();

// ==============================================================================
$table_name = "selling";
// $table_name_dropdown = "cust";
// $table_name_dropdown2 = "gst_type";
$table_name_dropdown3 = "order_status";
$redirect_to = "selling-history";
$redirect_self = "view-selling";
// $title = "Product Selling";
// ==============================================================================

if (isset($_GET['id']) && $_GET['id'] > 0) {
	$id = get_safe_value($_GET['id']); //order_id

	//NOT COMMON - CHECK AVAILABILITY OF ID AND REDIRECT
	check_availability_of_order_id($id, $redirect_to);

	//OWNERSHIP
	if (isset($_SESSION[LOGIN3_CAPTITAL_LOGIN])) {
		$cust_id =  $_SESSION[$login3_captil . '_ID'];
		check_ownership_cust_selling($id, $cust_id, $redirect_to);
	}

	$res = mysqli_query($con, "SELECT * FROM `selling` WHERE order_id = '$id' ORDER BY id DESC");
	$row_single_order = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `selling` WHERE order_id = '$id' ORDER BY id DESC LIMIT 1"));

	if (isset($_GET['order_status'])  && $_GET['order_status'] > 0) {
		$order_status_id = get_safe_value($_GET['order_status']);
		//FOR DELIVER CANT CHNAGE
		if ($order_status_id == 5 && $row_single_order['order_status'] != 5) { //deliver
			$selling_cost = explode("_", selling_cost($row_single_order['order_id']));
			$balance_of_cust =  get_cust_account_latest_balance($row_single_order['cust_id'], $selling_cost['1'], 'plus');
			$added_on = date('Y-m-d H:i:s');

			mysqli_query($con, "update selling set order_status='$order_status_id',delivered_date = '$added_on' where order_id='$id'");
			mysqli_query($con, "INSERT INTO `cust_account`(`cust_id`, `selling_id`,`balance`, `added_on`) VALUES ('" . $row_single_order['cust_id'] . "','" . $row_single_order['order_id'] . "','$balance_of_cust','$added_on')");
		} else if ($order_status_id != 5 && $row_single_order['order_status'] != 5) {
			update_order_status($id, $order_status_id);
			// mysqli_query($con, "update selling set order_status='$order_status_id' where order_id='$id'");
		}
		redirect($redirect_self . '?id=' . $id);
	}
} else {
	redirect($redirect_to);
	die();
}

// -------------------------------------
$deliver_receipt = "";
$original_invoice = "";
$eway_bill = "";

if (isset($_POST['submit'])) {
	// $mr_order_no = get_safe_value($_POST['mr_order_no']);

	// //BACKEND VALIDATION
	// if (IsOnlyDigit($mr_order_no) == "") {
	// 	alert("Incomplete");
	// 	redirect($redirect_self);
	// 	die();
	// }
	if ($_FILES['deliver_receipt']['type'] == '' && $_FILES['eway_bill']['type']=='' && $_FILES['original_invoice']['type']=='') {
		// if (mysqli_query($con, "update $table_name set mr_order_no='$mr_order_no'  where order_id='$id'")) {
		?>
			<script>
				window.addEventListener('load', function() {
					swal_alert_without_redirect('Please select any PDF!!!', 'warning');
				});
			</script>
		<?php
		// }
	} else {
		if($_FILES['deliver_receipt']['type']!=''){
			pdf_upload_selling($id,$table_name,$redirect_to,'deliver_receipt',$row_single_order['deliver_receipt']);//order_id,table_name,redirect_to,pdf_name, old_pdf_name
		}
		if($_FILES['original_invoice']['type']!=''){
			pdf_upload_selling($id,$table_name,$redirect_to,'original_invoice',$row_single_order['original_invoice']);//order_id,table_name,redirect_to,pdf_name, old_pdf_name
		}

		if($_FILES['eway_bill']['type']!=''){
			pdf_upload_selling($id,$table_name,$redirect_to,'eway_bill',$row_single_order['eway_bill']);//order_id,table_name,redirect_to,pdf_name, old_pdf_name
		}
	}
}

?>
<div class="main-panel">
	<div class="content">
		<div class="panel-header bg-primary-gradient">
			<div class="page-inner py-5">
				<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
					<div>
						<h2 class="text-white pb-2 fw-bold">View Details</h2>
						<!-- <h5 class="text-white op-7 mb-2">Free Bootstrap 4 Admin Dashboard</h5> -->
					</div>
					<div class="ml-md-auto py-2 py-md-0">
						<a href="index" class="btn btn-white btn-border btn-round mr-2">Home</a>
						<?php
						echo isset($_SESSION[LOGIN3_CAPTITAL_LOGIN]) ? '<a href="selling-cust" class="btn btn-secondary btn-round">Selling </a>' : '<a href="selling" class="btn btn-secondary btn-round">Selling </a>';
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="page-inner mt--5">
			<!-- Selling History start -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<!-- <h4 class="card-title">product History</h4> -->
							<div class="card-head-row">
								<div class="card-title m-auto">
									Invoice
								</div>
							</div>
						</div>
						<?php
						if (isset($_SESSION['ADMIN_LOGIN'])) {
						?>
							<div class="row mt-5">
								<div class="col-sm-6 col-lg-6 ">
								</div>

								<div class="col-sm-6 col-lg-6 ">
									<div class="card p-3">
										<div class="d-flex align-items-center">
											<span class="stamp stamp-md bg-success mr-3">
												<i class="fa fa-users"></i>
											</span>
											<div>
												<h3 class="mb-1"><b><a href='cust-account?id=<?php echo $row_single_order['cust_id'] ?>'><?php echo column_by_id('cust', 'name', $row_single_order['cust_id'])  ?> </a></b></h3>
												<h4 class="mb-1"><?php echo column_by_id('cust', 'owner_name', $row_single_order['cust_id'])  ?></h4>
												<h5 class="mb-1"><b><?php echo date('d/m/Y h:i A', strtotime($row_single_order['added_on']))   ?> </b></h5>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php
						}
						?>
						<?php
						if (!isset($_SESSION['ADMIN_LOGIN'])) {
						?>
							<div class="row mt-3">
								<div class="col-sm-6 col-lg-4 m-auto">
									<div class="card p-3">
										<div class="d-flex align-items-center">
											<span class="stamp stamp-md bg-success mr-3">
												<i class="fa fa-users"></i>
											</span>
											<div>
												<h3 class="mb-1"><b><?php echo column_by_id('order_status', 'name', $row_single_order['order_status'])  ?></b></h3>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php
						}
						?>

						<div class="card-body">
							<div class="table-responsive">
								<table class="display table table-striped table-hover border">
									<thead>
										<tr>
											<th>#No </th>
											<th>Products</th>
											<th>Quanity</th>
											<th>Price</th>
											<th>Total</th>
										</tr>
									</thead>
									<!-- <tfoot>
										<tr>
										<th>#No </th>
											<th>Products</th>
											<th>Quanity</th>
											<th>Price</th>
											<th>Total</th>
										</tr>
									</tfoot> -->
									<tbody>
										<?php
										$sum = 0;
										if (mysqli_num_rows($res) > 0) {
											$i = 1;
											while ($row = mysqli_fetch_assoc($res)) {
												$sum += ($row['qty'] * $row['price']);
										?>
												<tr>
													<td><?php echo $i ?></td>
													<td><?php echo column_by_id('product', 'name', $row['product_id'])  ?></td>
													<td><?php echo $row['qty'] ?></td>
													<td><?php echo $row['price'] ?></td>
													<td><?php echo  "<span class='text-success'><strong>" . ($row['qty'] * $row['price']) . "</strong></span>" ?></td>
												</tr>
											<?php
												$i++;
											}
										} else { ?>
											<tr>
												<td class="text-center" colspan="100%">No data found</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row">

							<div class="col-md-4 m-auto">
								<div class="card card-pricing card-pricing-focus card-primary">
									<h4 class="card-title">Total</h4>

									<div class="card-body">
										<ul class="specification-list">
											<li>
												<span class="name-specification">Amount</span>
												<span class="status-specification">₹<?php echo $sum ?></span>
											</li>
											<?php
											$total_cost = 0;
											if ($row_single_order['gst_type'] == 1) { //CGST/SGST
												$gst_per = column_by_id('gst_type', 'perc', '1');
												$cgst = (($gst_per  / 100) * $sum);
												$total_cost = $sum + ($cgst * 2);
											?>
												<li>
													<span class="name-specification">CGST <?php echo "(" . $gst_per . "%)" ?></span>
													<span class="status-specification">₹<?php echo $cgst ?></span>
												</li>
												<li>
													<span class="name-specification">SGST <?php echo "(" . $gst_per . "%)" ?></span>
													<span class="status-specification">₹<?php echo $cgst ?></span>
												</li>
											<?php
											}
											if ($row_single_order['gst_type'] == 2) { //IGST
												$gst_per = column_by_id('gst_type', 'perc', '2');
												$igst = (($gst_per  / 100) * $sum);
												$total_cost = $sum + ($igst);
											?>
												<li>
													<span class="name-specification">IGST <?php echo "(" . $gst_per . "%)" ?></span>
													<span class="status-specification">₹<?php echo $igst ?></span>
												</li>
											<?php
											}
											?>
										</ul>
									</div>
									<div class="card-header">
										<div class="card-price">
											<span class="price">₹<?php echo round($total_cost) ?></span>
											<!-- <span class="text">/mo</span> -->
										</div>
									</div>
								</div>
							</div>
							<?php
							if (isset($_SESSION['ADMIN_LOGIN'])) {
								$row_single_order['order_status'] == 5 ? $disabled = "disabled" : $disabled = "";
							?>
								<div class="col-md-6 col-lg-4 m-auto">

									<div class="col-md-12 m-auto">
										<div class="form-group">
											<label for="<?php echo $table_name_dropdown3 ?>_id">Select Order Status</label>
											<select class="form-control" id="<?php echo $table_name_dropdown3 ?>_id" name="<?php echo $table_name_dropdown3 ?>_id" data-live-search="true" onchange="updateOrderStatus()" <?php echo $disabled ?>>
												<!-- <option>Select Option</option> -->
												<?php
												// $table_name_dropdown3_id = "$".$table_name_dropdown3."_id";
												$res_dropdown3 = res_table_asc($table_name_dropdown3);
												while ($row_dropdown = mysqli_fetch_assoc($res_dropdown3)) {
													$row_single_order['order_status'] == $row_dropdown['id'] ? $selected = "selected" : $selected = "";
													echo "'<option value=" . $row_dropdown['id'] . " $selected>" . $row_dropdown['name'] . "</option>'";
												}
												?>
											</select>
											<small id="error_<?php echo $table_name_dropdown3 ?>_id" class="form-text text-danger"></small>
										</div>
										<?php
										if ($row_single_order['order_status'] != 5) {
										?>
											<div class="col-md-6 col-lg-4 m-auto">
												<div class="card-action">
													<a class="btn btn-primary text-white" href="selling?id=<?php echo $id ?>">Edit</a>
												</div>
											</div>
										<?php
										}
										?>
									</div>
									<?php
									if ($row_single_order['order_status'] == 5) { //delivered
										$row_single_order['deliver_receipt']!=''?$uploaded1="Uploaded":'';
										$row_single_order['original_invoice']!=''?$uploaded3="Uploaded":'';
										$row_single_order['eway_bill']!=''? $uploaded2="Uploaded":'';
									?>
										<div class="col-md-12 m-auto">
											<form method="post"  enctype="multipart/form-data">
												<div class="col-12">
													<div class="form-group">
														<label for="deliver_receipt">Deliver Receipt <span class="text-success"> - <?php echo $uploaded1?></span></label>
														<input type="file" class="form-control" id="deliver_receipt" name="deliver_receipt">
														<small id="error_deliver_receipt" class="form-text text-danger"><?php echo $deliver_receipt_error ?></small>
													</div>
												</div>
												<div class="col-12">
													<div class="form-group">
														<label for="original_invoice">Original Invoice <span class="text-success"> - <?php echo $uploaded3?></span></label>
														<input type="file" class="form-control" id="original_invoice" name="original_invoice">
														<small id="error_original_invoice" class="form-text text-danger"><?php echo $original_invoice_error ?></small>
													</div>
												</div>
												<div class="col-12">
													<div class="form-group">
														<label for="eway_bill">E-Way Bill<span class="text-success"> - <?php echo $uploaded2?></span></label>
														<input type="file" class="form-control" id="eway_bill" name="eway_bill">
														<small id="error_eway_bill" class="form-text text-danger"><?php echo $eway_bill_error ?></small>
													</div>
												</div>
												<div class="col-md-6 col-lg-4 m-auto">
													<div class="card-action">
														<button class="btn btn-success" type="submit" name="submit" onclick="return view_selling_submit()">Submit</button>
													</div>
												</div>
											</form>
										</div>
									<?php
									}
									?>
								</div>
							<?php
							}
							?>
						</div>

					</div>
				</div>
			</div>
			<!-- Farms list end -->
		</div>
	</div>
	<?php
	require 'footer.php';
	?>

	<!-- for datatables -->
	<script src="./assets/js/datatable-footer-vicks.js"></script>
	<script>
		function updateOrderStatus() {
			var order_status_id = jQuery('#order_status_id').val();
			if (order_status_id != '') {
				var order_id = "<?php echo $id ?>";
				if (order_status_id == '5') {
					if (confirm('Are you sure? This cant be edited')) {
						window.location.href = '?id=' + order_id + '&order_status=' + order_status_id;
					} else {
						window.location.href = '?id=' + order_id;
					}
				} else {
					window.location.href = '?id=' + order_id + '&order_status=' + order_status_id;

				}
			}
		}
	</script>