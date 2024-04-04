<?php 
if(!defined('VAR_NO_DIRECT_ACCESS_HEADER')){
	header('location:index');
	die();
}
?>

<footer class="footer">
	<div class="container-fluid">
		<nav class="pull-left">
			<ul class="nav">
				<li class="nav-item">
					<a class="nav-link" href="index">
						Home
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="about">
						About
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="contact">
						Contact
					</a>
				</li>
			</ul>
		</nav>				
	</div>
</footer>
</div>
</div> 
<!-- Wrapper div end here  --> 
<!--   Core JS Files   -->
<script src="./assets/js/core/jquery.3.2.1.min.js"></script>
<script src="./assets/js/core/popper.min.js"></script>
<script src="./assets/js/core/bootstrap.min.js"></script>

<!-- jQuery UI -->
<script src="./assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="./assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
<script src="./assets/js/plugin/jquery-ui-1.13.0/jquery-ui.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="./assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


<!-- Chart JS -->
<script src="./assets/js/plugin/chart.js/chart.min.js"></script>

<!-- jQuery Sparkline -->
<script src="./assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

<!-- Chart Circle -->
<script src="./assets/js/plugin/chart-circle/circles.min.js"></script>

<!-- Datatables -->
<script src="./assets/js/plugin/datatables/datatables.min.js"></script>

<!-- Bootstrap Notify -->
<script src="./assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

<!-- jQuery Vector Maps -->
<!-- <script src="./assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
<script src="./assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script> -->

<!-- Sweet Alert -->
<script src="./assets/js/plugin/sweetalert/sweetalert.min.js"></script>

<!-- Atlantis JS -->
<script src="./assets/js/atlantis.min.js"></script>

<!-- Atlantis DEMO methods, don't include it in your project! -->
<!-- <script src="./assets/js/setting-demo.js"></script> -->

<!-- Custom - Vicks JS -->
<script src="./assets/js/custom-vicks.js"></script>

   <!-- Bootstrap Select -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>


<!-- Camera Script JS -->
<!-- <script src="./assets/js/camera-script.js"></script>have to remove-->

<!-- Footer Year -->
<script>
	document.getElementById("year").innerHTML = new Date().getFullYear();
</script>
<!-- isPassChange -->
<script type="text/javascript">
	/*ispasschange will automatically call when footer call*/
	isPassChange();
	// setInterval(function(){
	// 	isPassChange();
	// }, 5000);
</script>
<script>
	// Preloader
	$(document).ready(function() {
		preloaderFadeOutTime = 500;
		function hidePreloader() {
			var preloader = $('.spinner-wrapper');
			preloader.fadeOut(preloaderFadeOutTime);
		}
		hidePreloader();
	});
</script>
</body>
</html>