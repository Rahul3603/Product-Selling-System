<?php
define('VAR_NO_DIRECT_ACCESS_HEADER', true);
require 'header.php';

isAdminAndLogin3Admin();

// ==============================================================================
$pdf_path = 'assets/uploaded/pdf/';
$redirect_self = 'selling-history';
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

	if (isset($_GET['order_status'])  && $_GET['order_status'] == 6) {
		$row_single_order = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `selling` WHERE order_id = '$id' ORDER BY id DESC LIMIT 1"));

		if($row_single_order['order_status']!=5){
			mysqli_query($con, "update selling set order_status='6' where order_id='$id'");
		}
		redirect($redirect_self);
	}
}

if (isset($_SESSION['ADMIN_LOGIN'])) {
	$res = mysqli_query($con, "select * from selling group by order_id order by id desc");
} else if (isset($_SESSION[LOGIN3_CAPTITAL_LOGIN])) {
	$cust_id =  $_SESSION[$login3_captil . '_ID'];
	$res = mysqli_query($con, "select * from selling WHERE cust_id=$cust_id  group by order_id order by id desc");
}

?>
<div class="main-panel">
	<div class="content">
		<div class="panel-header bg-primary-gradient">
			<div class="page-inner py-5">
				<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
					<div>
						<h2 class="text-white pb-2 fw-bold">Selling History</h2>
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
								<div class="card-title">Selling History</div>
								<!-- <div class="card-tools">
									<a href="pdf.php?id=1&type=product-history" class="btn btn-info btn-border btn-round btn-sm" onclick="swal_alert_without_redirect('Downloading..!..','success')">
										<span class="btn-label">
											<i class="fa fa-print"></i>
										</span>
										Download 
									</a>
								</div> -->
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="basic-datatables" class="display table table-striped table-hover">
									<thead>
										<tr>
											<th>#No </th>
											<?php
											if (!isset($_SESSION[LOGIN3_CAPTITAL_LOGIN])) {
												echo "<th>Customer</th>";
											}
											?>
											<th>Order Date</th>
											<th> Order</th>
											<th>Accepted</th>
											<th>Disptached</th>
											<th>Delivered</th>
											<th>Deliver Receipt</th>
											<th>Cancel / Completed</th>
											
											<th>Action</th>
										</tr>
									</thead>
									<!-- <tfoot>
										<tr>
											<th>#No </th>
											<th>Order Status</th>
											<th>Date</th>
											<th>Customer</th>
											<th>Action</th>
										</tr>
									</tfoot> -->
									<tbody>
										<?php
										if (mysqli_num_rows($res) > 0) {
											$i = 1;
											while ($row = mysqli_fetch_assoc($res)) {
										?>
												<tr>
													<td><?php echo $i ?></td>
													<?php
														if (!isset($_SESSION[LOGIN3_CAPTITAL_LOGIN])) {

														echo "<td><a href='cust-account?id=" . $row['cust_id'] . "'><span class='text-primary'><strong>" . column_by_id('cust', 'name', $row['cust_id']) .
															"<br>"
															. column_by_id('cust', 'owner_name', $row['cust_id']) .
															"</strong></span></a></td>";
														}
														?>
													<td><?php echo date('d/m/Y h:i A', strtotime($row['future_date'])) ?></td>
													<td  class="text-nowrap"><?php echo selling_orders_details_row($row['order_id'])?></td>
													<?php echo ($row['order_status'] >= 2 && $row['order_status'] != 6) ?  "<td class='bg-success text-white'>".column_by_id('order_status', 'name', '2')."<br/>".date('d/m/Y h:i A', strtotime($row['accepted_date']))."</td>": "<td>-</td>"; ?>
													<?php echo ($row['order_status'] >= 4 && $row['order_status'] != 6) ?  "<td class='bg-success text-white'>".column_by_id('order_status', 'name', '4')."<br/>".date('d/m/Y h:i A', strtotime($row['dispatched_date']))."</td>": "<td>-</td>"; ?>
													<?php echo ($row['order_status'] == 5 && $row['order_status'] != 6) ?  "<td class='bg-success text-white'>".column_by_id('order_status', 'name', '5')."<br/>".date('d/m/Y h:i A', strtotime($row['delivered_date']))."</td>": "<td>-</td>"; ?>
											
			
													<td><?php echo $row['deliver_receipt'] !='' ? "<a href='".$pdf_path.$row['deliver_receipt']."' target='_blank'>".$row['mr_order_no']."pdf</a>":'-';  ?></td>
													
													<td class="text-center">
														
														<?php
															if($row['order_status'] == 5){
																echo '<a href="#" class="btn btn-success btn-xs btn-info m-1">Completed</a>';
															}else if($row['order_status'] != 6) {
																?>
																<a href="?id=<?php echo $row['order_id']."&order_status=6" ?>" class="btn btn-danger btn-xs btn-info m-1" onclick="return confirm_function()">Cancel</a>
																<?php
															}else{
																echo '<a href="#" class="btn btn-danger btn-xs btn-info m-1">Canceled</a>';
															}
																
														?>
														
													</td>

													<td class="text-center">
														<a href="view-selling?id=<?php echo $row['order_id'] ?>" class="btn btn-primary btn-xs btn-info m-1">View</a>
													</td>
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