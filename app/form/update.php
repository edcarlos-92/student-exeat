<?php $title = "Form - Update" ?>
<?php include_once('../../header.php') ?>
<?php include_once('../../menu.php'); ?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="<?php echo $baseurl; ?>app/dashboard/dashboard.php">Dashboard</a>
	</li>
	<li class="breadcrumb-item active">Form Update</li>
</ol>

<?php if (isset($_GET['action'])) { ?>
	<div class="col-lg-12">
		<?php

		switch ($_GET['action']) {
			case 'update':
				$form_name = mysqli_real_escape_string($db, $_POST['form_name']);

				$id = $_POST['form_id'];
				$query = "Update form SET form_name='" . $form_name . "' WHERE form_id='$id'";

				if ($db->query($query) === TRUE) {
					$log->info('Record updated on Form by ' . $_SESSION["user"]);
					echo "<div class='alert alert-success'>Record updated successfully <a href='index.php'>Go back to list</a></div>";
				} else {
					$log->error('Failed to update record on Form by ' . $_SESSION["user"]);
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
					Form <small>Edit</small>

				</div>
				<div class="card-body">
					<?php
					if (isset($_GET['id'])) {
						$query = "SELECT * FROM form Where  form_id= '" . $_GET['id'] . "'";
						$result = $db->query($query);

						if ($result->num_rows > 0) {
							// output data of each row

					?>
							<form role="form" method="post" action="update.php?action=update">
								<input type="hidden" value="<?php echo $_GET['id']; ?>" name="form_id" />
								<?php
								while ($row = $result->fetch_assoc()) {
									$form_name = $row['form_name'];
								}
								?>
								<div class="form-group"><label>Form Name</label><textarea class='form-control' rows='3' name='form_name'><?php echo $form_name; ?></textarea></div>

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


	<!-- Place Form Here -->



</div>
<div class="col-sm-2 sidenav">
</div>
</div>
</div>













<!-- </div> -->
<?php include_once('../../footer.php') ?>