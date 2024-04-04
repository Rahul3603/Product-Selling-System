<?php

define('VAR_NO_DIRECT_ACCESS_HEADER', true);
require 'header.php';

isAdminAndEmpAdmin();

if (isset($_GET['type']) && $_GET['type'] !== '' && isset($_GET['id']) && $_GET['id'] > 0) {

	$type = get_safe_value($_GET['type']);
	$id = get_safe_value($_GET['id']);


	//CHECK AVAILABILITY OF ID AND REDIRECT
	check_availability_of_id($id, 'cust', 'cust-list');

	if ($type == 'active' || $type == 'deactive') {
		$status = 1;
		if ($type == 'deactive') {
			$status = 0;
		}
		mysqli_query($con, "update cust set status='$status' where id='$id'");
		redirect('cust-list');
	}
}
$res = res_cust_list();



?>
<div class="main-panel">
	<div class="content">
		<div class="panel-header bg-primary-gradient">
			<div class="page-inner py-5">
				<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
					<div>
						<h2 class="text-white pb-2 fw-bold">Customer Section </h2>
					</div>
					<div class="ml-md-auto py-2 py-md-0">
						<a href="index" class="btn btn-white btn-border btn-round mr-2">Home</a>
						<a href="manage-cust" class="btn btn-secondary btn-round">Customer Registration</a>
					</div>
				</div>
			</div>
		</div>
		<div class="page-inner mt--5">
			<!-- cust list start -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<div class="card-head-row">
								<div class="card-title">Customer List</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="basic-datatables" class="display table table-striped table-hover">
									<thead>
										<tr>
											<th>#No</th>
											<th>Factory Name</th>
											<th>Owner Name</th>
											<th>Owner Mobile</th>
											<th>Manager Name</th>
											<th>Manager Mobile</th>	
											<th>Email</th>
											<th>Address</th>
											<th>Pincode</th>
											<th>Actions</th>
											<th>Added on</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>#No</th>
											<th>Factory Name</th>
											<th>Owner Name</th>
											<th>Owner Mobile</th>
											<th>Manager Name</th>
											<th>Manager Mobile</th>
											<th>Email</th>
											<th>Address</th>
											<th>Pincode</th>
											<th>Actions</th>
											<th>Added on</th>
										</tr>
									</tfoot>
									<tbody>
										<?php
										if (mysqli_num_rows($res) > 0) {
											$i = 1;
											while ($row = mysqli_fetch_assoc($res)) {
										?>
												<tr>
													<td><?php echo $i ?></td>
													<td><?php echo "<a href='cust-account?id=".$row['id']."'><span class='text-primary'><strong>".$row['name']."</strong></span></a>"?></td>
													<td><?php echo $row['owner_name'] ?></td>
													<td><?php echo $row['mobile'] ?></td>
													<td><?php echo $row['manager_name'] ?></td>
													<td><?php echo $row['manager_mob'] ?></td>
													<td><?php echo $row['email'] ?></td>
													<td><?php echo $row['address'] ?></td>
													<td><?php echo $row['pincode'] ?></td>
													<td class="text-center">
														<a href="manage-cust?id=<?php echo $row['id'] ?>" class="btn btn-primary btn-xs btn-info m-1">Edit</a>
														<?php
														if ($row['status'] == 1) {
														?>
															<a href="?id=<?php echo $row['id'] ?>&type=deactive" class="btn btn-primary btn-xs btn-warning m-1">Active</a>
														<?php
														} else {
														?>

															<a href="?id=<?php echo $row['id'] ?>&type=active" class="btn btn-primary btn-xs btn-danger m-1">Inactive</a>
														<?php
														}
														?>
													</td>
													<td><?php echo date('d/m/Y h:i A', strtotime($row['added_on'])); ?></td>

												</tr>
											<?php
												$i++;
											}
										} else {
											?>
											<tr>
												<td class="text-center" colspan="100%">No data found</td>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- cust list end -->
		</div>
	</div>
	<?php
	require 'footer.php';
	?>

	<!-- for datatables -->
	<script src="./assets/js/datatable-footer-vicks.js"></script>