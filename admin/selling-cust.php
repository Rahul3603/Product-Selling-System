<?php
define('VAR_NO_DIRECT_ACCESS_HEADER', true);
require 'header.php';

isLogin3Admin();
// ==============================================================================
$table_name = "selling";
// $table_name_dropdown = "cust";
// $table_name_dropdown2 = "gst_type";
// $table_name_dropdown3 = "order_status";
$redirect_to = "selling-history";
// $redirect_self = "selling";
$title = "Product Selling";
// ==============================================================================

$res = res_table_status_asc('product');
$cust_id = $_SESSION[$login3_captil . '_ID'];

if (isset($_POST['submit'])) {

   $added_on = date('Y-m-d H:i:s');
   $future_date = date("Y-m-d",strtotime(get_safe_value($_POST['future_date'])));

   //BACKEND VALIDATION
   // if (IsOnlyDigit($cust_id) == 0 || ($order_status_id == 4 || $order_status_id == 4 || $order_status_id == 5)) { // if false
   //    alert('Error');
   //    redirect($redirect_to);
   //    die();
   // }


   $order_count = column_by_id('orders', 'order_count', '1'); //get actual order id; ==unique order id for 4 selling

   $insert_status = false; //false
   if (mysqli_num_rows($res) > 0) {
      while ($row = mysqli_fetch_assoc($res)) {
         $qty_id = "qty" . $row['id'];

         $qty = get_safe_value($_POST[$qty_id]);


         if ($qty != "") {//added future date as accept,dipstch and delvry date
            mysqli_query($con, "insert into $table_name (cust_id, product_id, qty,added_on,accepted_date,dispatched_date,delivered_date,order_status,order_id,future_date) values('$cust_id', '" . $row['id'] . "', '$qty', '$added_on','$future_date','$future_date','$future_date', '1', '$order_count','$future_date')");

            $insert_status = true; //true    
         }
      }
   }
   //if data inserted successfully
   if ($insert_status) {

      $order_count++;
      mysqli_query($con, "update orders set order_count='$order_count' where id='1'");

      echo "<script>
            window.addEventListener('load', function() {
               swal_alert_with_redirect('" . $title . " Complete', 'success', '" . $redirect_to . "', '1000');
            });
         </script>";
   } else {
      echo "<script>
            window.addEventListener('load', function() {
               swal_alert_with_redirect('Please enter any details', 'warning', '" . $redirect_self . "', '1000');
            });
         </script>";
   }

   // -----------------
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
                  <a href="selling-history"><?php echo $title ?> List </a>
               </li>
            </ul>
         </div>
         <div class="row">
            <div class="col-md-12">
               <form method="post">
                  <div class="card">
                     <div class="card-header">
                        <div class="card-title"><?php echo column_by_id('cust', 'name', $cust_id) ?></div>
                     </div>
                     <div class="card-body">

                        <div class="row bg-light pt-5 pb-5" id="main_form_input">
                           <div class="col-md-6 col-lg-6 m-auto">
                              <div class="form-group">
                                 <label for="future_date">Requested Order Date</label>
                                 <input type="text" class="form-control" id="future_date" name="future_date" placeholder="Select Date" readonly='true'>
                                 <small id="error_future_date" class="form-text text-danger"></small>
                              </div>
                           </div>
                           <div class="col-md-8 col-lg-8 m-auto">
                              <div class="table-responsive">
                                 <table id="basic-datatables" class="display table table-hover table-bordered">
                                    <thead>
                                       <tr>
                                          <th class="text-center" style="width:50%">Product</th>
                                          <th class="text-center">Quantity</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       if (mysqli_num_rows($res) > 0) {
                                          $i = 1;
                                          while ($row = mysqli_fetch_assoc($res)) {
                                       ?>
                                             <tr>
                                                <td class="text-center"><?php echo $row['name'] ?></td>
                                                <td class="text-center">
                                                   <div><input type="text" class="text-center" id="qty" name="qty<?php echo $row['id'] ?>" placeholder="Enter Count" onkeyup="calc_selling()"></div>

                                                </td>

                                             </tr>
                                       <?php
                                             $i++;
                                          }
                                       }
                                       ?>
                                    </tbody>
                                    <tfoot>
                                       <tr>
                                          <th class="text-center">Total Quantity</th>
                                          <th class="text-center"><input type="text" id="total_quantity" disabled value="0" class="text-center"></th>
                                       </tr>
                                    </tfoot>
                                 </table>
                              </div>
                           </div>

                        </div>

                        <div class="card-action">
                           <button class="btn btn-success" type="submit" name="submit" onclick="return <?php echo $table_name ?>_cust_submit()">Submit</button>
                        </div>
                     </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <?php
   require 'footer.php';

   $product_count = count_column_status('product', 'id');
   ?>
   <script type="text/javascript">
      $(document).ready(function() {
         $("#future_date").datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true,
            yearRange: "-0:+1",
            minDate: '0d'
         });
      });
      //  ---------------------------


      function calc_selling() {
         var sum = 0;
         for (var i = 1; i <= <?php echo $product_count; ?>; i++) {
            var qty = parseInt($("input[name=qty" + i + "]").val());
            var a = isNaN(qty) ? 0 : qty;
            sum += a;
         }
         jQuery('#total_quantity').val(sum);
      }
   </script>