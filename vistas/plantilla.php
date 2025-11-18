<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Lima');

?>
﻿<!DOCTYPE html>
<html lang="en-US" dir="ltr" data-navigation-type="horizontal" data-navbar-horizontal-shape="default">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Aalza</title>

<!--    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-touch-icon-1.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32-1.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16-1.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/favicon-1.ico">
    <link rel="manifest" href="vistas/assets/img/favicons/manifest-1.json">-->
    <meta name="msapplication-TileImage" content="vistas/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="vistas/vendors/simplebar/simplebar.min-1.js"></script>
    <script src="vistas/assets/js/config-1.js"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="vistas/vendors/choices/choices.min.css" rel="stylesheet">
    <link href="vistas/vendors/dhtmlx-gantt/dhtmlxgantt.css" rel="stylesheet">
    <link href="vistas/vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="css2-1?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link href="vistas/vendors/simplebar/simplebar.min-1.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="../../../release/v4.0.8/css/line-1.css">-->
    <link href="vistas/assets/css/theme-rtl.min-1.css" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="vistas/assets/css/theme.min-1.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="vistas/assets/css/user-rtl.min-1.css" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="vistas/assets/css/user.min-1.css" type="text/css" rel="stylesheet" id="user-style-default">
<!--    <script>
      var phoenixIsRTL = window.config.config.phoenixIsRTL;
      if (phoenixIsRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>-->
    <!-- DataTables Bootstrap 5 CSS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

  </head>

  <body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <?php
         if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok"){
         
        ?>
        <?php include "modulos/header.php"; ?>
      
        <?php 
            if(isset($_GET["ruta"])){

                    if($_GET["ruta"] == "inicio"||
                       $_GET["ruta"] == "expediente_detalle"|| 
                       $_GET["ruta"] == "expedientes"||     
                       $_GET["ruta"] == "salir"){

                      include "modulos/".$_GET["ruta"].".php";

                    }else{

                      include "modulos/404.php";

                    }

            }else{

                    include "modulos/inicio.php";

            }
        ?>
        <?php }else{
               include "modulos/login.php";
                
                
        } ?>
    </main>
    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="vistas/vendors/popper/popper.min-1.js"></script>
    <script src="vistas/vendors/bootstrap/bootstrap.min-1.js"></script>
    <script src="vistas/vendors/anchorjs/anchor.min-1.js"></script>
    <script src="vistas/vendors/is/is.min-1.js"></script>
    <script src="vistas/vendors/fontawesome/all.min-1.js"></script>
    <script src="vistas/vendors/lodash/lodash.min-1.js"></script>
    <script src="vistas/vendors/list.js/list.min-1.js"></script>
    <script src="vistas/vendors/dayjs/dayjs.min-1.js"></script>
    <script src="vistas/vendors/choices/choices.min.js"></script>
    <script src="vistas/vendors/echarts/echarts.min.js"></script>
    <script src="vistas/vendors/dhtmlx-gantt/dhtmlxgantt.js"></script>
    <script src="vistas/vendors/flatpickr/flatpickr.min.js"></script>
    <script src="vistas/assets/js/phoenix-1.js"></script>
    <script src="vistas/assets/js/dashboards/projectmanagement-dashboard.js"></script>
	
    <script src="vistas/vendors/feather-icons/feather.min-1.js"></script>
    <script src="vistas/vendors/dayjs/dayjs.min-1.js"></script>
    <script src="vistas/assets/js/phoenix-1.js"></script>
    <script src="vistas/vendors/echarts/echarts.min.js"></script>
    <script src="vistas/assets/js/dashboards/ecommerce-dashboard.js"></script>
    
    <script src="vistas/js/expedientes.js"></script>
    <script src="vistas/js/usos_estacionamiento.js"></script>
  </body>

</html>