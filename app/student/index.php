<?php $title = "Student" ?>
<?php include_once('../../header.php') ?>
<?php include_once('../../menu.php'); ?>
<?php
if (isset($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
} else {
	$pageno = 1;
}
$no_of_records_per_page = 30;
$offset = ($pageno - 1) * $no_of_records_per_page;

if (isset($_GET['search'])) {
	$searchKey = strtolower($_GET['search']);
	$total_pages_sql = 'SELECT COUNT(*) FROM student t  WHERE Lower(t.first_name) LIKE "%' . $searchKey . '%" OR Lower(t.middle_name) LIKE "%' . $searchKey . '%" OR Lower(t.last_name) LIKE "%' . $searchKey . '%" OR Lower(t.guardian_name) LIKE "%' . $searchKey . '%" OR Lower(t.guardian_ph) LIKE "%' . $searchKey . '%" OR Lower(t.photo_id) LIKE "%' . $searchKey . '%"';
} else {
	$total_pages_sql = "SELECT COUNT(*) FROM student";
}

$resultPage = mysqli_query($db, $total_pages_sql);
$total_rows = mysqli_fetch_array($resultPage)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);
?>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?php echo $baseurl; ?>app/dashboard/dashboard.php">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Student View</li>
</ol>
<?php
if (isset($_POST['btnDeleteSelected']) && isset($_POST['checkbox'])) {
	$ids = implode(', ', $_POST['checkbox']);
	$query = "delete from student where student_id IN ($ids)";
	if ($db->query($query) === TRUE) {
		$log->info('Delete Selected student ' . $ids . ' by ' . $_SESSION["user"]);
		echo "<div class='card mb-3'><div class='alert alert-success'>Selected records deleted successfully</div></div>";
	} else {
		$log->error('Error in deleting selected student ' . $ids . ' by ' . $_SESSION["user"]);
		$log->error($db->error);
		echo "<div class='card mb-3'><div class='alert alert-error'>Error: <br>" . $db->error . "</div></div>";
	}
} else if (isset($_POST['btnDeleteAll'])) {
	$query = "delete from student";
	if ($db->query($query) === TRUE) {
		$log->info('Delete all student by ' . $_SESSION["user"]);
		echo "<div class='card mb-3'><div class='alert alert-success'>All records deleted successfully</div></div>";
	} else {
		$log->error('Error in deleting all student by ' . $_SESSION["user"]);
		$log->error($db->error);
		echo "<div class='card mb-3'><div class='alert alert-error'>Error: <br>" . $db->error . "</div></div>";
	}
}

