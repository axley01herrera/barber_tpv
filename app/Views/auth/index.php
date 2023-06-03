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

    <!-- JAVASCRIPT -->
    <script src="<?php echo base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/metismenujs/metismenujs.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/simplebar/simplebar.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/feather-icons/feather.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/sweetalert/sweetalert2.js'); ?>"></script>

</head>

<body>
    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay bg-white"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-4">
                        <div class="text-center  py-5">
                            <div class="mb-4">
                                <h1>Bienvenido</h1>
                                <h5>Inicia sessión para continuar</h5>
                            </div>
                            <div>
                                <div class="form-floating form-floating-custom mb-3">
                                    <input type="text" class="form-control required focus email" id="txt-email" placeholder="Email">
                                    <label for="txt-email">Email</label>
                                    <div class="form-floating-icon">
                                        <i class="uil uil-envelope-alt"></i>
                                    </div>
                                </div>
                                <div class="form-floating form-floating-custom mb-3">
                                    <input type="password" class="form-control required focus" id="txt-clave" placeholder="Clave">
                                    <label for="txt-clave">Clave</label>
                                    <div class="form-floating-icon">
                                        <i class="uil uil-padlock"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button id="btn-login" type="button" class="btn btn-info w-100">Entrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="text-center text-muted p-4">
                            <h5 class="mb-0">&copy; <script>
                                    document.write(new Date().getFullYear())
                                </script> Creado por Axley Herrera Vázquez</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo view('global/form_validation'); ?>

    <script>
        $('#btn-login').on('click', function() {

            let resultCheckRequiredValues = checkRequiredValues('required');

            if (resultCheckRequiredValues == 0) {
                let resultCheckEmailFormat = checkEmailFormat('email');

                if (resultCheckEmailFormat == 0) {
                    $.ajax({

                        type: "post",
                        url: "<?php echo base_url('Authentication/login'); ?>",
                        data: {
                            'email': $('#txt-email').val(),
                            'clave': $('#txt-clave').val()
                        },
                        dataType: "json",

                    }).done(function(jsonResponse) {

                        if (jsonResponse.error == 0) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                title: jsonResponse.msg
                            });

                            setTimeout(() => {
                                 window.location.href = "<?php echo base_url('Main'); ?>";
                            }, "2000");

                        } else {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'error',
                                title: jsonResponse.msg
                            });
                        }

                    }).fail(function(error) {

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: 'Ha ocurrido un error'
                        });

                    })
                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: 'El formato del email no es correcto'
                    });

                }
            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: 'Email y Clave son requeridos'
                });
            }
        });
    </script>
</body>

</html>