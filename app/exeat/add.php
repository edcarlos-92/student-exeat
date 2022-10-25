<?php $title = "Exeat - Add" ?>
<?php include_once('../../header.php') ?>
<?php include_once('../../menu.php'); ?>

<?php

// $hash='';
// $sender_id='';
// $username = '';
// $hash = '';


function sendSms($numbers, $message)
{
    $json = file_get_contents('credentials');
    $obj = json_decode($json);
    $sender = urlencode('EXEATMS');
    $message = rawurlencode($message);
    $type = 0;
    $dlr = 0;
    $data = "" . $obj->access_token . "" . $obj->token_validate . "&type=" . $type . "&dlr=" . $dlr . "&destination=" . $numbers . "&source=" . $sender . "&message=" . $message;
    $ch = curl_init('bulk_sms_url_here');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $response = explode('|', $result);
    // echo $response[0];
    if ($response[0] == 1701) {
        echo "<div class='alert alert-success'>SMS Sent successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Could not send SMS, Check and Try again later.</div>";
    }
}

?>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?php echo $baseurl; ?>app/dashboard/dashboard.php">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Exeat Add New</li>
</ol>
<div class="card mb-3">
    <?php if (isset($_GET['action'])) { ?>
    <div class="col-lg-12">
        <?php

            switch ($_GET['action']) {
                case 'add':
                    $student_id = $_POST['student_id'];
                    $reason = $_POST['reason'];
                    $start_date = $_POST['start_date'];
                    $end_date = $_POST['end_date'];
                    $status = $_POST['status'];
                    $exeat_number = $_POST['exeat_number'];


                    $query = "INSERT INTO exeat (student_id,exeat_number,reason,start_date,end_date,status) Values ( '" . $student_id .  "','" . $exeat_number . "','" . $reason . "','" . $start_date . "','" . $end_date . "','" . $status . "');";

                    if ($db->query($query) === TRUE) {

                        // Send SMS to Parent or Guardians Here
                        // $query = "delete from form where form_id = '$id'";
                        $student_info_query = "Select * from  student where student_id = '$student_id'";
                        $student_info_result = $db->query($student_info_query);
                        if ($student_info_result->num_rows > 0) {
                            while ($std_row = $student_info_result->fetch_assoc()) {
                                //Send message now
                                // echo $std_row['first_name'];
                                $std_full_names = $std_row['first_name'] . " " . $std_row['middle_name'] . " " . $std_row['last_name'];
                                $numbers = $std_row['guardian_ph'];
                                $message = "Dear Guardian, Exeat has been granted " . $std_full_names . " Reason: " . $reason . ". Exeat expires " . $end_date . " Thank You.";
                                sendSms($numbers, $message);
                            }
                        }
                        // Send SMS to Parent or Guardians Here
                        $log->info('A new record create on Exeat by ' . $_SESSION["user"]);
                        echo "<div class='alert alert-success'>New record created successfully <a href='index.php'>Go back to list</a></div>";
                    } else {
                        $log->error('Error in creating new record on Exeat by ' . $_SESSION["user"]);
                        $log->error($db->error);
                        echo "<div class='alert alert-error'>Error: <br>" . $db->error . " <a href='index.php'>Go back to list</a></div>";
                    }

                    break;
            }
            ?>
    </div> <?php } ?>


    <div class="container-fluid text-center">
        <div class="row content">
            <div class="col-sm-2 sidenav">
            </div>
            <div class="col-sm-8 text-left">

                <div class="card-header">
                    Exeat <small>ID</small>
                    <h4 id="exeat_numb" name="exeat_numb"></h4>

                </div>
                <div class="card-body">
                    <form role="form" method="post" action="add.php?action=add">

                        <input hidden name="exeat_number" id="exeat_number" type="text" required="required" />

                        <label>Student Information</label>

                        <div class="form-group"><Select class='form-control' name='student_id'><?php
                                                                                                $query2 = 'Select * from  student';
                                                                                                $result2 = $db->query($query2);
                                                                                                if ($result2->num_rows > 0) {
                                                                                                    while ($row2 = $result2->fetch_assoc()) {
                                                                                                ?>
                                <option value='<?php echo $row2["student_id"]; ?>'>
                                    <?php echo $row2["first_name"] . " " . $row2["middle_name"] . " " . $row2["last_name"] . " ( " . $row2["student_id"] . " )"; ?>
                                </option>
                                <?php  }
                                                                                                } ?>
                            </Select></div>
                        <div class="form-group"><label>Exeat Reason</label><textarea class='form-control' rows='3'
                                name='reason' required></textarea></div>
                        <div class="form-group"><label>Start Date</label> <input class='form-control datepicker'
                                placeholder='' name='start_date' type='text' value='' required autocomplete="off"></div>
                        <div class="form-group"><label>End Date</label> <input class='form-control datepicker'
                                placeholder='' name='end_date' type='text' value='' required autocomplete="off"></div>
                        <div class="form-group"><label>Status</label>

                            <!-- <textarea class='form-control' rows='3' name='status'
                    required>
			</textarea> -->
                            <Select class='form-control' name='status'>
                                <option value='On Exeat'>On Exeat</option>
                                <option value='Reported'>Reported</option>
                                <option value='Expired'>Expired</option>
                            </Select>


                        </div>
                        <hr>
                        <?php if ($per == "sa" || $per == "a") { ?>
                        <button type="submit" class="btn btn-primary">Save Record</button>
                        <button type="reset" class="btn btn-secondary">Clear Entry</button>
                        <?php } else { ?>
                        <a href="#" class="btn btn-primary">You do not have permission to add record.</a>
                        <?php } ?>

                    </form>
                </div>

            </div>
            <div class="col-sm-2 sidenav">
            </div>
        </div>
    </div>









    <div class="card-footer small text-muted">

    </div>
</div>
<?php include_once('../../footer.php') ?>


<script>
$("document").ready(function() {

    function makeid(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
    var gen_gud_uname = makeid(5);



    function getExeatID() {
        let now_date = new Date();
        let theYear = now_date.getFullYear();
        let theMonth = now_date.getMonth() < 12 ? now_date.getMonth() + 1 : 1 //now_date.getMonth();
        let theDate = now_date.getDate();
        let theHour = now_date.getHours();
        let theMinute = now_date.getMinutes();
        let theSec = now_date.getSeconds();
        let theMillSec = now_date.getMilliseconds();
        // return now_date
        return theYear + "" + theMonth + "" + theDate + "" + theHour + "" + theMinute + "" + theSec;
    }


    // document.getElementById("exeat_numb").value = gen_gud_uname;

    // document.getElementById("exeat_numb").innerText = gen_gud_uname;
    // document.getElementById("exeat_numb").innerHTML = gen_gud_uname;
    // alert(gen_gud_uname);

    let getID = getExeatID();
    document.getElementById("exeat_numb").innerText = getID;
    $('#exeat_number', this).val("").val(getID);
    // document.getElementById("exeat_numb").value = getID;
});
</script>