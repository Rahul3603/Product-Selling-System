<?php

define('VAR_NO_DIRECT_ACCESS_HEADER', true);
require 'header.php';

?>

<div class="main-panel">
	<div class="content">
		<?php
		if (isset($_SESSION['ADMIN_LOGIN'])) {
		?>
			<div class="panel-header bg-primary-gradient">
				<div class="page-inner py-5">
					<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
						<div>
							<h2 class="text-white pb-2 fw-bold">Dashboard</h2>
							<h5 class="text-white op-7 mb-2">Best Management Tool</h5>
						</div>
						<div class="ml-md-auto py-2 py-md-0">
							<a href="index" class="btn btn-white btn-border btn-round mr-2">Home</a>
							/
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		?>
		<!-- LOGIN3 AREA -->
		<?php
		if ($is_login3 && isset($_SESSION[$login3_captil . '_LOGIN'])) {
		?>
			<div class="page-inner py-5">
				<div class="row">
					<div class="col-sm-6 col-md-3">
						<a href="selling-cust" style="text-decoration: none;">
							<div class="card card-stats card-primary card-round">
								<div class="card-body">
									<div class="row">
										<div class="col-4">
											<div class="icon-big text-center">
												<i class="flaticon-shopping-bag"></i>
											</div>
										</div>
										<div class="col-8 col-stats">
											<div class="numbers">
												<!-- <p class="card-category">Order</p> -->
												<h4 class="card-title">New Tin Order</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-sm-6 col-md-3">
						<a href="selling-history" style="text-decoration: none;">
							<div class="card card-stats card-secondary card-round">
								<div class="card-body">
									<div class="row">
										<div class="col-4">
											<div class="icon-big text-center">
												<i class="flaticon-technology-1"></i>
											</div>
										</div>
										<div class="col-8 col-stats">
											<div class="numbers">
												<!-- <p class="card-category">Order</p> -->
												<h4 class="card-title">Order Status</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-sm-6 col-md-3">
						<a href="cust-account?id=<?php echo $_SESSION[$login3_captil . '_ID'] ?>" style="text-decoration: none;">
							<div class="card card-stats card-info card-round">
								<div class="card-body">
									<div class="row">
										<div class="col-4">
											<div class="icon-big text-center">
												<i class="flaticon-graph"></i>
											</div>
										</div>
										<div class="col-8 col-stats">
											<div class="numbers">
												<!-- <p class="card-category">Order</p> -->
												<h4 class="card-title">Ledger Statement</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
			<!-- --------------- -->
		<?php
		}
		?>
		<!-- LOGIN3 AREA END -->
		<?php
		if (isset($_SESSION['ADMIN_LOGIN'])) {
		?>
			<div class="page-inner mt--5">
				<div class="row mt--2">
					<?php
					/*to get sum of todays selling*/
					//  $row_sum_of_todays_selling = mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(price*qty) as selling_sum FROM selling WHERE DATE(added_on) = CURDATE()"));

					/*to get sum of todays fee*/
					//  $row_sum_of_todays_fee = mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(fee) as fee_sum,COUNT(fee) as todays_member_count FROM cust WHERE DATE(added_on) = CURDATE() and is_member = 0"));
					?>
					<div class="col-md-6">
						<div class="card full-height">
							<div class="card-body">
								<div class="card-title">Today's Analysis</div>
								<div class="card-category">Daily information about statistics in system</div>
								<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
									<div class="px-2 pb-2 pb-md-0 text-center">
										<div id="circles-1"></div>
										<h6 class="fw-bold mt-3 mb-0">Selling</h6>
									</div>
									<div class="px-2 pb-2 pb-md-0 text-center">
										<div id="circles-2"></div>
										<h6 class="fw-bold mt-3 mb-0">Registration</h6>
									</div>
									<div class="px-2 pb-2 pb-md-0 text-center">
										<div id="circles-3"></div>
										<h6 class="fw-bold mt-3 mb-0">Todays new Member</h6>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card full-height">
							<div class="card-body">
								<div class="card-title">Total income & spend statistics</div>
								<div class="row py-3">
									<div class="col-md-4 d-flex flex-column justify-content-around">
										<div>
											<h6 class="fw-bold text-uppercase text-success op-8">Total Income</h6>
											<h3 class="fw-bold">$9.782</h3>
										</div>
										<div>
											<h6 class="fw-bold text-uppercase text-danger op-8">Total Spend</h6>
											<h3 class="fw-bold"></h3>
										</div>
									</div>
									<div class="col-md-8">
										<div id="chart-container">
											<canvas id="totalIncomeChart"></canvas>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Admin and Feed Mill admin start -->
				<?php
				// if(isset($_SESSION['FEED_MILL_ADMIN_LOGIN']) || isset($_SESSION['ADMIN_LOGIN']))
				// {		
				// 	define('VAR_NO_COMPONENT_FEED_MILL_STOCK',true);
				// 	require 'component-feed-mill-stock.php';
				// }

				// if(isset($_SESSION['ADMIN_LOGIN'])){
				// 	define('VAR_NO_COMPONENT_MEDICINE_STOCK',true);
				// 	require('component-medicine-stock.php');
				// } 
				?>
				<!-- Admin and Feed Mill admin end-->
				<div class="row">
					<div class="col-md-8">
						<div class="card">
							<div class="card-header">
								<div class="card-head-row">
									<div class="card-title">User Statistics</div>
									<div class="card-tools">
										<a href="#" class="btn btn-info btn-border btn-round btn-sm mr-2">
											<span class="btn-label">
												<i class="fa fa-pencil"></i>
											</span>
											Export
										</a>
										<a href="#" class="btn btn-info btn-border btn-round btn-sm">
											<span class="btn-label">
												<i class="fa fa-print"></i>
											</span>
											Print
										</a>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="chart-container" style="min-height: 375px">
									<canvas id="statisticsChart"></canvas>
								</div>
								<div id="myChartLegend"></div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card card-primary">
							<div class="card-header">
								<div class="card-title">Daily Sales</div>
								<div class="card-category">March 25 - April 02</div>
							</div>
							<div class="card-body pb-0">
								<div class="mb-4 mt-2">
									<h1>$4,578.58</h1>
								</div>
								<div class="pull-in">
									<canvas id="dailySalesChart"></canvas>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-body pb-0">
								<div class="h1 fw-bold float-right text-warning">+7%</div>
								<h2 class="mb-2">213</h2>
								<p class="text-muted">Transactions</p>
								<div class="pull-in sparkline-fix">
									<div id="lineChart"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Farmer list start -->
				<?php
				// define('VAR_NO_COMPONENT_FARMERS_LIST',true);
				// require 'component-farmers-list.php';
				?>
				<!-- Farms list end -->
			</div>
		<?php
		}
		?>
	</div>

	<?php
	require 'footer.php';
	?>

	<!-- for datatables -->
	<script src="./assets/js/datatable-footer-vicks.js"></script>

	<?php
	if (isset($_SESSION['ADMIN_LOGIN'])) {
	?>
		<!-- for user statistic chart -->
		<script src="./assets/js/demo.js"></script>

		<script>
			Circles.create({
				id: 'circles-1',
				radius: 45,
				value: 12,
				maxValue: 100,
				width: 7,
				// text: <?php // echo is_null($row_sum_of_todays_selling['selling_sum']) ? "0" : $row_sum_of_todays_selling['selling_sum']
							?>,
				text: <?php echo "500" ?>,
				colors: ['#f1f1f1', '#FF9E27'],
				duration: 400,
				wrpClass: 'circles-wrp',
				textClass: 'circles-text',
				styleWrapper: true,
				styleText: true
			})

			Circles.create({
				id: 'circles-2',
				radius: 45,
				value: 70,
				maxValue: 100,
				width: 7,
				// text: <?php //echo is_null($row_sum_of_todays_fee['fee_sum']) ? "0" : $row_sum_of_todays_fee['fee_sum'];
							?>,
				text: <?php echo "1000"; ?>,
				colors: ['#f1f1f1', '#2BB930'],
				duration: 400,
				wrpClass: 'circles-wrp',
				textClass: 'circles-text',
				styleWrapper: true,
				styleText: true
			})

			Circles.create({
				id: 'circles-3',
				radius: 45,
				value: 40,
				maxValue: 100,
				width: 7,
				text: <?php echo is_null($row_sum_of_todays_fee['todays_member_count']) ? "0" : $row_sum_of_todays_fee['todays_member_count']; ?>,
				colors: ['#f1f1f1', '#F25961'],
				duration: 400,
				wrpClass: 'circles-wrp',
				textClass: 'circles-text',
				styleWrapper: true,
				styleText: true
			})

			var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

			var mytotalIncomeChart = new Chart(totalIncomeChart, {
				type: 'bar',
				data: {
					labels: ["S", "M", "T", "W", "T", "F", "S", "S", "M", "T"],
					datasets: [{
						label: "Total Income",
						backgroundColor: '#ff9e27',
						borderColor: 'rgb(23, 125, 255)',
						data: [6, 4, 9, 5, 4, 6, 4, 3, 8, 10],
					}],
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					legend: {
						display: false,
					},
					scales: {
						yAxes: [{
							ticks: {
								display: false //this will remove only the label
							},
							gridLines: {
								drawBorder: false,
								display: false
							}
						}],
						xAxes: [{
							gridLines: {
								drawBorder: false,
								display: false
							}
						}]
					},
				}
			});

			$('#lineChart').sparkline([105, 103, 123, 100, 95, 105, 115], {
				type: 'line',
				height: '70',
				width: '100%',
				lineWidth: '2',
				lineColor: '#ffa534',
				fillColor: 'rgba(255, 165, 52, .14)'
			});
		</script>
	<?php
	}
	?>