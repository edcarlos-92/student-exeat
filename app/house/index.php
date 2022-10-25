<?php $title = "House" ?>
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
	$total_pages_sql = 'SELECT COUNT(*) FROM house t  WHERE Lower(t.house_name) LIKE "%' . $searchKey . '%"';
} else {
	$total_pages_sql = "SELECT COUNT(*) FROM house";
}

$resultPage = mysqli_query($db, $total_pages_sql);
$total_rows = mysqli_fetch_array($resultPage)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);
?>

<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="<?php echo $baseurl; ?>app/dashboard/dashboard.php">Dashboard</a>
	</li>
	<li class="breadcrumb-item active">House View</li>
</ol>
<?php
if (isset($_POST['btnDeleteSelected']) && isset($_POST['checkbox'])) {
	$ids = implode(', ', $_POST['checkbox']);
	$query = "delete from house where house_id IN ($ids)";
	if ($db->query($query) === TRUE) {
		$log->info('Delete Selected house ' . $ids . ' by ' . $_SESSION["user"]);
		echo "<div class='card mb-3'><div class='alert alert-success'>Selected records deleted successfully</div></div>";
	} else {
		$log->error('Error in deleting selected house ' . $ids . ' by ' . $_SESSION["user"]);
		$log->error($db->error);
		echo "<div class='card mb-3'><div class='alert alert-error'>Error: <br>" . $db->error . "</div></div>";
	}
} else if (isset($_POST['btnDeleteAll'])) {
	$query = "delete from house";
	if ($db->query($query) === TRUE) {
		$log->info('Delete all house by ' . $_SESSION["user"]);
		echo "<div class='card mb-3'><div class='alert alert-success'>All records deleted successfully</div></div>";
	} else {
		$log->error('Error in deleting all house by ' . $_SESSION["user"]);
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
					$query = "delete from house where house_id = '$id'";

					if ($db->query($query) === TRUE) {
						$log->info('Record ID ' . $id . ' deleted on House by ' . $_SESSION["user"]);
						echo "<div class='card mb-3'><div class='alert alert-success'>Record deleted successfully</div></div>";
					} else {
						$log->error('Error in deleting record House by ' . $_SESSION["user"]);
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
				House <small>View</small>

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
						<!-- <span class="input-group-btn">
                            <button class="btn btn-success" type="submit">Search!</button>
                        </span> -->
						<div class="input-group-append">
							<button class="btn btn-primary" type="submit">
								<i class="fas fa-search"></i>
							</button>
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>
	<div class="card-body">
		<form id="HouseForm" method="POST">
			<div class="align-right mb-2">
				<?php if ($per == 'sa' || $per == 'a') { ?>
					<a href="add.php" type="button" class="btn btn-xs btn-info">Add New</a>
				<?php } ?>
				<?php if ($per == 'sa') { ?>
					<button class="btn btn-danger" type="submit" name="btnDeleteSelected" onclick='return confirm("DELETING SELECTED RECORDS! Are you sure?")'>Delete Selected</button>
					<button class="btn btn-danger" type="submit" name="btnDeleteAll" onclick='return confirm("DELETING ALL RECORDS! Are you sure?")'>Delete All</button>

					<!-- <div class="col-md-3" id="tableButtons"> -->
					<a href="export.php" target="_blank" class="btn btn-dark"><i class="fas fa-fw fa-file-export"></i>
						Export to Excel</a>
					<a href="import.php" class="btn btn-warning"><i class="fas fa-fw fa-file-import"></i> Bulk
						Import</a>
					<!-- </div> -->

				<?php } ?>
			</div>
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th style="width:20px"><input class="checkAll" type="checkbox" /></th>
						<th>House Name</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if (isset($_GET['search'])) {
						$searchKey = strtolower($_GET['search']);
						$query = 'SELECT  t.* FROM house t  WHERE Lower(t.house_name) LIKE "%' . $searchKey . '%" LIMIT ' . $offset . ' , ' . $no_of_records_per_page . '';
					} else {
						$query = 'SELECT  t.* FROM house t  LIMIT ' . $offset . ' , ' . $no_of_records_per_page . '';
					}

					$result = $db->query($query);

					if ($result && $result->num_rows > 0) {
						// output data of each row
						while ($row = $result->fetch_assoc()) {
							echo '<tr>';
							// echo '<td style="width:20px"><input class="checkRow" name="checkbox[]" type="checkbox" value="' . $row['house_id'] . '" /> &nbsp;' . $row['house_id'] . '</td>';
							echo '<td style="width:20px"><input class="checkRow" name="checkbox[]" type="checkbox" value="' . $row['house_id'] . '" /></td>';
							echo '<td>' . $row['house_name'] . '</td>';
							if (isset($_GET['search'])) {
								$searchKey = $_GET['search'];
								echo '<td>';
								if ($per == 'sa' || $per == 'a') {
									echo ' <a  type="button" class="btn btn-xs btn-warning" href="update.php?id=' . $row['house_id'] . '"> EDIT </a> </td><td>';
								}
								if ($per == 'sa') {
									echo ' <a  type="button" class="btn btn-xs btn-danger" href="index.php?search=' . $searchKey . '&action=delete&id=' . $row['house_id'] . '" onclick=\'return confirm("DELETING RECORD! Are you sure?")\'>DELETE </a>';
								}
								echo '</td></tr>';
							} else {
								echo '<td>';
								if ($per == 'sa' || $per == 'a') {
									echo ' <a  type="button" class="btn btn-xs btn-warning" href="update.php?id=' . $row['house_id'] . '"> EDIT </a> </td><td>';
								}
								if ($per == 'sa') {
									echo ' <a  type="button" class="btn btn-xs btn-danger" href="index.php?action=delete&id=' . $row['house_id'] . '" onclick=\'return confirm("DELETING RECORD! Are you sure?")\'>DELETE </a>';
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
				<li class="page-item"><a class="page-link " href="?search=<?php echo $searchKey; ?>&pageno=<?php echo $total_pages; ?>">Last</a></li>
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


<style>

</style>