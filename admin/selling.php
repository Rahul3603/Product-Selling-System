<?php
define('VAR_NO_DIRECT_ACCESS_HEADER', true);
require 'header.php';

isAdmin();

// ==============================================================================
$table_name = "selling";
$table_name_dropdown = "cust";
$table_name_dropdown2 = "gst_type";
$table_name_dropdown3 = "order_status";
$redirect_to = "selling-history";
$redirect_to2 = "view-selling";
$redirect_self = "selling";
$title = "Product Selling";
// ==============================================================================

$res_product = res_table_status_desc('product');

$total_cost = 0; //imp
$cust_id = "";
$gst_type = "";
$order_status_id = "";

if (isset($_GET['id']) && $_GET['id'] > 0) {
   $id = get_safe_value($_GET['id']);

   //NOT COMMON - CHECK AVAILABILITY OF ID AND REDIRECT
   check_availability_of_order_id($id, $redirect_to);

   $res_selling = mysqli_query($con, "SELECT * FROM `selling` WHERE order_id = '$id' ORDER BY id DESC");

   $row_single_order = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `selling` WHERE order_id = '$id' ORDER BY id DESC LIMIT 1"));

   //IF DELIVERED THEN NO EDIT
   if($row_single_order['order_status'] == 5){
      alert("ALREADY DELIVERED - NO EDIT");
      redirect($redirect_to2."?id=".$id);
      die();
   }

   $cust_id = $row_single_order['cust_id'];
   $gst_type = $row_single_order['gst_type'];
   // $order_status_id = $row_single_order['order_status'];
}

