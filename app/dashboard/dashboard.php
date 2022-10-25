<?php include_once('../../header.php') ?>
<?php include_once('../../menu.php') ?>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>

<!-- Icon Cards-->
<div class="row">

    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon"> <i class="fas fa-fw fa-arrow-circle-right"></i> </div>
                <div class="mr-5"> <?php $total_pages_sql = "select COUNT(*) from exeat";
                                    $resultPage = mysqli_query($db, $total_pages_sql);
                                    $total_rows = mysqli_fetch_array($resultPage)[0];
                                    echo $total_rows; ?> Exeats</div>
            </div> <a class="card-footer text-white clearfix small z-1" href="<?php echo $baseurl; ?>app/exeat"> <span
                    class="float-left">View Details</span> <span class="float-right"> <i class="fas fa-angle-right"></i>
                </span> </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon"> <i class="fas fa-fw fa-window-maximize"></i> </div>
                <div class="mr-5"> <?php $total_pages_sql = "select COUNT(*) from form";
                                    $resultPage = mysqli_query($db, $total_pages_sql);
                                    $total_rows = mysqli_fetch_array($resultPage)[0];
                                    echo $total_rows; ?> Forms</div>
            </div> <a class="card-footer text-white clearfix small z-1" href="<?php echo $baseurl; ?>app/form"> <span
                    class="float-left">View Details</span> <span class="float-right"> <i class="fas fa-angle-right"></i>
                </span> </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon"> <i class="fas fa-fw fa-building"></i> </div>
                <div class="mr-5"> <?php $total_pages_sql = "select COUNT(*) from house";
                                    $resultPage = mysqli_query($db, $total_pages_sql);
                                    $total_rows = mysqli_fetch_array($resultPage)[0];
                                    echo $total_rows; ?> Houses</div>
            </div> <a class="card-footer text-white clearfix small z-1" href="<?php echo $baseurl; ?>app/house"> <span
                    class="float-left">View Details</span> <span class="float-right"> <i class="fas fa-angle-right"></i>
                </span> </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-secondary o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon"> <i class="fas fa-fw fa-users"></i> </div>
                <div class="mr-5"> <?php $total_pages_sql = "select COUNT(*) from student";
                                    $resultPage = mysqli_query($db, $total_pages_sql);
                                    $total_rows = mysqli_fetch_array($resultPage)[0];
                                    echo $total_rows; ?> Students</div>
            </div> <a class="card-footer text-white clearfix small z-1" href="<?php echo $baseurl; ?>app/student"> <span
                    class="float-left">View Details</span> <span class="float-right"> <i class="fas fa-angle-right"></i>
                </span> </a>
        </div>
    </div>

</div>


<!-- Activity Row-->

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Activity</a>
    </li>
    <li class="breadcrumb-item active">Activity Viewer</li>
</ol>



<div class="row">
    <div class="col-md-12">
        <table class='table table-striped'>

            <?php
            try {
                $fileName = '../../logs/log_' . date("j.n.Y") . '.log';

                if (!file_exists($fileName)) {
                    throw new Exception('File not found.');
                }
                $handle = fopen($fileName, "r");
                if ($handle) {
                    while (($line = fgets($handle)) !== false) {
                        // process the line read.
                        echo "<tr><td>";
                        $line = str_replace("log.ERROR: ", "", $line);
                        $line = str_replace("log.INFO: ", "", $line);
                        $line = str_replace("log.WARNING: ", "", $line);
                        $line = str_replace("[] []", "", $line);
                        echo $line;
                        echo "</td></tr>";
                    }

                    fclose($handle);
                } else {
                    // error opening the file.
                }
            } catch (Exception $e) {
                echo "<tr><td>No Activity</td></tr>";
            }
            ?>
        </table>
    </div>
</div>















<?php include_once('../../footer.php') ?>