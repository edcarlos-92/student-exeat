<?php $title = "Exeat - Update" ?>
<?php include_once('../../header.php') ?>
<?php include_once('../../menu.php'); ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?php echo $baseurl; ?>app/dashboard/dashboard.php">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Exeat Update</li>
</ol>
<?php if (isset($_GET['action'])) { ?>
<div class="col-lg-12">
    <?php

		switch ($_GET['action']) {
			case 'update':
				$student_id = mysqli_real_escape_string($db, $_POST['student_id']);
				$reason = mysqli_real_escape_string($db, $_POST['reason']);
				$start_date = mysqli_real_escape_string($db, $_POST['start_date']);
				$end_date = mysqli_real_escape_string($db, $_POST['end_date']);
				$status = mysqli_real_escape_string($db, $_POST['status']);
				$id = $_POST['exeat_id'];
				$query = "Update exeat SET student_id='" . $student_id . "',reason='" . $reason . "',start_date='" . $start_date . "',end_date='" . $end_date . "',status='" . $status . "' WHERE exeat_id='$id'";

				if ($db->query($query) === TRUE) {
					$log->info('Record updated on Exeat by ' . $_SESSION["user"]);
					echo "<div class='alert alert-success'>Record updated successfully <a href='index.php'>Go back to list</a></div>";
				} else {
					$log->error('Failed to update record on Exeat by ' . $_SESSION["user"]);
					$log->error($db->error);
					echo "<div class='alert alert-error'>Error: <br>" . $db->error . "</div>";
				}

				break;
		}
		?>
</div>
<?php } ?>







<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-2 sidenav">
        </div>
        <div class="col-sm-8 text-left">


            <!-- Place Form Here -->



            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Exeat <small>Edit</small>

                </div>
                <div class="card-body">
                    <?php
					if (isset($_GET['id'])) {
						$query = "SELECT * FROM exeat Where  exeat_id= '" . $_GET['id'] . "'";
						$result = $db->query($query);

						if ($result->num_rows > 0) {
							// output data of each row

					?>
                    <form role="form" method="post" action="update.php?action=update">
                        <input type="hidden" value="<?php echo $_GET['id']; ?>" name="exeat_id" />
                        <?php
								while ($row = $result->fetch_assoc()) {
									$student_id = $row['student_id'];
									$reason = $row['reason'];
									$start_date = $row['start_date'];
									$end_date = $row['end_date'];
									$status = $row['status'];
								}
								?>
                        <label>student_id</label>
                        <div class="form-group"><Select class='form-control' name='student_id'><?php
																										$query2 = 'Select * from  student';
																										$result2 = $db->query($query2);
																										if ($result2->num_rows > 0) {
																											while ($row2 = $result2->fetch_assoc()) { ?>
                                <option value='<?php echo $row2["student_id"]; ?>' <?php if ($student_id == $row2["student_id"]) {
																													echo "selected";
																												}; ?>> <?php echo $row2["first_name"]; ?></option>
                                <?php  }
																										} ?>
                            </Select></div>
                        <div class="form-group"><label>reason</label><textarea class='form-control' rows='3'
                                name='reason'><?php echo $reason; ?></textarea></div>
                        <div class="form-group"><label>Start Date</label> <input class='form-control datepicker'
                                value='<?php echo $start_date; ?>' placeholder='' name='start_date' type='text' required
                                autocomplete="off"></div>
                        <div class="form-group"><label>End Date</label> <input class='form-control datepicker'
                                value='<?php echo $end_date; ?>' placeholder='' name='end_date' type='text' required
                                autocomplete="off">
                        </div>

                        <div class="form-group"><label>status</label>
                            <!-- <textarea class='form-control'  rows='3'  name='status' ><?php echo $status; ?>
</textarea> -->

                            <Select class='form-control' name='status'>
                                <option selected value='<?php echo $status; ?>'><?php echo $status; ?></option>
                                <option value='On Exeat'>On Exeat</option>
                                <option value='Reported'>Reported</option>
                                <option value='Expired'>Expired</option>
                            </Select>
                        </div>

                        <?php if ($per == "sa" || $per == "a") { ?>
                        <button type="submit" class="btn btn-primary">Update Record</button>
                        <?php } else { ?>
                        <a href="#" class="btn btn-primary">You do not have permission to update record.</a>
                        <?php } ?>

                    </form>
                    <?php
						}
					}

					?>



                </div>
            </div>


            <!-- Place Form Here -->



        </div>
        <div class="col-sm-2 sidenav">
        </div>
    </div>
</div>





<!-- </div> -->
<div class="card-footer small text-muted">

</div>
</div>
</div>
<?php include_once('../../footer.php') ?>