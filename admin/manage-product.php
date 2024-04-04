<?php
define('VAR_NO_DIRECT_ACCESS_HEADER',true);
require 'header.php'; 

isAdmin();
$id="";
$name="";

if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);

	//CHECK AVAILABILITY OF ID AND REDIRECT
	check_availability_of_id($id,'product','product-list');

	$row=row_product_by_product_id($id);
	$name=$row['name'];
}

if(isset($_POST['submit'])){
	$name=ucfirst(get_safe_value($_POST['name']));
	$added_on=date('Y-m-d h:i:s');

	if($id==''){
		$sql="select * from product where name='$name'";
	}else{
		$sql="select * from product where name='$name' and id!='$id'";
	}	
	if(mysqli_num_rows(mysqli_query($con,$sql))>0){
		?>
		<script>
			window.addEventListener('load',function(){
				swal_alert_without_redirect('Product Already Registered','warning');
			});

		</script>
		<?php
	}
	else{
		if($id==''){
			mysqli_query($con,"insert into product(name,status,added_on) values('$name',1,'$added_on')");
		}else{
			mysqli_query($con,"update product set name='$name' where id='$id'");
		}
		?>
		<script>
			window.addEventListener('load',function(){
				swal_alert_with_redirect('Product Added','success','product-list',1000)
			});
		</script>
		<?php
	}
}
?>
<div class="main-panel">
	<div class="content">
		<div class="page-inner">
			<div class="page-header">
				<h4 class="page-title">Product</h4>
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
						<a href="product-list">Product List</a>
					</li>
					<li class="separator">
						<i class="flaticon-right-arrow"></i>
					</li>
					<li class="nav-item">
						<a href="manage-product">Product Registration</a>
					</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12">
					<form method="post" id="manage-product">
						<div class="card">
							<div class="card-header">
								<div class="card-title">New Product Registration</div>
							</div>
							<div class="card-body">

								<div class="row">
									<?php 
										input_col_lg_4_with_val('name','Name',$name); 
									?>
								</div>

							</div>
							<div class="card-action">
								<button class="btn btn-success" type="submit" name="submit" onclick="return product_submit()">Submit</button>
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