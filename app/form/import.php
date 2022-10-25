<?php $title = "Form - Import" ?>
<?php include_once('../../header.php') ?>
<?php include_once('../../menu.php'); ?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="<?php echo $baseurl; ?>app/dashboard/dashboard.php">Dashboard</a>
	</li>
	<li class="breadcrumb-item">
		<a href="<?php echo $baseurl; ?>app/form/index.php">Form View</a>
	</li>
	<li class="breadcrumb-item active">Form Import</li>
</ol>
<div class="card mb-3">
	<div class="card-header">
		Form <small>Import</small>
	</div>
	<div class="card-body">
		<form method="POST" action="import.php" enctype="multipart/form-data">
			<div class="form-group">
				<label>Upload Excel File</label>
				<input type="file" name="file" />
			</div>
			<div class="form-group mb-0">
				<button type="submit" name="btnUpload" class="btn btn-success">Upload</button>
			</div>

		</form>
	</div>
</div>
<?php
if (isset($_POST['btnImport']) && isset($_POST['filePath'])) {
	$uploadFilePath = $_POST['filePath'];
	$columnCount = $_POST['columnCount'];
	$ext = pathinfo($uploadFilePath, PATHINFO_EXTENSION);
	switch (strtolower($ext)) {
		case 'xls':
			$Reader = new SpreadsheetReader($uploadFilePath);
			break;
		case 'xlsx':
			$Reader = new SpreadsheetReader_XLSX($uploadFilePath);
			break;
		case 'csv':
			$Reader = new SpreadsheetReader_CSV($uploadFilePath);
			break;
		default:
			$Reader = new SpreadsheetReader($uploadFilePath);
			break;
	}
	$Reader->ChangeSheet(0);
	$query = "";
	$columnName = "";
	$columnValues = "";
	for ($x = 0; $x < $columnCount; $x++) {
		$columnName .= $_POST["Column-$x"] . ",";
	}
	$columnName = rtrim($columnName, ',');
	$selectedRows = $_POST['checkbox'];
	$rowId = 0;
	foreach ($Reader as $Row) {
		if (in_array($rowId, $selectedRows)) {
			$values = "";
			for ($x = 0; $x < $columnCount; $x++) {
				$values .= "'" . (isset($Row[$x]) ? $Row[$x] : '') . "',";
			}
			$values = rtrim($values, ',');
			$columnValues .= "(" . $values . "),";
		}
		$rowId = $rowId + 1;
	}
	$values = rtrim($values, ',');
	$query .= "INSERT INTO form (" . $columnName . ") Values " . $columnValues . "";

	$query = rtrim($query, ',');
	if ($db->query($query) === TRUE) {
		$log->info('Imported from file '.$uploadFilePath. " by " . $_SESSION["user"]);
		echo "<div class='alert alert-success'>Record imported successfully <a href='index.php'>Go back to list</a></div>";
	} else {
		$log->error('Error in importing file '.$uploadFilePath. " by " . $_SESSION["user"]);
		$log->error($db->error);
		echo "<div class='alert alert-error'>Error: <br>" . $db->error . " <a href='index.php'>Go back to list</a></div>";
	}
}
if (isset($_POST['btnUpload'])) {
?>
	<div class="card mb-3">
		<div class="card-header">
			<form method='POST'>
				Verify Data
				<input type="hidden" name="columnCount" value="1" />
				<button type="submit" name="btnImport" class="btn btn-success float-right">Import Selected Rows</button>
		</div>
		<div class="card-body">
			<?php $mimes = ['application/vnd.ms-excel', 'application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.oasis.opendocument.spreadsheet'];
			if (in_array($_FILES["file"]["type"], $mimes)) {
				$columnCount=1;
				$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				$newFileName = basename($_FILES['file']['name']) . '_' . rand() . "_" . date('m-d-Y_hia') . "." . $ext;
				$uploadFilePath = '../../importfiles/' . $newFileName;
				move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);

				switch (strtolower($ext)) {
					case 'xls':
						$Reader = new SpreadsheetReader($uploadFilePath);
						break;
					case 'xlsx':
						$Reader = new SpreadsheetReader_XLSX($uploadFilePath);
						break;
					case 'csv':
						$Reader = new SpreadsheetReader_CSV($uploadFilePath);
						break;
					default:
						$Reader = new SpreadsheetReader($uploadFilePath);
						break;
				}
				$tableColumnList = ['form_name'];
				$count = 0;

				$html = "<input type='hidden' name='filePath' value='" . $uploadFilePath . "' /><table class='table table-bordered'>";
				$html .= "<thead>";
				$html .= "<tr><th style='width:20px'><input class='checkAll' type='checkbox'/> All</th>";
				$selectOption = "";
				foreach ($tableColumnList as $col) {
					$selectOption .= "<th><select class='form-control' name='Column-" . $count . "'>";
					foreach ($tableColumnList as $col2) {
						$selected = $tableColumnList[$count] == $col2 ? 'selected' : '';
						$selectOption .= "<option value='" . $col2 . "' " . $selected . ">" . $col2 . "</option>";
					}
					$count = $count + 1;
					$selectOption .= "</select></th>";
				}
				$html .= $selectOption . "</tr>";
				$html .= "</thead>";
				$Reader->ChangeSheet(0);

				$index = 0;
				foreach ($Reader as $Row) {
					$html .= '<tr><td><input class="checkRow" name="checkbox[]" type="checkbox" value="' . $index . '" /></td>';
					for ($x = 0; $x < $columnCount; $x++) {
					$html .= '<td>' . (isset($Row[$x]) ? $Row[$x] : '') . '</td>';
					}
					$html .= "</tr>";
					$index = $index + 1;
				}
				$html .= "</table>";
				echo $html;
			} else {
				die("<div class='alert alert-danger'>Error: Sorry, File type is not allowed. Only Excel or CSV file.</div>");
			} ?>
			</form>
		</div>
	<?php } ?>
	</div>
	<?php include_once('../../footer.php') ?>
