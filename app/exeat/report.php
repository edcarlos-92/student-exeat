<?php $title = "Exeat - Update" ?>
<?php include_once('../../header.php') ?>
<?php include_once('../../menu.php'); ?>
<ol class="breadcrumb no-print">
    <li class="breadcrumb-item">
        <a href="<?php echo $baseurl; ?>app/dashboard/dashboard.php">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Exeat Report</li>
</ol>
<?php
if (isset($_GET['id'])) {
    // $query = "SELECT * FROM exeat Where  exeat_id= '" . $_GET['id'] . "'";
    $query = "SELECT  t.*,s.*,h.*,f.* FROM exeat t, student s, house h, form f  WHERE t.student_id = s.student_id AND s.house_id = h.house_id AND s.form_id = f.form_id  AND  t.exeat_id= '" . $_GET['id'] . "'";

    $result = $db->query($query);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($rpt_row = $result->fetch_assoc()) {
            //Send message now
            // echo $rpt_row['first_name'];
            // $student_info_query = "Select * from  student where student_id = '$student_id'";
            // $student_info_result = $db->query($student_info_query);
            // if ($student_info_result->num_rows > 0) {
            // 	while ($std_row = $student_info_result->fetch_assoc()) {
            // 		//Send message now
            // 		echo $std_row['first_name'];
            // 	}
            // }

?>

<body>
    <div id='report-page'>


        <div style="display:flex;justify-content:center">
            <!-- <div class="row"> -->
            <?php //$id = $_POST['exeat_id']; 
                        ?>


            <div class="receipt-main col-xs-10 col-sm-10 col-md-10 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">



                <div class="container text-center">

                    <?php $imgURL = $baseurl . "app/media_upload/upload/" . explode(',', $rpt_row['photo_id'])[0];
                                // echo '<img class="img" src="' . $imgURL . '" width="60px" height="60px"/>';
                                echo '<img class="img-responsive" alt="img-alt" src="' . $imgURL . '" style="width: 71px; border-radius: 50%;margin-bottom:2px">';
                                // echo '<img style="width: 71px; border-radius: 43px;margin-bottom:2px" class="img-responsive" src="' . $imgURL . '" />';
                                ?>

                    <!-- <img class="img-responsive" alt="img-alt" src="https://bootdey.com/img/Content/avatar/avatar6.png" style="width: 71px; border-radius: 43px;margin-bottom:2px"> -->
                    <h5><?php echo '' . $rpt_row['first_name'] . " " . $rpt_row['middle_name'] . " " . $rpt_row['last_name'] . ''; ?>
                    </h5>
                    <!-- <h4><?php echo '' . $rpt_row['student_index_num'] . ''; ?></h4> -->

                    <br>

                    <div class="row receipt-right">

                        <div class="col-sm-4">
                            <div class="well">
                                <!-- <strong>Phone Number</strong> -->
                                <p style="font-weight:bold">Phone Number</p>
                            </div>
                            <div class="well">
                                <p><?php echo '' . $rpt_row['guardian_ph'] . ''; ?></p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="well">
                                <p style="font-weight:bold">House</p>
                            </div>
                            <div class="well">
                                <p><?php echo '' . $rpt_row['house_name'] . ''; ?></p>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="well">
                                <p style="font-weight:bold">Form</p>
                            </div>
                            <div class="well">
                                <p><?php echo '' . $rpt_row['form_name'] . ''; ?></p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row receipt-right">

                        <div class="col-sm-4">
                            <div class="well">
                                <!-- <strong>Phone Number</strong> -->
                                <p style="font-weight:bold">Student Index</p>
                            </div>
                            <div class="well">
                                <p><?php echo '' . $rpt_row['student_index_num'] . ''; ?></p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="well">
                                <p style="font-weight:bold">Start Date</p>
                            </div>
                            <div class="well">
                                <p><?php echo '' . $rpt_row['start_date'] . ''; ?></p>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="well">
                                <p style="font-weight:bold">End Date</p>
                            </div>
                            <div class="well">
                                <p><?php echo '' . $rpt_row['end_date'] . ''; ?></p>
                            </div>
                        </div>
                    </div>




                </div><br>



                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="receipt-left">
                        <h5>EXEAT #
                            <span
                                style="color:#9f181c;font-weight:bold"><?php echo '' . $rpt_row['exeat_number'] . ''; ?></span>
                        </h5>
                    </div>
                </div>




                <!-- <div class="row">
            <div class="receipt-header">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="receipt-left">
                        <img class="img-responsive" alt="img-alt"
                            src="https://bootdey.com/img/Content/avatar/avatar6.png"
                            style="width: 71px; border-radius: 43px;">
                    </div>
                </div>
                <div class="text-right">
                    <div class="receipt-right">
                        <h5>Company Name.</h5>
                        <p>+1 3649-6589 <i class="fa fa-phone"></i></p>
                        <p>company@gmail.com <i class="fa fa-envelope-o"></i></p>
                        <p>USA <i class="fa fa-location-arrow"></i></p>
                    </div>
                </div>
            </div>
        </div> -->

                <!-- <div class="row">
            <div class="receipt-header receipt-header-mid">
                <div class="col-xs-8 col-sm-8 col-md-8 text-left">
                    <div class="receipt-right">
                        <h5>Customer Name </h5>
                        <p><b>Mobile :</b> +1 12345-4569</p>
                        <p><b>Email :</b> customer@gmail.com</p>
                        <p><b>Address :</b> New York, USA</p>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="receipt-left">
                        <h3>INVOICE # 102</h3>
                    </div>
                </div>
            </div>
        </div> -->

                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Exeat Reason</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="col-md-9"><?php echo '' . $rpt_row['reason'] . ''; ?></td>
                                <td class="col-md-3"><i
                                        class="fa fa-inr"></i><?php echo '' . $rpt_row['status'] . ''; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="receipt-left">
                        <p>.....................</p>
                        <p>Authorized By</p>
                    </div>
                </div>




                <!-- <div class="row">
            <div class="receipt-header receipt-header-mid receipt-footer">
                <div class="col-xs-8 col-sm-8 col-md-8 text-left">
                    <div class="receipt-right">
                        <p><b>Date :</b> 15 Aug 2016</p>
                        <h5 style="color: rgb(140, 140, 140);">Thanks for shopping.!</h5>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="receipt-left">
                        <h1>.............</h1>
                    </div>
                    School Stamp & Signature
                </div>
            </div>
        </div> -->

            </div>
        </div>
        <!-- </div> -->

        <?php }
    }
} ?>

        <p class="no-print">
            <input class="btn btn-primary" type='button' value='Print Report' onclick='printReport()' />
        </p>
