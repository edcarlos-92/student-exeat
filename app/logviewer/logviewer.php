<?php include_once('../../header.php') ?>
<?php include_once('../../menu.php') ?>

        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Activity</a>
          </li>
          <li class="breadcrumb-item active">Activity Viewer</li>
        </ol>

        <!-- Icon Cards-->
        <div class="row">
		<div class="col-md-12">
		<table class='table table-striped'>
		
	<?php
try{		
$fileName = '../../logs/log_'.date("j.n.Y").'.log';

      if ( !file_exists($fileName) ) {
        throw new Exception('File not found.');
      }
		$handle = fopen($fileName, "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
		echo "<tr><td>";
		$line = str_replace("log.ERROR: ","",$line);
		$line = str_replace("log.INFO: ","",$line);
		$line = str_replace("log.WARNING: ","",$line);
		$line = str_replace("[] []","",$line);
		echo $line;
		echo "</td></tr>";
		
    }
		
    fclose($handle);
} else {
    // error opening the file.
} 
}catch(Exception $e) {
  echo "<tr><td>No Activity</td></tr>";
}
?>
</table>
</div>
		     </div>
<?php include_once('../../footer.php') ?>

