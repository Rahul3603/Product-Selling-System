<?php

if (!defined('VAR_NO_DIRECT_ACCESS_HEADER')) {
    header('location:index');
    die();
}

include('../connection.php');
include('./functions.php');

$user_id = "";
$user_name = "";
$user_mobile = "";

if (isset($_SESSION['ADMIN_LOGIN']) && ($_SESSION['ADMIN_LOGIN'] != '')) {
    $user_id = $_SESSION['ADMIN_ID'];
    $row = mysqli_fetch_assoc(mysqli_query($con, "select * from admin where id='$user_id'"));
    $user_name = $row['name'];
} else if (isset($_SESSION['EMP_LOGIN']) && ($_SESSION['EMP_LOGIN'] != '')) {
    $user_id = $_SESSION['EMP_ID'];
    $row = mysqli_fetch_assoc(mysqli_query($con, "select * from emp where id='$user_id'"));
    $user_name = $row['name'];
    $user_mobile = $row['mobile'];
} else if (isset($_SESSION[$login3_captil . '_LOGIN']) && ($_SESSION[$login3_captil . '_LOGIN'] != '')) {
    $user_id = $_SESSION[$login3_captil . '_ID'];
    $row = mysqli_fetch_assoc(mysqli_query($con, "select * from $login3 where id='$user_id'"));
    $user_name = $row['name'];
    $user_mobile = $row['mobile'];
} else {
    header('location:login.php');
    die();
}

if (isset($_SESSION['LAST_ACTIVE_TIME'])) {
    if ((time() - $_SESSION['LAST_ACTIVE_TIME']) > 10800) {
        header('location:logout.php');
        die();
    }
}

$_SESSION['LAST_ACTIVE_TIME'] = time();
$curStr = $_SERVER['REQUEST_URI'];
$curArr = explode('/', $curStr);
$cur_path = $curArr[count($curArr) - 1];

date_default_timezone_set('Asia/Kolkata');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php echo PROJECT_NAME; ?></title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="../assets/image/rk-industries-fav.png" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="./assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['./assets/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/atlantis.min.css">
    <link rel="stylesheet" href="./assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="./assets/css/vicks-css.css">
    <!-- Bootstrap Select -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <!-- ----------- -->

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <!-- 	<link rel="stylesheet" href="./assets/css/demo.css"> -->
</head>

