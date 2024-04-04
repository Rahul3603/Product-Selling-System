<?php
define('VAR_NO_DIRECT_ACCESS_HEADER', true);
require 'header.php';

isAdmin();
// ==============================================================================
$table_name = "gst_type";
$edit_to = "manage-gst-type";
$title = "GST";
// ==============================================================================

$res = res_table_desc($table_name);
?>
<div class="main-panel">
	<div class="content">
		<div class="panel-header bg-primary-gradient">
			<div class="page-inner py-5">
				<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
					<div>
						<h2 class="text-white pb-2 fw-bold"><?php echo $title ?> Section </h2>
						<!-- <h5 class="text-white op-7 mb-2">Free Bootstrap 4 Admin Dashboard</h5> -->
					</div>
					<div class="ml-md-auto py-2 py-md-0">
						<a href="index" class="btn btn-white btn-border btn-round mr-2">Home</a>
						<!-- <a href="production-formula" class="btn btn-secondary btn-round">zz</a> -->
					</div>
				</div>
			</div>
		</div>
		<div class="page-inner mt--5">
			<!-- GST TYPE start -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title"><?php echo $title ?></h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="basic-datatables" class="display table table-striped table-hover">
									<thead>
										<tr>
											<th>No</th>
											<th>GST Type</th>
											<th>Percentage</th>
											<th>Changed Date</th>
											<th>Edit </th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>No</th>
											<th>GST Type</th>
											<th>Percentage</th>
											<th>Changed Date</th>
											<th>Edit </th>
										</tr>
									</tfoot>
									<tbody>
										<?php if (mysqli_num_rows($res) > 0) {
											$i = 1;
											while ($row = mysqli_fetch_assoc($res)) {
										?>
												<tr>
													<td><?php echo $i ?></td>
													<td class="text-primary"><strong>
															<?php
															if ($row['id'] == 1) {
																echo "CGST/SGST";
															} else if ($row['id'] == 2) {
																echo "IGST ";
															} 
															?>
														</strong>
													</td>
													<td><?php echo $row['perc'] ?></td>
													<td><?php echo date('d/m/Y h:i A', strtotime($row['added_on'])); ?></td>
													<td>
														<a href="<?php echo $edit_to ?>?id=<?php echo $row['id'] ?>" class="btn btn-primary btn-xs btn-info">Edit</a>

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
			<!--  list end -->
		</div>
	</div>
	<?php
	require 'footer.php';
	?>

	<!-- for datatables -->
	<script src="./assets/js/datatable-footer-vicks.js"></script>