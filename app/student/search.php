<?php
session_start();
$per = "view";
if (isset($_SESSION["permission"])) {
    $per = $_SESSION["permission"];
}
function pathUrl($dir = __DIR__)
{
    $root = "";
    $dir = str_replace('\\', '/', realpath($dir));
    $root .= !empty($_SERVER['HTTPS']) ? 'https' : 'http';
    $root .= '://' . $_SERVER['HTTP_HOST'];
    if (!empty($_SERVER['CONTEXT_PREFIX'])) {
        $root .= $_SERVER['CONTEXT_PREFIX'];
        $root .= substr($dir, strlen($_SERVER['CONTEXT_DOCUMENT_ROOT']));
    } else {
        $root .= substr($dir, strlen($_SERVER['DOCUMENT_ROOT']));
    }
    $root .= '/';
    return $root;
}
$baseurl = pathUrl();
?>

<?php try { ?>
    <?php include_once('../../connection.php') ?>
    <?php
    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }
    $no_of_records_per_page = 30;
    $offset = ($pageno - 1) * $no_of_records_per_page;
    if (isset($_GET['search'])) {
        $searchKey = strtolower(urldecode($_GET['search']));
        $query = 'SELECT  t.* FROM student t  WHERE Lower(t.first_name) LIKE "%' . $searchKey . '%" OR Lower(t.middle_name) LIKE "%' . $searchKey . '%" OR Lower(t.last_name) LIKE "%' . $searchKey . '%" OR Lower(t.guardian_name) LIKE "%' . $searchKey . '%" OR Lower(t.guardian_ph) LIKE "%' . $searchKey . '%" OR Lower(t.photo_id) LIKE "%' . $searchKey . '%" LIMIT ' . $offset . ' , ' . $no_of_records_per_page . '';
        $result = $db->query($query);
        if ($result && $result->num_rows > 0) {
    ?>
            <?php if (isset($_GET['search'])) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <h6 onclick="showhide_student()"><i id="icon_student" class="fa fa-chevron-up"></i> Student <small><a href='<?php echo $baseurl; ?>'>View All Records</a></small></h6>

                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                    <th>Guardian Name</th>
                                    <th>Guardian Ph</th>
                                    <th>Photo Id</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td style="width:20px"><input class="checkRow" name="checkbox[]" type="checkbox" value="' . $row['student_id'] . '" /> &nbsp;' . $row['student_id'] . '</td>';
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
                                    echo '<td>';
                                    if ($per == 'sa' || $per == 'a') {
                                        echo ' <a type="button" class="btn btn-xs btn-warning" href="' . $baseurl . 'update.php?id=' . $row['student_id'] . '"> VIEW </a> ';
                                    }

                                    echo '</tr>';
                                }

                                ?>

                            </tbody>
                        </table>

                    </div>
                </div>

    <?php }
        }
    } ?>

<?php } catch (Exception $e) {
} ?>
<script>
    function showhide_student() {
        var x = document.getElementById("table_student");
        if (x.style.display === "none") {
            x.style.display = "block";
            document.getElementById("icon_student").className = "fa fa-chevron-down";
        } else {
            x.style.display = "none";
            document.getElementById("icon_student").className = "fa fa-chevron-up";
        }
    }
</script>