<?php
session_start();
function validateLogin($username, $password)
{
  //write your own logic if you wish
  if ($username == "admin" && $password == "admin123") {
    $_SESSION["permission"] = "sa";
    return true;
  } else if ($username == "user" && $password == "user123") {
    $_SESSION["permission"] = "a";
    return true;
  } else if ($username == "guest" && $password == "guest123") {
    $_SESSION["permission"] = "view";
    return true;
  } else {
    return false;
  }
}
if (isset($_POST["adminUsername"])) {

  if (validateLogin($_POST["adminUsername"], $_POST["adminPassword"])) {
    $_SESSION["user"] = $_POST["adminUsername"];
    header("Location: app/dashboard/dashboard.php");
  }
} else {
  unset($_SESSION['user']);
  unset($_SESSION['permission']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/ico" href="favicon.ico" />

    <title>Student Exeat Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

    <div class="container">
        <h1 style="color:aliceblue;font-weight:bold;display:flex;justify-content:center;margin-top:100px">SES</h1>

        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Login</div>
            <div class="card-body">
                <form action="index.php" method="POST">


                    <!-- <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" id="adminUsername" name="adminUsername" class="form-control"
                                placeholder="Email address" required="required">
                            <label for="adminUsername">Username</label>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <div class="form-outline mb-4 form-group">
                            <input type="text" id="adminUsername" name="adminUsername"
                                class="form-control form-control-lg" placeholder="Username" required="required" />
                        </div>
                    </div>





                    <!-- <div class="form-group">
                        <div class="form-label-group">
                            <input type="password" id="adminPassword" name="adminPassword" class="form-control"
                                placeholder="Password" required="required">
                            <label for="inputPassword">Password</label>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <div class="form-outline mb-4 form-group">
                            <input type="password" id="adminPassword" name="adminPassword"
                                class="form-control form-control-lg" placeholder="Password" required="required" />
                            <!-- <label for="inputPassword">Password</label> -->
                        </div>
                    </div>



                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <div class="text-center">
                    <!--<a class="d-block small mt-3" href="#">Register an Account</a>
          <a class="d-block small" href="#">Forgot Password?</a>-->
                </div>
            </div>
        </div>
    </div>

















    <!-- <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <h3 class="mb-5">Sign in</h3>

                            <div class="form-outline mb-4">
                                <input type="email" id="typeEmailX-2" class="form-control form-control-lg" />
                                <label class="form-label" for="typeEmailX-2">Email</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="typePasswordX-2" class="form-control form-control-lg" />
                                <label class="form-label" for="typePasswordX-2">Password</label>
                            </div>


                            <div class="form-check d-flex justify-content-start mb-4">
                                <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                                <label class="form-check-label" for="form1Example3"> Remember password </label>
                            </div>

                            <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>

                            <hr class="my-4">

                            <button class="btn btn-lg btn-block btn-primary" style="background-color: #dd4b39;"
                                type="submit"><i class="fab fa-google me-2"></i> Sign in with google</button>
                            <button class="btn btn-lg btn-block btn-primary mb-2" style="background-color: #3b5998;"
                                type="submit"><i class="fab fa-facebook-f me-2"></i>Sign in with facebook</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->





















    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>

<script>
$('input').click(function() {
    var val = $(this).val();
    if (val == "") {
        this.select();
    }
});
</script>