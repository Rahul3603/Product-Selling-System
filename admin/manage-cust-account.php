<?php
define('VAR_NO_DIRECT_ACCESS_HEADER', true);
require 'header.php';

isAdmin();

// -----------------------------------------------------
$table_name_dropdown2 = "payment_type";
$redirect_to = "cust-list";

// -----------------------------------------------------


$id = ""; //imp
$balance = 0; //imp
$deposit = ""; //imp


if (isset($_GET['id']) && $_GET['id'] > 0) {
    $cust_id = get_safe_value($_GET['id']);

    //CHECK AVAILABILITY OF ID AND REDIRECT
    check_availability_of_id($cust_id, 'cust', 'cust-list');

    $row_cust = row_cust_by_cust_id($cust_id);

    $res = mysqli_query($con, "SELECT * FROM `cust_account` WHERE cust_id = '$cust_id' ORDER BY id DESC LIMIT 1");

    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
    }
}
else{
    redirect($redirect_to);
}

if (isset($_POST['submit'])) {
    $deposit = get_safe_value($_POST['deposit']);
    $payment_type = get_safe_value($_POST['payment_type']);
    // $balance=get_safe_value($_POST['balance']);
    $added_on = date('Y-m-d h:i:s');

    //BACKEND VALIDATION
    $balance = $row['balance'];

    if ($deposit == '') {
        alert('ERROR');
        redirect('cust-list.php');
        die();
    }
    //------------------------
    $balance -= $deposit;

    mysqli_query($con, "insert into cust_account(cust_id,balance,deposit,payment_type,added_on) values('$cust_id','$balance','$deposit','$payment_type','$added_on')");
?>
    <script>
        window.addEventListener('load', function() {
            swal_alert_with_redirect('Deposit Complete', 'success', 'cust-account?id=<?php echo $cust_id ?>', '1000');

        });
    </script>
<?php
}
?>
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Customer Account</h4>
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
                        <a href="cust-list">Customer List</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form method="post" id="manage-farmer">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title text-danger text-center"><?php echo $row_cust['name'] ?></div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php
                                    input_col_lg_4_readonly('balance', 'Balance', $row['balance']);
                                    input_col_lg_4_with_val('deposit', 'Deposit', $deposit);
                                    ?>
                                    <div class="col-md-6 col-lg-4 m-auto">
                                        <div class="form-group">
                                            <label for="<?php echo $table_name_dropdown2 ?>">Payment Type</label>
                                            <select class="form-control" id="<?php echo $table_name_dropdown2 ?>" name="<?php echo $table_name_dropdown2 ?>" data-live-search="true">
                                                <!-- <option>Select Option</option> -->
                                                <?php
                                                $res_dropdown2 = res_table_status_asc($table_name_dropdown2);
                                                while ($row_dropdown = mysqli_fetch_assoc($res_dropdown2)) {
                                                    echo "'<option value=" . $row_dropdown['id'] . ">" . $row_dropdown['name'] . "</option>'";
                                                }
                                                ?>
                                            </select>
                                            <small id="error_<?php echo $table_name_dropdown2 ?>_id" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-action">
                                <button class="btn btn-success" type="submit" name="submit" onclick="return manage_account_submit()">Submit</button>
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