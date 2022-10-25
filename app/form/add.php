<?php $title = "Form - Add" ?>
<?php include_once('../../header.php') ?>
<?php include_once('../../menu.php'); ?>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?php echo $baseurl; ?>app/dashboard/dashboard.php">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Form Add New</li>
</ol>



<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-2 sidenav">
        </div>
        <div class="col-sm-8 text-left">


            <!-- Place Form Here -->


            <div class="card mb-3">
                <?php if (isset($_GET['action'])) { ?>
                    <div class="col-lg-12">
                        <?php

                        switch ($_GET['action']) {
                            case 'add':
                                $form_name = $_POST['form_name'];


                                $query = "INSERT INTO form (form_name) Values ( '" . $form_name . "');";

                                if ($db->query($query) === TRUE) {
                                    $log->info('A new record create on Form by ' . $_SESSION["user"]);
                                    echo "<div class='alert alert-success'>New record created successfully <a href='index.php'>Go back to list</a></div>";
                                } else {
                                    $log->error('Error in creating new record on Form by ' . $_SESSION["user"]);
                                    $log->error($db->error);
                                    echo "<div class='alert alert-error'>Error: <br>" . $db->error . " <a href='index.php'>Go back to list</a></div>";
                                }

                                break;
                        }
                        ?>
                    </div> <?php } ?>
                <div class="card-header">
                    Form <small>Create</small>
                </div>
                <div class="card-body">
                    <form role="form" method="post" action="add.php?action=add">

                        <div class="form-group"><label>Form Name</label><textarea class='form-control' rows='3' name='form_name' required></textarea></div>

                        <?php if ($per == "sa" || $per == "a") { ?>
                            <button type="submit" class="btn btn-primary">Save Record</button>
                            <button type="reset" class="btn btn-secondary">Clear Entry</button>
                        <?php } else { ?>
                            <a href="#" class="btn btn-primary">You do not have permission to add record.</a>
                        <?php } ?>

                    </form>
                </div>
                <div class="card-footer small text-muted">

                </div>
            </div>


            <!-- Place Form Here -->



        </div>
        <div class="col-sm-2 sidenav">
        </div>
    </div>
</div>






<?php include_once('../../footer.php') ?>