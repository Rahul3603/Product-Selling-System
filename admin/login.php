
<?php
include('../connection.php');
include('./functions.php');
error_reporting(E_ERROR | E_PARSE);
$msg='';

if(isset($_SESSION['ADMIN_LOGIN']))
{
    redirect('index');
}
else if($is_login3){
    if(isset($_SESSION[$login3_captil.'_LOGIN']))
    {
        redirect('index');
    }
}

if(isset($_POST['submit'])){
    $mobile=get_safe_value($_POST['mobile']);
    $password=get_safe_value($_POST['password']);
    $res=mysqli_query($con,"select * from admin where mobile='$mobile'");
    $count=mysqli_num_rows($res);

    $res_login3=mysqli_query($con,"select * from cust where manager_mob='$mobile'");
    $count_login3=mysqli_num_rows($res_login3);


    if($count>0){
        $row=mysqli_fetch_assoc($res);
        if($password==$row['password']){
            $_SESSION['ADMIN_LOGIN']='yes';
            $_SESSION['ADMIN_ID']=$row['id']; 
            $_SESSION['ADMIN_MOBILE']=$mobile;
            $_SESSION['ROLE']="admin";
            $_SESSION['LAST_ACTIVE_TIME']=time();
            header('location:index'); 
            die();
        }
        else{
            $msg="Please enter correct login details";
        }
    }
    else if($count_login3>0){
        $row=mysqli_fetch_assoc($res_login3);
        if($password==$row['password']){
            if($row['status']==1){
                $_SESSION['CUST_LOGIN']='yes';
                $_SESSION['CUST_ID']=$row['id']; 
                $_SESSION['CUST_MOBILE']=$mobile;
                $_SESSION['ROLE']=$login3_title;
                $_SESSION['LAST_ACTIVE_TIME']=time();
                header('location:index');
                die();
            }
            else{
                $msg = "Your account is Disabled. Please contact to Admin";
            } 
        }
        else{
            $msg="Please enter correct login details";
        }  
    }
    else{
        $msg="Please enter correct Mobile and Password";  
    } 
}
?>


<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content=" <?php echo PROJECT_NAME;?>">
    <meta name="author" content="<?php echo PROJECT_NAME;?>">
    <!-- Favicon icon -->
    <link rel="icon" href="../assets/image/rk-industries-fav.png" type="image/x-icon"/>
    <title><?php echo PROJECT_NAME;?> Admin - Vicks Tricks</title>
    <!-- Custom CSS -->
    <link href="./assets/css/login-style.min.css" rel="stylesheet">

    <style type="text/css">
        #otpform{
            display:none;
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
            <div class="auth-box bg-dark border-top border-secondary">
                <div id="loginform">
                    <div class="text-center p-t-20 p-b-5 bg-white">
                        <h3><span class="db"><?php echo LOGO_NAME;?></span></h3>
                    </div>
                    <!-- Form -->
                    <form class="form-horizontal m-t-20" id="loginform" method="post">
                        <div class="row p-b-30">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" name="mobile" class="form-control form-control-lg" placeholder="Mobile Number" aria-label="Mobile" aria-describedby="basic-addon1" required="">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20 text-center">
                                        <button class="btn btn-success" type="submit" name="submit">Login</button>
                                    </div>
                                    <div class="mt-3">
                                        <h3 class="text-danger text-center"><?php echo $msg; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="recoverform">
                    <div class="text-center">
                        <span class="text-white">Enter your e-mail address below will send a Email to forgot a Password.</span>
                    </div>
                    <div class="row m-t-20">
                        <!-- Form -->
                        <form class="col-12" id="forgotPasswordForm" method="post">
                            <!-- email -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white" id="basic-addon1"><i class="ti-email"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-lg" placeholder="Email Address" aria-label="mobile" aria-describedby="basic-addon1" id="email" name="email">
                            </div>
                            <!-- pwd -->
                            <div class="row m-t-20 p-t-20 border-top border-secondary">
                                <div class="col-12">
                                    <a class="btn btn-success" href="#" id="to-login" name="action">Back To Login</a>
                                    <button class="btn btn-info float-right send_reset_pass_link" type="button" onclick="reset_password()">Reset Password</button>
                                    <!-- <button class="btn btn-success float-right" type="submit" name="submit">Login</button> -->
                                    <div class="mt-3">
                                        <h3 class="text-danger text-center" id="forget_password_error"></h3>
                                        <h3 class="text-success text-center" id="forget_password_success"></h3>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
<!--                 <div id="otpform">
                    <div class="text-center">
                        <span class="text-white">Enter your OTP sent on Email</span>
                    </div>
                    <div class="row m-t-20">
                        <form class="col-12" id="forgotPasswordForm" method="post">
                          
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white" id="basic-addon1"><i class="ti-email"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-lg" placeholder="OTP" aria-label="OTP" aria-describedby="basic-addon1" id="otp" name="otp">
                            </div>
                           
                            <div class="row m-t-20 p-t-20 border-top border-secondary">
                                <div class="col-12">
                                    <a class="btn btn-success" href="index" id="to-login" name="action">Back To Login</a>
                                    <button class="btn btn-info float-right button_submit" type="button" onclick="submit_otp()">Submit</button>
                                    <div class="mt-3">
                                        <h3 class="text-danger text-center" id="forget_password_otp_error"></h3>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div> -->
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <!-- <script src="assets/libs/jquery/dist/jquery.min.js"></script> -->
    <script src="./assets/js/core/jquery.3.2.1.min.js"></script>
    
    <!-- Bootstrap tether Core JavaScript -->
    <!-- <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
        <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script> -->
        <script src="./assets/js/core/popper.min.js"></script>
        <script src="./assets/js/core/bootstrap.min.js"></script>
        <!-- ============================================================== -->
        <!-- This page plugin js -->
        <!-- ============================================================== -->
        <script>

            $('[data-toggle="tooltip"]').tooltip();
            $(".preloader").fadeOut();
    // ============================================================== 
    // Login and Recover Password 
    // ============================================================== 
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
    $('#to-login').click(function(){

        $("#recoverform").hide();
        // $("#otpform").hide();
        $("#loginform").fadeIn();
    });
</script>
<script type="text/javascript">
    function reset_password(){
        jQuery('.send_reset_pass_link').attr('disabled', true);
        jQuery('#forget_password_error').html('');
        jQuery('#forget_password_success').html('');
        var email=jQuery('#email').val();
        jQuery.ajax({
            url:'reset_password_ajax.php',
            type:'post',
            data:'email='+email,
            beforeSend: function(){
                $('.spinner-wrapper-ajax').show();
            },
            success:function(result){
                result = result.trim();
                if(result=='yes'){
                 jQuery('#forget_password_success').html('We have sent email for password reset.');
             }
             if(result=='not_exist'){
                jQuery('#forget_password_error').html('Please enter valid email');
                jQuery('.send_reset_pass_link').attr('disabled', false);
            }
        },
        complete: function(){
            $('.spinner-wrapper-ajax').fadeOut(500);
        }
    });
    }
</script>

</body>


</html>