</body>


</div>
<div class="card-footer small text-muted">

</div>
</div>
</div>
<?php include_once('../../footer.php') ?>


<script>
var myApp = new function() {
    this.printDiv = function() {
        // Store DIV contents in the variable.
        var div = document.getElementById('report-page');

        // Create a window object.
        var win = window.open('', '', 'height=700,width=700'); // Open the window. Its a popup window.
        win.document.write(div.outerHTML); // Write contents in the new window.
        win.document.close();
        win.print(); // Finally, print the contents.
    }
}


function printReport() {
    window.print();
}
</script>






<style>
body {
    background: #eee;
    margin-top: 20px;
}

.text-danger strong {
    color: #9f181c;
}

.receipt-main {
    background: #ffffff none repeat scroll 0 0;
    border-bottom: 12px solid #333333;
    border-top: 12px solid #9f181c;
    margin-top: 50px;
    margin-bottom: 50px;
    padding: 40px 30px !important;
    position: relative;
    box-shadow: 0 1px 21px #acacac;
    color: #333333;
    font-family: open sans;
}

.receipt-main p {
    color: #333333;
    font-family: open sans;
    line-height: 1.42857;
}

.receipt-footer h1 {
    font-size: 15px;
    font-weight: 400 !important;
    margin: 0 !important;
}

.receipt-main::after {
    background: #414143 none repeat scroll 0 0;
    content: "";
    height: 5px;
    left: 0;
    position: absolute;
    right: 0;
    top: -13px;
}

.receipt-main thead {
    background: #414143 none repeat scroll 0 0;
}

.receipt-main thead th {
    color: #fff;
}

.receipt-right h5 {
    font-size: 16px;
    font-weight: bold;
    margin: 0 0 7px 0;
}

.receipt-right p {
    font-size: 12px;
    margin: 0px;
}

.receipt-right p i {
    text-align: center;
    width: 18px;
}

.receipt-main td {
    padding: 9px 20px !important;
}

.receipt-main th {
    padding: 13px 20px !important;
}

.receipt-main td {
    font-size: 13px;
    font-weight: initial !important;
}

.receipt-main td p:last-child {
    margin: 0;
    padding: 0;
}

.receipt-main td h2 {
    font-size: 20px;
    font-weight: 900;
    margin: 0;
    text-transform: uppercase;
}

.receipt-header-mid .receipt-left h1 {
    font-weight: 100;
    margin: 34px 0 0;
    text-align: right;
    text-transform: uppercase;
}

.receipt-header-mid {
    margin: 24px 0;
    overflow: hidden;
}

#container {
    background-color: #dcdcdc;
}
</style>