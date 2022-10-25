 <?php  include_once('../../connection.php'); ?>
<?php
 $query = 'SELECT  t.* FROM house t ';
 $results=array();						 
 $result = $db->query($query);
 if ($result && $result->num_rows > 0) {
 $filename = "House.xls"; // File Name
    // Download file
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Content-Type: application/vnd.ms-excel");

 $flag = false;
	while($row = $result->fetch_assoc()) {
 if (!$flag) {
     // display field/column names as first row
     echo implode("\t", array_keys($row)) . "\r\n";
     $flag = true;
 }
    echo implode("\t", array_values($row)) . "\r\n";
}}
    ?>
