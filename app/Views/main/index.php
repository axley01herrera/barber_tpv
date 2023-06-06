<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>TPV Barber</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="TPV Barber Bussiness" name="description" />
    <meta content="Axley Herrera" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>">

    <!-- Bootstrap Css -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url('assets/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo base_url('assets/css/app.min.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/libs/sweetalert/sweetalert2.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/datatable/dataTables.bootstrap5.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/libs/apexcharts/dist/apexcharts.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />

    <style>
        .card-link {
            transition: transform 0.3s;
        }

        .card-link:hover {
            transform: scale(1.03);
            border: 2px solid rgba(3, 142, 220, 1);
        }

        .form-control {
            display: block;
            width: 100%;
            padding: .47rem .75rem;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #495057;
        }

        .apexcharts-xaxis text,
        .apexcharts-yaxis text {
            fill: #495057;
        }
    </style>

    <!-- JAVASCRIPT -->
    <script src="<?php echo base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/metismenujs/metismenujs.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/simplebar/simplebar.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/feather-icons/feather.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/sweetalert/sweetalert2.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/datatable/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/datatable/dataTables.bootstrap5.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/apexcharts/dist/apexcharts.min.js'); ?>"></script>

</head>

<body class="bg-dark">
    <div id="main-modal"></div>
    <div class="container-fluid">
        <?php echo view($page); ?>
    </div>
</body>

</html>