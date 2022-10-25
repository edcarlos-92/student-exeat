<?php include_once('../../header.php') ?>
<?php include_once('../../menu.php') ?>
<?php
if(isset($_POST["searchkey"])){
$searchkey = $_POST["searchkey"];
}else if(isset($_GET["s"])){ 
$searchkey = $_GET["s"];
}else{
	$searchkey="";
}
?>
 <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Search</a>
          </li>
          <li class="breadcrumb-item active">Search for : <?php echo $searchkey; ?></li>
        </ol>

        <!-- Icon Cards-->
        <div class="row">
   <?php 
   
if(isset($_POST["searchkey"]) || isset($_GET["s"])){
   $total_search_sql = "SELECT DISTINCT TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('category_id') AND TABLE_SCHEMA='exeat'";
   
   	$result = $db->query($total_search_sql);

					if ($result && $result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							$tableName = $row['TABLE_NAME'];
							echo '<div class="col-md-12">';
							$searchpage = file_get_contents($baseurl.'/app/'.$tableName.'/search.php?search='.urlencode($searchkey));
							echo $searchpage;
							echo '</div>';
						}
						
					}
}
?>
        </div>
<?php include_once('../../footer.php') ?>


