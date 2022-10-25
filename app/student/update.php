<?php $title = "Student - Update" ?>
<?php include_once('../../header.php') ?>
<?php include_once('../../menu.php'); ?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="<?php echo $baseurl; ?>app/dashboard/dashboard.php">Dashboard</a>
	</li>
	<li class="breadcrumb-item active">Student Update</li>
</ol>




<div class="container-fluid text-center">
	<div class="row content">
		<div class="col-sm-2 sidenav">
		</div>
		<div class="col-sm-8 text-left">


			<!-- Place Form Here -->


			<?php if (isset($_GET['action'])) { ?>
				<div class="col-lg-12">
					<?php

					switch ($_GET['action']) {
						case 'update':
							$first_name = mysqli_real_escape_string($db, $_POST['first_name']);
							$middle_name = mysqli_real_escape_string($db, $_POST['middle_name']);
							$last_name = mysqli_real_escape_string($db, $_POST['last_name']);
							$guardian_name = mysqli_real_escape_string($db, $_POST['guardian_name']);
							$guardian_ph = mysqli_real_escape_string($db, $_POST['guardian_ph']);
							$house_id = mysqli_real_escape_string($db, $_POST['house_id']);
							$form_id = mysqli_real_escape_string($db, $_POST['form_id']);
							$photo_id = mysqli_real_escape_string($db, $_POST['photo_id']);

							$id = $_POST['student_id'];
							$query = "Update student SET first_name='" . $first_name . "',middle_name='" . $middle_name . "',last_name='" . $last_name . "',guardian_name='" . $guardian_name . "',guardian_ph='" . $guardian_ph . "',house_id='" . $house_id . "',form_id='" . $form_id . "',photo_id='" . $photo_id . "' WHERE student_id='$id'";

							if ($db->query($query) === TRUE) {
								$log->info('Record updated on Student by ' . $_SESSION["user"]);
								echo "<div class='alert alert-success'>Record updated successfully <a href='index.php'>Go back to list</a></div>";
							} else {
								$log->error('Failed to update record on Student by ' . $_SESSION["user"]);
								$log->error($db->error);
								echo "<div class='alert alert-error'>Error: <br>" . $db->error . "</div>";
							}

							break;
					}
					?>
				</div>
			<?php } ?>
			<div class="card mb-3">
				<div class="card-header">
					<i class="fas fa-table"></i>
					Student <small>Edit</small>

				</div>
				<div class="card-body">
					<?php
					if (isset($_GET['id'])) {
						$query = "SELECT * FROM student Where  student_id= '" . $_GET['id'] . "'";
						$result = $db->query($query);

						if ($result->num_rows > 0) {
							// output data of each row

					?>
							<form role="form" method="post" action="update.php?action=update">
								<input type="hidden" value="<?php echo $_GET['id']; ?>" name="student_id" />
								<?php
								while ($row = $result->fetch_assoc()) {
									$student_index_num = $row['student_index_num'];
									$first_name = $row['first_name'];
									$middle_name = $row['middle_name'];
									$last_name = $row['last_name'];
									$guardian_name = $row['guardian_name'];
									$guardian_ph = $row['guardian_ph'];
									$house_id = $row['house_id'];
									$form_id = $row['form_id'];
									$photo_id = $row['photo_id'];
								}
								?>


								<div class="form-group"><label>Index Number</label> <input class='form-control' maxlength='50' placeholder='Index Number' name='student_index_num' type='text' value='<?php echo $student_index_num; ?>'></div>



								<div class="form-group"><label>First Name</label> <input class='form-control' maxlength='50' name='first_name' type='text' value='<?php echo $first_name; ?>'></div>
								<div class="form-group"><label>Middle Name</label> <input class='form-control' maxlength='50' name='middle_name' type='text' value='<?php echo $middle_name; ?>'></div>
								<div class="form-group"><label>Last Name</label> <input class='form-control' maxlength='50' name='last_name' type='text' value='<?php echo $last_name; ?>'></div>
								<div class="form-group"><label>Guardian Name</label> <input class='form-control' maxlength='50' name='guardian_name' type='text' value='<?php echo $guardian_name; ?>'></div>
								<div class="form-group"><label>Guardian Contact Number</label> <input class='form-control' maxlength='50' name='guardian_ph' type='text' value='<?php echo $guardian_ph; ?>'></div>

								<!-- <div class="form-group"><label>first_name</label><textarea class='form-control' rows='3'
                                name='first_name'><?php echo $first_name; ?></textarea></div>
                        <div class="form-group"><label>middle_name</label><textarea class='form-control' rows='3'
                                name='middle_name'><?php echo $middle_name; ?></textarea></div>
                        <div class="form-group"><label>last_name</label><textarea class='form-control' rows='3'
                                name='last_name'><?php echo $last_name; ?></textarea></div>
                        <div class="form-group"><label>guardian_name</label><textarea class='form-control' rows='3'
                                name='guardian_name'><?php echo $guardian_name; ?></textarea></div>
                        <div class="form-group"><label>guardian_ph</label><textarea class='form-control' rows='3'
                                name='guardian_ph'><?php echo $guardian_ph; ?></textarea></div> -->


								<label>Student House</label>
								<div class="form-group"><Select class='form-control' name='house_id'><?php
																										$query2 = 'Select * from  house';
																										$result2 = $db->query($query2);
																										if ($result2->num_rows > 0) {
																											while ($row2 = $result2->fetch_assoc()) { ?>
												<option value='<?php echo $row2["house_id"]; ?>' <?php if ($house_id == $row2["house_id"]) {
																													echo "selected";
																												}; ?>> <?php echo $row2["house_name"]; ?></option>
										<?php  }
																										} ?>
									</Select></div>
								<label>Student Form</label>
								<div class="form-group"><Select class='form-control' name='form_id'><?php
																									$query2 = 'Select * from  form';
																									$result2 = $db->query($query2);
																									if ($result2->num_rows > 0) {
																										while ($row2 = $result2->fetch_assoc()) { ?>
												<option value='<?php echo $row2["form_id"]; ?>' <?php if ($form_id == $row2["form_id"]) {
																												echo "selected";
																											}; ?>> <?php echo $row2["form_name"]; ?></option>
										<?php  }
																									} ?>
									</Select></div>
								<div class="form-group"><label>Student Photo</label>
									<div id='photo_id_List' class='row mx-0 no-gutters'><?php if ($photo_id) {
																							$imgArray = explode(",", $photo_id);
																							foreach ($imgArray as $r) {
																								$r = trim($r); ?><div class='col-xs-2 col-md-1 px-0' id='<?php echo $r; ?>'>
													<div class='artist-collection-photo'>
														<div><button onClick="removeImage('photo_id','<?php echo $r; ?>');" class='close' type='button'>×</button></div><a href="<?php echo $baseurl; ?>app/media_upload/upload/<?php echo $r; ?>" target='_blank'><img src="<?php echo $baseurl; ?>app/media_upload/upload/<?php echo $r; ?>" class='img-thumbnail' style='width:100px;height:100px' /></a>
													</div>
												</div><?php }
																						} ?></div><input type='hidden' name='photo_id' id='photo_id' value="<?php echo $photo_id; ?>" />
									<input type='file' id='photo_idFile' name='photo_idFile' multiple='multiple' /> <input type='button' class='button' value='Upload' id='photo_idUploadBtn' onclick="imageUpload('photo_id')">
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
			<div class="card-footer small text-muted">

			</div>
		</div>

	</div>
</div>


<!-- Place Form Here -->



</div>
<div class="col-sm-2 sidenav">
</div>
</div>
</div>












<?php include_once('../../footer.php') ?>