<body>
    <!-- --Preloader start------------- -->
    <div class="spinner-wrapper">
        <div class="spinner"></div>
    </div>
    <!-- --Preloader end------------- -->
    <!-- Preloader ajax start-->
    <div class="spinner-wrapper-ajax" style="display:none">
        <div class="spinner"></div>
    </div>
    <!-- Preloader ajax end-->
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue">

                <a href="index" class="logo">
                    <!-- <img src="./assets/image/logo.png" alt="" class="navbar-brand"> -->
                    <span class="text-white navbar-brand"><?php echo LOGO_NAME; ?></span>
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

                <div class="container-fluid">
                    <!-- 			<div class="collapse" id="search-nav">
						<form class="navbar-left navbar-form nav-search mr-md-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<button type="submit" class="btn btn-search pr-1">
										<i class="fa fa-search search-icon"></i>
									</button>
								</div>
								<input type="text" placeholder="Search ..." class="form-control">
							</div>
						</form>
					</div> -->
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <?php
                        if (isset($_SESSION['ADMIN_LOGIN'])) {

                            $notification_count = 0;

                            // $sql_notification="select notification.*, farmers.name as farmer_name, supervisor.name as supervisor_name from notification,farmers,supervisor where notification.farmer_id=farmers.id and notification.supervisor_id=supervisor.id and notification.status=0 order by id desc"; //unseen notification
                            // $res_notification = mysqli_query($con,$sql_notification);
                            // $notification_count = mysqli_num_rows($res_notification);
                        ?>

                            <li class="nav-item dropdown hidden-caret">
                                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell"></i>
                                    <span class="notification"><?php echo $notification_count; ?></span>
                                </a>
                                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                                    <li>
                                        <div class="dropdown-title">You have <?php echo $notification_count; ?> new
                                            notification</div>
                                    </li>
                                    <li>
                                        <div class="notif-scroll scrollbar-outer">
                                            <div class="notif-center">
                                                <?php
                                                // if($notification_count>0){
                                                // 	while($row_notification=mysqli_fetch_assoc($res_notification)){
                                                ?>

                                                <a href="#" onclick="manage_notification()">
                                                    <div class="notif-icon notif-primary"> <i class="fa fa-check-square "></i> </div>
                                                    <div class="notif-content">
                                                        <span class="block">
                                                            <span class="text-success"><?php //echo ucfirst($row_notification['supervisor_name'])." - ".ucfirst($row_notification['farmer_name']); 
                                                                                        ?></span>

                                                        </span>
                                                        <span class="time"><?php //echo timeAgo($row_notification['added_on']);
                                                                            ?></span>
                                                    </div>
                                                </a>
                                                <?php
                                                // 	}
                                                // }
                                                // else{
                                                ?>
                                                <a href="#">
                                                    <div class="notif-icon notif-danger"> <i class="fa fa-minus-circle"></i>
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block">
                                                            No New Notification
                                                        </span>
                                                        <!-- <span class="time">17 minutes ago</span>  -->
                                                    </div>
                                                </a>
                                                <?php
                                                //}
                                                ?>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="see-all" href="javascript:void(0);" onclick="manage_notification('0')">Clear all notifications<i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </li>
                        <?php
                        }
                        ?>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="./assets/image/user-pic.jpg" alt="<?php echo PROJECT_NAME; ?>" class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg"><img src="./assets/image/user-pic.jpg" alt="image profile" class="avatar-img rounded"></div>
                                            <div class="u-text">
                                                <h4><?php echo ucfirst($user_name); ?></h4>
                                                <p class="text-muted"><?php echo $user_mobile; ?></p>
                                                <a href="logout" class="btn btn-xs btn-secondary btn-sm">Logout</a>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2">
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm float-left mr-2">
                            <img src="./assets/image/user-pic.jpg" alt="<?php echo LOGO_NAME; ?>" class="avatar-img rounded-circle">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                <span>
                                    <?php echo ucfirst($user_name); ?>
                                    <span class="user-level"><?php echo strtoupper($_SESSION['ROLE']) ?></span>
                                    <span class="caret"></span>
                                </span>
                            </a>
                            <div class="clearfix"></div>

                            <div class="collapse in" id="collapseExample">
                                <ul class="nav">
                                    <li>
                                        <a href="logout">
                                            <span class="link-collapse">Logout</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-primary">
                        <li class="nav-item <?php if ($cur_path == "" || $cur_path == "index") {
                                                echo "active submenu";
                                            } else {
                                                echo "";
                                            } ?>">
                            <a href="index" class="collapsed" aria-expanded="false">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Components</h4>
                        </li>

                        <?php

                        if (isset($_SESSION['ADMIN_LOGIN'])) {
                        ?>
                            <!-- selling menu start -->
                            <li class="nav-item  <?php if ($cur_path == "selling-history" || $cur_path == "selling") {
                                                        echo "active submenu";
                                                    } else {
                                                        echo "";
                                                    } ?>">
                                <a data-toggle="collapse" href="#selling">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Orders</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse <?php if ($cur_path == "selling-history" || $cur_path == "selling") {
                                                            echo "show";
                                                        } else {
                                                            echo "";
                                                        } ?>" id="selling">
                                    <ul class="nav nav-collapse">
                                        <li class="<?php if ($cur_path == "selling-history") {
                                                        echo "active";
                                                    } else {
                                                        echo "";
                                                    } ?>">
                                            <a href="selling-history">
                                                <span class="sub-item">Order Status</span>
                                            </a>
                                        </li>
                                        <li class="<?php if ($cur_path == "selling") {
                                                        echo "active";
                                                    } else {
                                                        echo "";
                                                    } ?>">
                                            <a href="selling">
                                                <span class="sub-item">New Tin Order</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- selling menu end -->

                            <!-- Cust menu start -->
                            <li class="nav-item  <?php if ($cur_path == "cust-list" || $cur_path == "manage-cust") {
                                                        echo "active submenu";
                                                    } else {
                                                        echo "";
                                                    } ?>">
                                <a data-toggle="collapse" href="#cust">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Customer</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse <?php if ($cur_path == "cust-list" || $cur_path == "manage-cust") {
                                                            echo "show";
                                                        } else {
                                                            echo "";
                                                        } ?>" id="cust">
                                    <ul class="nav nav-collapse">
                                        <li class="<?php if ($cur_path == "cust-list") {
                                                        echo "active";
                                                    } else {
                                                        echo "";
                                                    } ?>">
                                            <a href="cust-list">
                                                <span class="sub-item">Customer List</span>
                                            </a>
                                        </li>
                                        <li class="<?php if ($cur_path == "manage-cust") {
                                                        echo "active";
                                                    } else {
                                                        echo "";
                                                    } ?>">
                                            <a href="manage-cust">
                                                <span class="sub-item">Add Customer</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Cust menu end -->
                            <!-- Product menu start -->
                            <li class="nav-item  <?php if ($cur_path == "product-list" || $cur_path == "manage-product") {
                                                        echo "active submenu";
                                                    } else {
                                                        echo "";
                                                    } ?>">
                                <a data-toggle="collapse" href="#product">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Product</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse <?php if ($cur_path == "product-list" || $cur_path == "manage-product") {
                                                            echo "show";
                                                        } else {
                                                            echo "";
                                                        } ?>" id="product">
                                    <ul class="nav nav-collapse">
                                        <li class="<?php if ($cur_path == "product-list") {
                                                        echo "active";
                                                    } else {
                                                        echo "";
                                                    } ?>">
                                            <a href="product-list">
                                                <span class="sub-item">Product List</span>
                                            </a>
                                        </li>
                                        <li class="<?php if ($cur_path == "manage-product") {
                                                        echo "active";
                                                    } else {
                                                        echo "";
                                                    } ?>">
                                            <a href="manage-product">
                                                <span class="sub-item">Add Product</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Product menu end -->
                            <!-- GST Type start -->
                            <li class="nav-item <?php if ($cur_path == "gst-type-list") {
                                                    echo "active submenu";
                                                } else {
                                                    echo "";
                                                } ?>">
                                <a href="gst-type-list" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-home"></i>
                                    <p>GST Type </p>
                                </a>
                            </li>
                            <!-- GST Type end -->
                            <!-- payment Type start -->
                            <li class="nav-item <?php if ($cur_path == "payment-type-list") {
                                                    echo "active submenu";
                                                } else {
                                                    echo "";
                                                } ?>">
                                <a href="payment-type-list" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-home"></i>
                                    <p>Payment Type </p>
                                </a>
                            </li>
                            <!-- GST Type end -->
                            <!-- Order Status Type start -->
                            <li class="nav-item <?php if ($cur_path == "order-status-list") {
                                                    echo "active submenu";
                                                } else {
                                                    echo "";
                                                } ?>">
                                <a href="order-status-list" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-home"></i>
                                    <p>Order Status Type </p>
                                </a>
                            </li>
                            <!-- Order Status Type end -->
                            <!--  Contact Start -->
                            <li class="nav-item  <?php if ($cur_path == "contact-form") {
                                                        echo "active submenu";
                                                    } else {
                                                        echo "";
                                                    } ?>">
                                <a data-toggle="collapse" href="#contact_form">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Contact</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse <?php if ($cur_path == "contact-form") {
                                                            echo "show";
                                                        } else {
                                                            echo "";
                                                        } ?>" id="contact_form">
                                    <ul class="nav nav-collapse">
                                        <li class="<?php if ($cur_path == "contact-form") {
                                                        echo "active";
                                                    } else {
                                                        echo "";
                                                    } ?>">
                                            <a href="contact-form">
                                                <span class="sub-item">Contact Form</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!--  Contact end -->
                            <!-- -------------------- -->
                        <?php
                        }
                        if (isset($_SESSION[$login3_captil . '_LOGIN'])) {

                        ?>
                            <!-- New Tin Order start -->
                            <li class="nav-item <?php if ($cur_path == "selling-cust") {
                                                    echo "active submenu";
                                                } else {
                                                    echo "";
                                                } ?>">
                                <a href="selling-cust" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-home"></i>
                                    <p>New Tin Order </p>
                                </a>
                            </li>
                            <!-- New Tin Order end -->
                            <!-- Order Status start -->
                            <li class="nav-item <?php if ($cur_path == "selling-history") {
                                                    echo "active submenu";
                                                } else {
                                                    echo "";
                                                } ?>">
                                <a href="selling-history" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-home"></i>
                                    <p>Order Status </p>
                                </a>
                            </li>
                            <!-- Order Status end -->
                            <!-- Ledger Statement start -->
                            <li class="nav-item <?php if ($cur_path == "cust-account?id=" . $_SESSION[$login3_captil . '_ID']) {
                                                    echo "active submenu";
                                                } else {
                                                    echo "";
                                                } ?>">
                                <a href="cust-account?id=<?php echo $_SESSION[$login3_captil . '_ID'] ?>" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-home"></i>
                                    <p>Ledger Statement </p>
                                </a>
                            </li>
                            <!-- Ledger Statement end -->
                            <!-- GST File Status start -->
                            <!-- <li class="nav-item <?php if ($cur_path == "gst-type-list?id=" . $_SESSION[$login3_captil . '_ID']) {
                                                    echo "active submenu";
                                                } else {
                                                    echo "";
                                                } ?>">
                                <a href="gst-type-list?id=<?php echo $_SESSION[$login3_captil . '_ID'] ?>" class="collapsed" aria-expanded="false">
                                    <i class="fas fa-home"></i>
                                    <p>GST File Status </p>
                                </a>
                            </li> -->
                            <!-- GST File Status end -->

                        <?php
                        }

                        ?>

                        <li class="mx-4 mt-2">
                            <a href="tel:918600721732" class="btn btn-primary btn-block"><span class="btn-label mr-2">
                                    <i class="fa fa-mobile"></i> </span>Contact Developer</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <script type="text/javascript">
            function manage_notification(notification_id) {
                jQuery.ajax({
                    url: 'manage-notification-ajax.php',
                    type: 'post',
                    data: 'notification_id=' + notification_id,
                    success: function(result) {
                        // alert(result);
                        if (result == 1) {
                            window.location.href = 'daily-entry-list';
                        } else if (result == 0) {
                            window.location.href = 'daily-entry-list';
                        }
                    }
                });
            }
        </script>