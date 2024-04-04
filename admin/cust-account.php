<?php
define('VAR_NO_DIRECT_ACCESS_HEADER', true);
require 'header.php';

isAdminAndLogin3Admin();

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']); //cust_id

    //CHECK AVAILABILITY OF ID AND REDIRECT
    check_availability_of_id($id, 'cust', 'cust-list');

    //OWNERSHIP
    if (isset($_SESSION[LOGIN3_CAPTITAL_LOGIN])) {
        $cust_id =  $_SESSION[$login3_captil . '_ID'];
        if ($cust_id != $id) {
            alert("NO ACCESS");
            redirect('cust-account?id=' . $cust_id);
            die();
        }
    }

    $row_cust = row_cust_by_cust_id($id);

    $res = mysqli_query($con, "SELECT * FROM `cust_account` WHERE cust_id = '$id' ORDER BY id DESC");
} else {
    redirect('cust-list');
    die();
}

?>
<div class="main-panel">
    <div class="content">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold"><?= $row_cust['name'] ?> </h2>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <?php
                        echo isset($_SESSION[LOGIN3_CAPTITAL_LOGIN]) ? '' : '<a href="cust-list" class="btn btn-white btn-border btn-round mr-2">Customer List</a>
                        <a href="manage-cust-account?id=' . $id . '" class="btn btn-secondary btn-round">Deposit</a>';
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <!-- cust list start -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Ledger Statement</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#No</th>
                                            <th>Date</th>
                                            <th>Purpose</th>
                                            <th>Description</th>
                                            <th>Invoice</th>
                                            <th>E Way Bill</th>
                                            <th>Debited</th>
                                            <th>Credited</th>
                                            <th>Net Balance</th>
                                            <th>Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#No</th>
                                            <th>Date</th>
                                            <th>Purpose</th>
                                            <th>Description</th>
                                            <th>Invoice</th>
                                            <th>E Way Bill</th>
                                            <th>Debited</th>
                                            <th>Credited</th>
                                            <th>Net Balance</th>
                                            <th>Payment Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php if (mysqli_num_rows($res) > 0) {
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($res)) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $i ?></td>
                                                    <td><?php echo date('d/m/Y h:i A', strtotime($row['added_on'])); ?></td>
                                                    <?php
                                                    // $total_price = 0;
                                                    if ($row['deposit'] == 0) { //from cust_account
                                                        $row_selling =  row_table_by_column_limit('selling','order_id', $row['selling_id']);
                                                        $selling_cost = explode("_", selling_cost($row['selling_id']));
                                                    ?>
                                                        <td> Order </td>
                                                        <td class="text-nowrap"><?php echo selling_orders_details_row($row['selling_id']) ?></td>
                                                        <!-- selling_orders_row($row['selling_id'], 'product_id') -->
                                                        <td class="text-nowrap"><?php echo $row_selling['original_invoice'] != '' ? "<a href='" . $pdf_path . $row_selling['original_invoice'] . "' target='_blank'>" . $row_selling['mr_order_no'] . ".pdf</a>" : '-';  ?></td>
                                                        <td class="text-nowrap"><?php echo $row_selling['eway_bill'] != '' ? "<a href='" . $pdf_path . $row_selling['eway_bill'] . "' target='_blank'>E-Way.pdf</a>" : 'NA';  ?></td>
                                                        <td><?php echo $selling_cost[1]?></td>

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <td><?php echo column_by_id('payment_type', 'name', $row['payment_type']) ?></td>
                                                        <td> - </td>
                                                        <td> - </td>
                                                        <td> NA </td>
                                                        <td> - </td>
                                                    <?php
                                                    }
                                                    if ($row['deposit'] == 0) {
                                                        // $selling_cost = explode("_", selling_cost($row['selling_id']));
                                                    ?>
                                                        <td><?php echo $row['deposit'] ?></td>
                                                        <!-- <td> -->
                                                            <?php
                                                            // echo "Amount - " . $selling_cost[0] .
                                                            //     "<br> GST - " . $selling_cost[2] .
                                                            //     "<hr> Total - " . $selling_cost[1]
                                                            ?>
                                                        <!-- </td> -->
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <td class="bg-success text-white">
                                                            <?php echo $row['deposit'] ?></td>
                                                        <!-- <td> - </td> -->
                                                    <?php
                                                    }
                                                    ?>
                                                   
                                                        <?php
                                                        if ($row['balance'] > 0) {
                                                            echo  " <td><span class='text-success'><strong>" . $row['balance'] . "</strong></span> </td>";
                                                            echo  " <td><span class='text-danger'><strong>Pending</strong></span> </td>";
                                                        } else {
                                                            echo  " <td><span class='text-danger'><strong>" . $row['balance'] . "</strong></span> </td>";
                                                            echo  " <td><span class='text-success'><strong>Nil</strong></span> </td>";
                                                        }
                                                        ?>
                                                   
                                                </tr>
                                            <?php
                                                $i++;
                                            }
                                        } else { ?>
                                            <tr>
                                                <td class="text-center" colspan="100%">No data found</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- cust list end -->
        </div>
    </div>

    <?php
    require 'footer.php';
    ?>

    <!-- for datatables -->
    <script src="./assets/js/datatable-footer-vicks.js"></script>