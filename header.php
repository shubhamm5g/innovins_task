<?php
session_start();
require_once("utils/db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="assets/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css
">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="assets/common.js"></script>

</head>
<nav class="navbar navbar-expand-lg bg-body-tertiary p-0">
  <div class="container-fluid px-4 bg-light">
    <a class="navbar-brand fs-2" href="#">Innovins Task</a>
    <button class="navbar-toggler " style="font-size:13px;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end " id="navbarNav">
      <ul class="navbar-nav ">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/innovins_task">Home</a>
        </li>
        <?php  if(!isset( $_SESSION['innovins']) && empty($_SESSION['innovins'])) { ?>
        <li class="nav-item">
          <a class="nav-link" href="signup.php">Sign up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="signin.php">Sign in</a>
        </li>
        <?php }else{ ?>
          <li class="nav-item">
          <a class="nav-link" href="users.php">Users</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="products.php">Products</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
          </li>
        <?php } ?>

      </ul>
    </div>
  </div>
</nav>
<div class="fulloverlay" >
    <div class="spinner-border cloader" role="status">
      <span class="sr-only">Loading...</span>
    </div>
</div>
<script>
  $(document).ready(function() {
        $(".fulloverlay").fadeOut();
    })
</script>