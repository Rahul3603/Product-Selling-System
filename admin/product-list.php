<?php

define('VAR_NO_DIRECT_ACCESS_HEADER',true);
require 'header.php'; 

isAdmin();

if(isset($_GET['type']) && $_GET['type']!=='' && isset($_GET['id']) && $_GET['id']>0){
	
	$type=get_safe_value($_GET['type']);
	$id=get_safe_value($_GET['id']);
	
	if($type=='active' || $type=='deactive'){
		$status=1;
		if($type=='deactive'){
			$status=0;
		}
		mysqli_query($con,"update product set status='$status' where id='$id'");
		redirect('product-list');
		
	}
}

$res = res_product_list();

?>
<div class="main-panel">
	<div class="content">
		<div class="panel-header bg-primary-gradient">
			<div class="page-inner py-5">
				<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
					<div>
						<h2 class="text-white pb-2 fw-bold">Product Section </h2>
					</div>
					<div class="ml-md-auto py-2 py-md-0">
						<a href="index" class="btn btn-white btn-border btn-round mr-2">Home</a>
						<a href="manage-product" class="btn btn-secondary btn-round">Product Registration</a>
					</div>
				</div>
			</div>
		</div>
		<div class="page-inner mt--5">			
			<!-- product list start -->					
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<div class="card-head-row">
								<div class="card-title">Employee's List</div>
								<!-- <div class="card-tools">
									<a href="pdf.php?id=1&type=all-list" class="btn btn-info btn-border btn-round btn-sm" onclick="swal_alert_without_redirect('Downloading..!..','success')">
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
								<table id="basic-datatables" class="display table table-striped table-hover" >
									<thead>
										<tr>
											<th>#No</th>
											<th>Name</th>
											<th>Added on</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>#No</th>
											<th>Name </th>
											<th>Added on</th>
											<th>Actions</th>
										</tr>
									</tfoot>
									<tbody>
										<?php 
										if(mysqli_num_rows($res)>0){
											$i=1;
											while($row=mysqli_fetch_assoc($res)){
												?>
												<tr>
													<td><?php echo $i?></td>
													<td><?php echo $row['name']?></td>
													<td><?php echo date ('d/m/Y h:i A', strtotime($row['added_on'])); ?></td>
													<td>
													<a href="manage-product?id=<?php echo $row['id']?>" class="btn btn-primary btn-xs btn-info">Edit</a>
													<?php
													if($row['status']==1){
														?>
														&nbsp;
														&nbsp;	
														<a href="?id=<?php echo $row['id']?>&type=deactive" class="btn btn-primary btn-xs btn-warning">Active</a>
														<?php
													}
													else{
														?>
														
														&nbsp;
														&nbsp;
														<a href="?id=<?php echo $row['id']?>&type=active" class="btn btn-primary btn-xs btn-danger">Inactive</a>
														<?php
													}
													?>
												</td>
												</tr>
												<?php 
												$i++;
											}
										}
										else 
										{ 
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
			<!-- product list end -->			
		</div>
	</div>
	<?php
	require 'footer.php';
	?>

	<!-- for datatables -->
	<script src="./assets/js/datatable-footer-vicks.js"></script>