if (isset($_POST['submit'])) {
   $cust_id = get_safe_value($_POST['cust_id']);
   $gst_type = get_safe_value($_POST['gst_type']);
   // $order_status_id = get_safe_value($_POST['order_status_id']);

   $added_on = date('Y-m-d H:i:s');
   

   //BACKEND VALIDATION
   if (IsOnlyDigit($cust_id) == 0 ) { // if false //|| ($order_status_id == 5)
      alert('Error');
      redirect($redirect_to);
      die();
   }

   //IF ID=''
   if ($id == '') {
      $order_count = column_by_id('orders', 'order_count', '1'); //get actual order id; ==unique order id for 4 selling

      $insert_status = false; //false
      if (mysqli_num_rows($res_product) > 0) {
         while ($row_product = mysqli_fetch_assoc($res_product)) {
            $qty_id = "qty" . $row_product['id'];
            $price_id = "price" . $row_product['id'];

            $qty = get_safe_value($_POST[$qty_id]);
            $price = get_safe_value($_POST[$price_id]);

            // $total_cost += ((int)$qty * (float)$price);

            if ($qty != "" && $price != "") {
               mysqli_query($con, "insert into $table_name (cust_id, product_id, price, qty,added_on,future_date,accepted_date,dispatched_date,delivered_date,order_id,gst_type,order_status) values('$cust_id', '" . $row_product['id'] . "', '$price', '$qty', '$added_on','$added_on','$added_on','$added_on','$added_on', '$order_count', '$gst_type','1')");
               //'$order_status_id',
               $insert_status = true; //true    
            }
         }
      }
      //if data inserted successfully
      if ($insert_status) {
         //    if ($gst_type == 1) { //CGST/SGST
         //       $total_cost += (((column_by_id('gst_type', 'perc', $gst_type) * 2) / 100) * $total_cost); //getting percentage after calculting +gst * 2
         //    } else  if ($gst_type == 2) { //IGST
         //       $total_cost += ((column_by_id('gst_type', 'perc', $gst_type)  / 100) * $total_cost); //getting percentage after calculting +gst
         //    }

         /*getting info from cust for cust_id to add balance*/
         // $balance_of_cust =  get_cust_account_latest_balance($cust_id, $total_cost, 'plus');

         // mysqli_query($con, "INSERT INTO `cust_account`(`cust_id`, `selling_id`,`balance`, `added_on`) VALUES ('$cust_id','$order_count','$balance_of_cust','$added_on')");

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
   } //selling edit  
   else if ($id != '') {
      $insert_status = false; //false
      if (mysqli_num_rows($res_selling) > 0) {
         while ($row_selling = mysqli_fetch_assoc($res_selling)) {
            $qty_id = "qty" . $row_selling['product_id'];
            $price_id = "price" . $row_selling['product_id'];

            $qty = get_safe_value($_POST[$qty_id]);
            $price = get_safe_value($_POST[$price_id]);

            // $total_cost += ((int)$qty * (float)$price);

            if ($qty != "" && $price != "") {
               mysqli_query($con, "update $table_name set cust_id='$cust_id',product_id='" . $row_selling['product_id'] . "',price='$price',qty='$qty',added_on='$added_on', gst_type='$gst_type' where id='" . $row_selling['id'] . "'");
               // order_status='$order_status_id',

               $insert_status = true; //true    
            }
         }
      }
      if ($insert_status) {
         echo "<script>
         window.addEventListener('load', function() {
            swal_alert_with_redirect('" . $title . "Edit Complete', 'success', '" . $redirect_to2."?id=".$id . "', '1000');
         });
      </script>";
      } else {
         echo "<script>
         window.addEventListener('load', function() {
            swal_alert_with_redirect('Please enter any details', 'warning', '" . $redirect_to2."?id=".$id . "', '1000');
         });
      </script>";
      }
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
                        <div class="card-title">Selling</div>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6 col-lg-4 m-auto">
                              <div class="form-group">
                                 <label for="<?php echo $table_name_dropdown ?>_id">Factory Name</label>
                                 <select class="form-control" id="<?php echo $table_name_dropdown ?>_id" name="<?php echo $table_name_dropdown ?>_id" data-live-search="true">
                                    <option>Select Option</option>
                                    <?php
                                    $res_dropdown = res_table_status_desc($table_name_dropdown);
                                    while ($row_dropdown = mysqli_fetch_assoc($res_dropdown)) {
                                       $cust_id == $row_dropdown['id'] ? $selected = "selected" : $selected = "";
                                       echo "'<option value=" . $row_dropdown['id'] . " $selected>" . $row_dropdown['name'] . "</option>'";
                                    }
                                    ?>
                                 </select>
                                 <small id="error_<?php echo $table_name_dropdown ?>_id" class="form-text text-danger"></small>
                              </div>
                           </div>
                           <div class="col-md-6 col-lg-4 m-auto">
                              <div class="form-group">
                                 <label for="<?php echo $table_name_dropdown2 ?>">GST Type</label>
                                 <select class="form-control" id="<?php echo $table_name_dropdown2 ?>" name="<?php echo $table_name_dropdown2 ?>" data-live-search="true">
                                    <!-- <option>Select Option</option> -->
                                    <?php
                                    $res_dropdown2 = res_table_asc($table_name_dropdown2);
                                    while ($row_dropdown = mysqli_fetch_assoc($res_dropdown2)) {
                                       echo "'<option value=" . $row_dropdown['id'] . ">" . $row_dropdown['name'] . " (" . $row_dropdown['perc'] . "%)" . "</option>'";
                                    }
                                    ?>
                                 </select>
                                 <small id="error_<?php echo $table_name_dropdown2 ?>_id" class="form-text text-danger"></small>
                              </div>
                           </div>
                           <!-- <div class="col-md-6 col-lg-4 m-auto">
                              <div class="form-group">
                                 <label for="<?php //echo $table_name_dropdown3 ?>_id">Select Order Status</label>
                                 <select class="form-control" id="<?php// echo $table_name_dropdown3 ?>_id" name="<?php //echo $table_name_dropdown3 ?>_id" data-live-search="true"> -->

                                    <!-- <option>Select Option</option> -->
                                    <?php
                                    // $res_dropdown3 = res_table_asc($table_name_dropdown3);
                                    // while ($row_dropdown = mysqli_fetch_assoc($res_dropdown3)) {
                                    //    $order_status_id == $row_dropdown['id'] ? $selected = "selected" : $selected = "";
                                    //    ($row_dropdown['id'] == 4 || $row_dropdown['id'] == 5 || $row_dropdown['id'] == 6) ? $disabled = "disabled" : $disabled = "";
                                    //    echo "'<option value=" . $row_dropdown['id'] . " $disabled  $selected>" . $row_dropdown['name'] . "</option>'";
                                    // }
                                    ?>
                                 <!-- </select>
                                 <small id="error_<?php// echo $table_name_dropdown3 ?>_id" class="form-text text-danger"></small>
                              </div>
                           </div> -->
                        </div>
                        <br />
                        <div class="row bg-light pt-5 pb-5" id="main_form_input">
                           <div class="col-md-8 col-lg-8 m-auto">
                              <div class="table-responsive">
                                 <table id="basic-datatables" class="display table table-hover table-bordered">
                                    <thead>
                                       <tr>
                                          <th class="text-center" style="width:50%">Product</th>
                                          <th class="text-center">Quantity</th>
                                          <th class="text-center">Price</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       if ($id != "") {
                                          if (mysqli_num_rows($res_selling) > 0) {
                                             $i = 1;
                                             while ($row_selling = mysqli_fetch_assoc($res_selling)) {
                                       ?>
                                                <tr>
                                                   <td class="text-center"><?php echo column_by_id('product', 'name', $row_selling['product_id']) ?></td>
                                                   <td class="text-center">
                                                      <div><input type="text" class="text-center" id="qty" name="qty<?php echo $row_selling['product_id'] ?>" placeholder="Enter Count" value="<?php echo $row_selling['qty'] ?>"></div>
                                                      <!-- onkeyup="calc_selling()" onkeydown="calc_selling()" onchange="calc_selling()" -->
                                                   </td>
                                                   <td class="text-center">
                                                      <div><input type="text" class="text-center" id="price" name="price<?php echo $row_selling['product_id'] ?>" placeholder="Enter Price" value="<?php echo $row_selling['price'] ?>"></div>
                                                   </td>
                                                </tr>
                                             <?php
                                             }
                                          }
                                       } else {
                                          if (mysqli_num_rows($res_product) > 0) {
                                             $i = 1;
                                             while ($row_product = mysqli_fetch_assoc($res_product)) {
                                             ?>
                                                <tr>
                                                   <td class="text-center"><?php echo $row_product['name'] ?></td>
                                                   <td class="text-center">
                                                      <div><input type="text" class="text-center" id="qty" name="qty<?php echo $row_product['id'] ?>" placeholder="Enter Count"></div>
                                                      <!-- onkeyup="calc_selling()" onkeydown="calc_selling()" onchange="calc_selling()" -->
                                                   </td>
                                                   <td class="text-center">
                                                      <div><input type="text" class="text-center" id="price" name="price<?php echo $row_product['id'] ?>" placeholder="Enter Price"></div>
                                                   </td>
                                                </tr>
                                       <?php
                                             }
                                          }
                                       }
                                       ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="card card-pricing card-pricing-focus card-primary">
                                 <!-- <h4 class="card-title">ff</h4> -->

                                 <div class="card-body">
                                    <ul class="specification-list">
                                       <li>
                                          <span class="name-specification">Amount</span>
                                          <span class="status-specification">₹22000</span>
                                       </li>
                                       <li>
                                          <span class="name-specification">CGST</span>
                                          <span class="status-specification">₹980</span>
                                       </li>
                                       <li>
                                          <span class="name-specification">SGST</span>
                                          <span class="status-specification">₹980</span>
                                       </li>
                                       <li>
                                          <span class="name-specification">IGST</span>
                                          <span class="status-specification">₹1960</span>
                                       </li>
                                    </ul>
                                 </div>
                                 <div class="card-header">
                                    <div class="card-price">
                                       <span class="price">₹35557</span>
                                       <!-- <span class="text">/mo</span> -->
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="card-action">
                           <button class="btn btn-success" type="submit" name="submit" onclick="return <?php echo $table_name ?>_submit()">Submit</button>
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

   <!-- BootStrap select -->
   <script type="text/javascript">
      $(document).ready(function() {
         $("#<?php echo $table_name_dropdown ?>_id").selectpicker();

      });
      // var var1=0;
      // function calc_selling(){
      //    // alert($(this).val());
      // }
      // $('select').change(function(){
      //    alert("f");
      //    $('input[type=radio][name="is_casting"]:checked').val();
      // });
   </script>