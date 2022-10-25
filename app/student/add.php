<?php $title = "Student - Add" ?>
<?php include_once('../../header.php') ?>
<?php include_once('../../menu.php'); ?>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="<?php echo $baseurl; ?>app/dashboard/dashboard.php">Dashboard</a>
	</li>
	<li class="breadcrumb-item active">Student Add New</li>
</ol>





<div class="container-fluid text-center">
	<div class="row content">
		<div class="col-sm-2 sidenav">
		</div>
		<div class="col-sm-8 text-left">


			<!-- Place Form Here -->


			<div class="card mb-3">
				<?php if (isset($_GET['action'])) { ?>
					<div class="col-lg-12">
						<?php

						switch ($_GET['action']) {
							case 'add':

								$student_index_num = $_POST['student_index_num'];
								$first_name = $_POST['first_name'];

								$middle_name = $_POST['middle_name'];
								$last_name = $_POST['last_name'];
								$guardian_name = $_POST['guardian_name'];
								$guardian_ph = $_POST['guardian_ph'];
								$house_id = $_POST['house_id'];
								$form_id = $_POST['form_id'];
								$photo_id = $_POST['photo_id'];


								$query = "INSERT INTO student (student_index_num,first_name,middle_name,last_name,guardian_name,guardian_ph,house_id,form_id,photo_id) Values ('" . $student_index_num . "','" . $first_name . "','" . $middle_name . "','" . $last_name . "','" . $guardian_name . "','" . $guardian_ph . "','" . $house_id . "','" . $form_id . "','" . $photo_id . "');";

								if ($db->query($query) === TRUE) {
									$log->info('A new record create on Student by ' . $_SESSION["user"]);
									echo "<div class='alert alert-success'>New record created successfully <a href='index.php'>Go back to list</a></div>";
								} else {
									$log->error('Error in creating new record on Student by ' . $_SESSION["user"]);
									$log->error($db->error);
									echo "<div class='alert alert-error'>Error: <br>" . $db->error . " <a href='index.php'>Go back to list</a></div>";
								}

								break;
						}
						?>
					</div> <?php } ?>
				<div class="card-header">
					Student <small>Create</small>
				</div>
				<div class="card-body">
					<form role="form" method="post" action="add.php?action=add">
						<!-- student_index_num -->
						<div class="form-group"><label>Index Number</label> <input class='form-control' maxlength='50' placeholder='Index Number' name='student_index_num' type='text' value=''></div>


						<div class="form-group"><label>First Name</label> <input class='form-control' maxlength='50' name='first_name' type='text' value=''></div>
						<div class="form-group"><label>Middle Name</label> <input class='form-control' maxlength='50' name='middle_name' type='text' value=''></div>
						<div class="form-group"><label>Last Name</label> <input class='form-control' maxlength='50' name='last_name' type='text' value=''></div>
						<div class="form-group"><label>Guardian Name</label> <input class='form-control' maxlength='50' name='guardian_name' type='text' value=''></div>
						<div class="form-group"><label>Guardian Contact Number</label> <input class='form-control' maxlength='50' name='guardian_ph' type='text' value=''></div>


						<!-- <div class="form-group"><label>first_name</label><textarea class='form-control' rows='3'
                                name='first_name' required></textarea></div>
                        <div class="form-group"><label>middle_name</label><textarea class='form-control' rows='3'
                                name='middle_name' required></textarea></div>
                        <div class="form-group"><label>last_name</label><textarea class='form-control' rows='3'
                                name='last_name' required></textarea></div>
                        <div class="form-group"><label>guardian_name</label><textarea class='form-control' rows='3'
                                name='guardian_name' required></textarea></div>
                        <div class="form-group"><label>guardian_ph</label><textarea class='form-control' rows='3'
                                name='guardian_ph' required></textarea></div> -->




						<label>Student House</label>
						<div class="form-group"><Select class='form-control' name='house_id'><?php
																								$query2 = 'Select * from  house';
																								$result2 = $db->query($query2);
																								if ($result2->num_rows > 0) {
																									while ($row2 = $result2->fetch_assoc()) { ?>
										<option value='<?php echo $row2["house_id"]; ?>'> <?php echo $row2["house_name"]; ?>
										</option>
								<?php  }
																								} ?>
							</Select></div>
						<label>Student Form</label>
						<div class="form-group"><Select class='form-control' name='form_id'><?php
																							$query2 = 'Select * from  form';
																							$result2 = $db->query($query2);
																							if ($result2->num_rows > 0) {
																								while ($row2 = $result2->fetch_assoc()) { ?>
										<option value='<?php echo $row2["form_id"]; ?>'> <?php echo $row2["form_name"]; ?>
										</option>
								<?php  }
																							} ?>
							</Select></div>
						<div class="form-group"><label>Student Photo</label>
							<div id='photo_id_List' class='row mx-0 no-gutters'></div><input type='hidden' name='photo_id' id='photo_id' /> <input type='file' id='photo_idFile' name='photo_idFile' multiple='multiple' /> <input type='button' class='button' value='Upload' id='photo_idUploadBtn' onclick="imageUpload('photo_id')">
						</div>

						<?php if ($per == "sa" || $per == "a") { ?>
							<button type="submit" class="btn btn-primary">Save Record</button>
							<button type="reset" class="btn btn-secondary">Clear Entry</button>
						<?php } else { ?>
							<a href="#" class="btn btn-primary">You do not have permission to add record.</a>
						<?php } ?>

					</form>
				</div>
				<div class="card-footer small text-muted">

				</div>
			</div>

			<!-- Place Form Here -->



		</div>
		<div class="col-sm-2 sidenav">
		</div>
	</div>
</div>














<?php include_once('../../footer.php') ?>