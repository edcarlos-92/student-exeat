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
function pathUrlHeader($dir = __DIR__)
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
include_once('../../connection.php');
if (!isset($_SESSION["user"])) {
  $baseurl = pathUrlHeader();
  header("Location: $baseurl");
}
require_once('../../vendor/autoload.php');
require_once('../../vendor/php-excel-reader/excel_reader2.php');
require_once('../../vendor/php-excel-reader/SpreadsheetReader.php');
require_once('../../vendor/php-excel-reader/SpreadsheetReader_CSV.php');
require_once('../../vendor/php-excel-reader/SpreadsheetReader_XLS.php');
require_once('../../vendor/php-excel-reader/SpreadsheetReader_XLSX.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('log');
$log->pushHandler(new StreamHandler('../../logs/log_' . date("j.n.Y") . '.log', Logger::DEBUG));

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <?php if (isset($title)) { ?>
    <title><?php echo $title; ?></title>
  <?php } else {
  ?>
    <title>Student Exeat</title>
  <?php
  }
  ?>

  <!-- Custom fonts for this template-->
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../../vendor/datatables/datatables.min.css" rel="stylesheet">
  <link href="../../vendor/datatables/jquery.dataTables.min.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="../../css/sb-admin.css" rel="stylesheet">
  <link href="../../css/custom.css" rel="stylesheet">
  <link href="../../vendor/jqueryUI/jquery-ui.css" rel="stylesheet">
</head>

<body id="page-top" class="">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="../../index.php">Student Exeat</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" method="post" action="<?php echo $baseurl ?>app/dashboard/search.php">
      <!-- <div class="input-group">
        <input type="text" name="searchkey" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div> -->
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <?php if ($per == "sa" || $per == "a") { ?>
        <li class="nav-item no-arrow mx-1">
          <a class="nav-link" href="<?php echo $baseurl; ?>app/logviewer/logviewer.php">
            <i class="fas fa-bell fa-fw"></i>
          </a>
        </li>
      <?php } ?>
      <?php if ($_SESSION["user"] == "Guest" || $_SESSION["user"] == "guest") { ?>
        <li class="nav-item dropdown no-arrow ">
          <a class="nav-link" href="<?php echo $baseurl; ?>">
            <i class="fas fa-user-circle fa-fw"></i> LOGIN
          </a>

        </li>
      <?php } else { ?>
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i> <?php echo $_SESSION["user"]; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <!-- <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="#">Activity Log</a>-->
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      <?php } ?>
    </ul>

  </nav>

  <div id="wrapper">