?>
<?php if (isset($_GET['action'])) { ?>
<div class="col-lg-12">
    <?php


		switch ($_GET['action']) {
			case 'delete':
				if ($per == "sa") {
					$id = $_GET['id'];
					$query = "delete from student where student_id = '$id'";

					if ($db->query($query) === TRUE) {
						$log->info('Record ID ' . $id . ' deleted on Student by ' . $_SESSION["user"]);
						echo "<div class='card mb-3'><div class='alert alert-success'>Record deleted successfully</div></div>";
					} else {
						$log->error('Error in deleting record Student by ' . $_SESSION["user"]);
						$log->error($db->error);
						echo "<div class='card mb-3'><div class='alert alert-error'>Error: <br>" . $db->error . "</div></div>";
					}
				} else {
					echo "<a href='#' class='btn btn-primary'>You do not have permission to delete record.</a>";
				}

				break;
		}
		?>
</div>
<?php } ?>

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-md-4">
                <i class="fas fa-table"></i>
                Student <small>View</small>

                <?php
				if (isset($_GET['search'])) {
					echo "Search Key : " . $_GET['search'];
				?>
                <a href="index.php" type="button" class="btn btn-xs btn-danger">Reset Search</a>
                <?php
				}
				?>
            </div>
            <div class="col-md-5">
                <form method="GET" action="index.php">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="search" required>

                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>


                        <!-- <span class="input-group-btn">
                            <button class="btn btn-success" type="submit">Search!</button>
                        </span> -->
                    </div>
                </form>

                <!-- <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" method="post"
            action="<?php echo $baseurl ?>app/dashboard/search.php">
            <div class="input-group">
        <input type="text" name="searchkey" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
        </form> -->






            </div>
            <!-- <div class="col-md-3" id="tableButtons">
				<a href="export.php" target="_blank" class="btn btn-dark"><i class="fas fa-fw fa-file-export"></i> Export to Excel</a>
				<a href="import.php" class="btn btn-warning"><i class="fas fa-fw fa-file-import"></i> Bulk Import</a>
			</div> -->
        </div>
    </div>
    <div class="card-body">
        <form id="StudentForm" method="POST">
            <div class="align-right mb-2">
                <?php if ($per == 'sa' || $per == 'a') { ?>
                <a href="add.php" type="button" class="btn btn-xs btn-info">Add New</a>
                <?php } ?>
                <?php if ($per == 'sa') { ?>
                <button class="btn btn-danger" type="submit" name="btnDeleteSelected"
                    onclick='return confirm("DELETING SELECTED RECORDS! Are you sure?")'>Delete Selected</button>
                <button class="btn btn-danger" type="submit" name="btnDeleteAll"
                    onclick='return confirm("DELETING ALL RECORDS! Are you sure?")'>Delete All</button>

                <a href="export.php" target="_blank" class="btn btn-dark"><i class="fas fa-fw fa-file-export"></i>
                    Export to Excel</a>
                <a href="import.php" class="btn btn-warning"><i class="fas fa-fw fa-file-import"></i> Bulk Import</a>



                <?php } ?>
            </div>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width:20px"><input class="checkAll" type="checkbox" /></th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Guardian Name</th>
                        <th>Guardian Ph</th>
                        <th>Photo Id</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					if (isset($_GET['search'])) {
						$searchKey = strtolower($_GET['search']);
						$query = 'SELECT  t.* FROM student t  WHERE Lower(t.first_name) LIKE "%' . $searchKey . '%" OR Lower(t.middle_name) LIKE "%' . $searchKey . '%" OR Lower(t.last_name) LIKE "%' . $searchKey . '%" OR Lower(t.guardian_name) LIKE "%' . $searchKey . '%" OR Lower(t.guardian_ph) LIKE "%' . $searchKey . '%" OR Lower(t.photo_id) LIKE "%' . $searchKey . '%" LIMIT ' . $offset . ' , ' . $no_of_records_per_page . '';
					} else {
						$query = 'SELECT  t.* FROM student t  LIMIT ' . $offset . ' , ' . $no_of_records_per_page . '';
					}

					$result = $db->query($query);

					if ($result && $result->num_rows > 0) {
						// output data of each row
						while ($row = $result->fetch_assoc()) {
							echo '<tr>';
							// echo '<td style="width:20px"><input class="checkRow" name="checkbox[]" type="checkbox" value="' . $row['student_id'] . '" /> &nbsp;' . $row['student_id'] . '</td>';
							echo '<td style="width:20px"><input class="checkRow" name="checkbox[]" type="checkbox" value="' . $row['student_id'] . '" /></td>';
							echo '<td>' . $row['first_name'] . '</td>';
							echo '<td>' . $row['middle_name'] . '</td>';
							echo '<td>' . $row['last_name'] . '</td>';
							echo '<td>' . $row['guardian_name'] . '</td>';
							echo '<td>' . $row['guardian_ph'] . '</td>';
							echo '<td>';
							if (!empty($row['photo_id'])) {
								$imgURL = $baseurl . "app/media_upload/upload/" . explode(',', $row['photo_id'])[0];
								echo '<img class="img" src="' . $imgURL . '" width="60px" height="60px"/>';
							}
							echo '</td>';
							if (isset($_GET['search'])) {
								$searchKey = $_GET['search'];
								echo '<td>';
								if ($per == 'sa' || $per == 'a') {
									echo ' <a  type="button" class="btn btn-xs btn-warning" href="update.php?id=' . $row['student_id'] . '"> EDIT </a> </td><td>';
								}
								if ($per == 'sa') {
									echo ' <a  type="button" class="btn btn-xs btn-danger" href="index.php?search=' . $searchKey . '&action=delete&id=' . $row['student_id'] . '" onclick=\'return confirm("DELETING RECORD! Are you sure?")\'>DELETE </a>';
								}
								echo '</td></tr>';
							} else {
								echo '<td>';
								if ($per == 'sa' || $per == 'a') {
									echo ' <a  type="button" class="btn btn-xs btn-warning" href="update.php?id=' . $row['student_id'] . '"> EDIT </a> </td><td>';
								}
								if ($per == 'sa') {
									echo ' <a  type="button" class="btn btn-xs btn-danger" href="index.php?action=delete&id=' . $row['student_id'] . '" onclick=\'return confirm("DELETING RECORD! Are you sure?")\'>DELETE </a>';
								}
								echo '</td></tr>';
							}
						}
					} else {
						echo "0 results";
					}

					?>

                </tbody>
            </table>
        </form>
    </div>
    <div class="card-footer small text-muted">
        <?php if (isset($_GET['search'])) {
			$searchKey = $_GET['search']; ?>
        <ul class="pagination">
            <li class="page-item"><a class="page-link " href="?search=<?php echo $searchKey; ?>&pageno=1">First</a></li>
            <li class="page-item <?php if ($pageno <= 1) {
											echo 'disabled';
										} ?>"><a class="page-link " href="?search=<?php echo $searchKey; ?>&<?php if ($pageno <= 1) {
																												echo '';
																											} else {
																												echo "pageno=" . ($pageno - 1);
																											} ?>">Previous</a></li>

            <li class="page-item <?php if ($pageno >= $total_pages) {
											echo 'disabled';
										} ?>"><a class="page-link" href="?search=<?php echo $searchKey; ?>&<?php if ($pageno >= $total_pages) {
																												echo '';
																											} else {
																												echo "?pageno=" . ($pageno + 1);
																											} ?>">Next</a></li>
            <li class="page-item"><a class="page-link "
                    href="?search=<?php echo $searchKey; ?>&pageno=<?php echo $total_pages; ?>">Last</a></li>
        </ul>
        <?php } else { ?>
        <ul class="pagination">
            <li class="page-item"><a class="page-link " href="?pageno=1">First</a></li>
            <li class="page-item <?php if ($pageno <= 1) {
											echo 'disabled';
										} ?>"><a class="page-link " href="<?php if ($pageno <= 1) {
																				echo '#';
																			} else {
																				echo "?pageno=" . ($pageno - 1);
																			} ?>">Previous</a></li>

            <li class="page-item <?php if ($pageno >= $total_pages) {
											echo 'disabled';
										} ?>"><a class="page-link" href="<?php if ($pageno >= $total_pages) {
																				echo '#';
																			} else {
																				echo "?pageno=" . ($pageno + 1);
																			} ?>">Next</a></li>
            <li class="page-item"><a class="page-link " href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
        </ul>
        <?php } ?>
    </div>
</div>
</div>

<?php include_once('../../footer.php') ?>