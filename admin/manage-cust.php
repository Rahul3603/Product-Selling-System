<?php
define('VAR_NO_DIRECT_ACCESS_HEADER', true);
require 'header.php';
isAdmin();
// ==============================================================================
$table_name = "cust";
$redirect_to = "cust-list";
$title = "Customer";
// ==============================================================================

$id = "";
$mr = "";
$email = "";
$name = "";
$owner_name = "";
$mobile = "";
$manager_mob = "";
$manager_name = "";
$address = "";
$pincode = "";
$pass = "";


if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']);

    //CHECK AVAILABILITY OF ID AND REDIRECT
    check_availability_of_id($id, $table_name, $redirect_to);

    $row = row_table_by_id($table_name, $id);

    $email = $row['email'];
    $name = $row['name']; //factory name
    $owner_name = $row['owner_name'];
    $mobile = $row['mobile'];
    $pincode = $row['pincode'];
    $mr = $row['mr'];
    $manager_mob = $row['manager_mob'];
    $manager_name = $row['manager_name'];
    $address = $row['address'];
    $pass = $row['password'];
}

if (isset($_POST['submit'])) {

    $email = get_safe_value($_POST['email']);
    $name = ucfirst(get_safe_value($_POST['name']));
    $owner_name = ucfirst(get_safe_value($_POST['owner_name']));
    $mobile = get_safe_value($_POST['mobile']);
    $pincode = get_safe_value($_POST['pincode']);
    $address = get_safe_value($_POST['address']);
    $mr = get_safe_value($_POST['mr']);
    $manager_mob = get_safe_value($_POST['manager_mob']);
    $manager_name = get_safe_value($_POST['manager_name']);
    $pass = get_safe_value($_POST['pass']);
    $added_on = date('Y-m-d H:i:s');

    // //BACKEND VALIDATION
    if ($mr == "" || $name == "" || $owner_name == "" || $manager_name == "" || IsEmail($email) == 0 || IsPincode($pincode) == 0 ||  $name == "" || IsMobile($mobile) == 0 || IsMobile($manager_mob) == 0 || $address == "" || $pass == "") {
        alert("Incomplete");
        redirect($redirect_to);
        die();
    }

    if ($id == '') {
        $sql = "select * from $table_name where mobile='$mobile'";
    } else {
        $sql = "select * from $table_name where mobile='$mobile' and id!='$id'";
    }
    if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
?>
        <script>
            window.addEventListener('load', function() {
                swal_alert_without_redirect('<?php echo $title; ?> Already Registered', 'warning');
            });
        </script>
        <?php
    } else {
        if ($id == '') {
            mysqli_query($con, "insert into $table_name(mr,email,name,owner_name,manager_name,mobile,manager_mob,password,address,pincode,status,added_on) values('$mr','$email','$name','$owner_name','$manager_name','$mobile','$manager_mob','$pass','$address','$pincode',1,'$added_on')");

        ?>
            <script>
                window.addEventListener('load', function() {
                    swal_alert_with_redirect('<?php echo $title; ?> Added', 'success', "<?php echo $redirect_to; ?>", 1000)
                });
            </script>
        <?php
        } else {
            mysqli_query($con, "update $table_name set mr='$mr',name='$name',owner_name='$owner_name',manager_name='$manager_name',email='$email',mobile='$mobile', manager_mob='$manager_mob', password='$pass', address='$address', pincode='$pincode' where id='$id'");
        ?>
            <script>
                window.addEventListener('load', function() {
                    swal_alert_with_redirect('<?php echo $title; ?> Updated', 'success', "<?php echo $redirect_to; ?>", 1000)
                });
            </script>
<?php
        }
    }
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
                        <a href="emp-list"><?php echo $title ?> List</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="manage-emp"><?php echo $title ?> Registration</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form method="post" id="manage-emp" enctype="multipart/form-data">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">New <?php echo $title ?> Registration</div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <?php
                                    input_col_lg_4_with_val('mr', 'RK No', $mr);
                                    input_col_lg_4_with_val('name', 'Factory Name', $name); //factory 
                                    input_col_lg_4_with_val('owner_name', 'Owner Name', $owner_name);
                                    input_col_lg_4_with_val('email', 'Email', $email);
                                    input_col_lg_4_with_val('mobile', 'Owner Mobile', $mobile);
                                    input_col_lg_4_with_val('manager_name', 'Manager Name', $manager_name);
                                    input_col_lg_4_with_val('manager_mob', 'Manager Mobile', $manager_mob);
                                    input_col_lg_4_with_val('pass', 'Password', $pass);
                                    ?>

                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea class="form-control" id="address" name="address" rows="4"><?php echo $address; ?></textarea>
                                            <small id="error_address" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <?php
                                    input_col_lg_4_with_val('pincode', 'Pincode', $pincode);
                                    ?>
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