<?php
session_start();
include './lib/class_mysql.php';
include './lib/config.php';
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <title>Intranet</title>
  <?php include "./inc/links.php"; ?>
</head>

<body>
  <?php include "./inc/navbar.php"; ?>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-header">
          <h1 class="animated lightSpeedIn">Intranet <small>MDoñihue</small></h1>
          <span class="label label-danger">Depto. Informatica</span>
        </div>
      </div>
    </div>
  </div>
  <?php
  if (isset($_GET['view'])) {
    $content = $_GET['view'];
    $WhiteList = ["index", "productos", "soporte", "ticket", "ticketcon", "registro", "configuracion"];
    if (in_array($content, $WhiteList) && is_file("./user/" . $content . "-view.php")) {
      include "./user/" . $content . "-view.php";
    } else {
  ?>

  <?php
    }
  } else {
    include "./user/index-view.php";
  }
  ?>


  <?php include './inc/footer.php'; ?>
</body>

</html>