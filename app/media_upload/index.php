  <?php $title = "Manage Media" ?>
  <?php include_once('../../header.php') ?>
  <?php include_once('../../menu.php'); ?>

  <ol class="breadcrumb">
  	<li class="breadcrumb-item">
  		<a href="<?php echo $baseurl; ?>app/dashboard/dashboard.php">Dashboard</a>
  	</li>
  	<li class="breadcrumb-item active">Manage Media</li>
  </ol>
  <div class="col-lg-12">
  	<?php
		if (isset($_GET["delete"])) {
			$fName = $_GET["delete"];
			$file_pointer = "upload/" . $fName;
			if (!unlink($file_pointer)) {
				echo ("$file_pointer cannot be deleted due to an error");
			} else {
				echo ("$file_pointer has been deleted");
			}
		} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
				$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
				$filename = $_FILES["photo"]["name"];
				$filetype = $_FILES["photo"]["type"];
				$filesize = $_FILES["photo"]["size"];

				// Verify file extension
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if (!array_key_exists($ext, $allowed)) echo "<div class='alert alert-danger'>Error: Please select a valid file format.</div>";

				// Verify file size - 5MB maximum
				$maxsize = 5 * 1024 * 1024;
				if ($filesize > $maxsize) echo "<div class='alert alert-danger'>Error: File size is larger than the allowed limit.</div>";

				$newFileName = 'media_' . rand() . "_" . date('m-d-Y_hia') . "." . $ext;
				if (in_array($filetype, $allowed)) {
					if (file_exists("upload/" . $newFileName)) {
						echo $newFileName . " is already exists.";
					} else {
						move_uploaded_file($_FILES["photo"]["tmp_name"], "upload/" . $newFileName);
						echo "<div class='alert alert-success'>Your file was uploaded successfully.</div>";
					}
				} else {
					echo "<div class='alert alert-danger'>Error: There was a problem uploading your file. Please try again.</div>";
				}
			} else {
				echo "Error: " . $_FILES["photo"]["error"];
			}
		}
		?>

  	<div class="card mb-3">
  		<div class="card-header">
  			Upload File <small>(Base URL :<b> <?php echo $baseurl . "app/media_upload/upload/"; ?> </b>)</small>
  		</div>
  		<div class="card-body">
  			<form role="form" action="index.php" method="post" enctype="multipart/form-data">
  				<div class="form-group">
  					<div class="input-group input-file" name="photo">
  						<span class="input-group-btn">
  							<button class="btn btn-default btn-choose" type="button">Choose</button>
  						</span>
  						<input type="text" class="form-control" placeholder='Choose a file...' />
  						<span class="input-group-btn">
  							<button class="btn btn-warning btn-reset" type="button">Reset</button>
  						</span>
  					</div>
  				</div>
  				<div class="form-group">
  					<button type="submit" class="btn btn-primary float-right">Upload</button>
  				</div>

  			</form>
  		</div>
  		<div class="card-footer small text-muted">
  			<p><strong>Note:</strong> Only .jpg, .jpeg, .gif, .png formats allowed to a max size of 5 MB.</p>
  		</div>
  	</div>

  </div>
  <div class="col-lg-12">
  	<div class="card-header">
  		Uploaded Files
  	</div>
  	<div class="card-body">
  		<?php
			$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('upload'));

			$files = array();

			foreach ($rii as $file) {

				if ($file->isDir()) {
					continue;
				}

				$files[] = $file->getPathname();
			}



			?>
  		<div class="table-responsive">
  			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  				<thead>
  					<tr>
  						<th>Preview</th>
  						<th>URL</th>
  						<th>Action</th>
  					</tr>
  				</thead>
  				<tbody>
  					<?php foreach ($files as $img) {
							$fileImgName = basename($img);
							$fullURL = $baseurl . "app/media_upload/upload/" . $fileImgName;
						?>
  						<tr>
  							<td><img src="<?php echo $fullURL; ?>" width="120" height="90" /></td>
  							<td><input class="form-control" type="text" id="input_<?php echo $fileImgName; ?>" value="<?php echo $fileImgName; ?>" />
  								<span class="tooltiptext" id="tooltip_<?php echo $fileImgName; ?>"></span>
  							</td>
  							<td>
  								<a type="button" class="btn btn-xs btn-info" onclick="copyToClip('<?php echo $fileImgName; ?>')">
  									Click To Copy URL</a>
  								<?php

									if ($per == 'sa') {
										echo ' <a  type="button" class="btn btn-xs btn-danger" href="index.php?delete=' . $fileImgName . '"> DELETE </a> ';
									}

									?>
  							</td>
  						</tr>
  					<?php } ?>
  				</tbody>
  			</table>
  		</div>
  	</div>
  	<div class="card-footer small text-muted">
  	</div>
  </div>

  <?php include_once('../../footer.php') ?>

  <script>
  	function copyToClip(strID) {
  		var copyText = document.getElementById("input_" + strID);
  		copyText.select();
  		copyText.setSelectionRange(0, 99999);
  		document.execCommand("copy");
  		copyText.style.borderColor = "green";
  		copyText.style.borderWidth = "thick";
  		setTimeout(function() {
  			copyText.style.borderColor = "";
  			copyText.style.borderWidth = "";
  		}, 3000);
  	}

  	function bs_input_file() {
  		$(".input-file").before(
  			function() {
  				if (!$(this).prev().hasClass('input-ghost')) {
  					var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
  					element.attr("name", $(this).attr("name"));
  					element.change(function() {
  						element.next(element).find('input').val((element.val()).split('\\').pop());
  					});
  					$(this).find("button.btn-choose").click(function() {
  						element.click();
  					});
  					$(this).find("button.btn-reset").click(function() {
  						element.val(null);
  						$(this).parents(".input-file").find('input').val('');
  					});
  					$(this).find('input').css("cursor", "pointer");
  					$(this).find('input').mousedown(function() {
  						$(this).parents('.input-file').prev().click();
  						return false;
  					});
  					return element;
  				}
  			}
  		);
  	}
  	$(function() {
  		bs_input_file();
  	});
  </script>