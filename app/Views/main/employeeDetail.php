<div id="main-content" data-value="employeeDetail" class="container">
    <div class="row">
        <div class="col-12 mt-5">
            <?php
            if ($role == 1) {
                echo view('main/component/btnControlPanel');
                echo view('main/component/btnListEmployee');
            } else echo view('main/component/btnLogout');
            ?>
        </div>
        <div class="col-12 col-lg-4 mt-5">
            <div class="card">
                <div class="mt-2">
                    <img class="card-img-top img-fluid" src="<?php echo base_url('assets/images/small/img-1.jpg'); ?>" alt="employee">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h4 class="card-title mb-2"><?php echo $employee[0]->name . ' ' . $employee[0]->lastName; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if ($userLoggedID == $employee[0]->id)
                echo view('main/component/navTPV');
            ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="font-size-xs text-uppercase">Producción
                        <?php
                        setlocale(LC_TIME, 'es_VE.UTF-8', 'esp'); // Establece la configuración regional en español
                        $fechaActual = strftime('%A %e de %B del %Y'); // Obtiene la fecha actual formateada en español
                        echo $fechaActual; // Muestra: martes 6 de junio del 2023
                        ?>
                    </h6>
                    <div class="row">
                        <div class="col-12 col-lg-4 mt-3 text-center">
                            <h4 class="font-weight-bold d-flex align-items-center text-center">
                                Efectivo <?php echo '€ ' . number_format((float) $totalDayProduction['cash'], 2, ".", ','); ?>
                            </h4>
                        </div>
                        <div class="col-12 col-lg-4 mt-3 text-center">
                            <h4 class="font-weight-bold d-flex align-items-center text-center">
                                Tarjeta <?php echo '€ ' . number_format((float) $totalDayProduction['card'], 2, ".", ','); ?>
                            </h4>
                        </div>
                        <div class="col-12 col-lg-4 mt-3 text-center">
                            <h4 class="font-weight-bold d-flex align-items-center text-center">
                                Total <?php echo '€ ' . number_format((float) $totalDayProduction['all'], 2, ".", ','); ?>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 mt-5">
            <div class="row">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-body">
                            <h4 class="card-title mb-2"><i class="mdi mdi-clipboard-edit-outline"></i> Tickets</h4>
                            <div class="table-responsive">
                                <table id="dataTable" class="table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><strong>Fecha</strong></th>
                                            <th hidden><strong>Ticket ID</strong></th>
                                            <th hidden><strong>Nombre</strong></th>
                                            <th hidden><strong>Apellido</strong></th>
                                            <th><strong>Tipo de Cobro</strong></th>
                                            <th class="text-end"><strong>Total</strong></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="font-size-xs text-uppercase">Recaudación Semanal</h6>
                            <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center"><?php echo '€ ' . number_format((float) $chartWeek['total'], 2, ".", ','); ?></h4>
                            <div class="text-muted">Acumulada por el empleado</div>
                            <div id="chartWeek"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="font-size-xs text-uppercase">Recaudación Mensual</h6>
                            <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center"><?php echo '€ ' . number_format((float) $chartMont['total'], 2, ".", ','); ?></h4>
                            <div class="text-muted">Acumulada por el empleado</div>
                            <div id="chart3"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var dataTable = $('#dataTable').DataTable({

        destroy: true,
        processing: true,
        serverSide: true,
        responsive: true,
        bAutoWidth: true,
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],
        language: {
            url: '<?php echo base_url('assets/libs/dataTable/es.json'); ?>'
        },
        ajax: {
            url: "<?php echo base_url('Main/processingBasketDT'); ?>",
            type: "POST",
            data: function(d) {
                d.userID = '<?php echo $employee[0]->id; ?>'
            }
        },
        order: [
            [0, 'desc']
        ],
        columns: [{
                data: 'date'
            },
            {
                data: 'ticketID',
                visible: false,
            },
            {
                data: 'userName',
                visible: false,
                searchable: false
            },
            {
                data: 'userlastName',
                visible: false,
                searchable: false
            },
            {
                data: 'paymentType',
            },
            {
                data: 'Total',
                class: 'text-end'
            }
        ],
    });

    dataTable.on('click', '.edit-payment-method', function(event) { // EDIT PAYMENTTYPE

        $.ajax({

            type: "post",
            url: "<?php echo base_url('Main/showModalSelectPayMethod'); ?>",
            data: {
                'type': $(this).attr('data-pay-type'),
                'action': 'update',
                'basketID': $(this).attr('data-basket-id'),
            },
            dataType: "html",

        }).done(function(htmlResponse) {

            $('#main-modal').html(htmlResponse);

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
            });

            Toast.fire({
                icon: 'error',
                title: 'Ha ocurrido un error'
            });

        });

    });

    var options2 = {
        series: [{
            name: 'Recaudación',
            data: [
                <?php echo $chartWeek['mon']; ?>,
                <?php echo $chartWeek['tue']; ?>,
                <?php echo $chartWeek['wed']; ?>,
                <?php echo $chartWeek['thu']; ?>,
                <?php echo $chartWeek['fri']; ?>,
                <?php echo $chartWeek['sat']; ?>,
                <?php echo $chartWeek['sun']; ?>
            ],
        }],
        annotations: {
            points: [{
                x: 'Recaudación',
                seriesIndex: 0,
                label: {
                    borderColor: '#775DD0',
                    offsetY: 0,
                    style: {
                        color: '#fff',
                        background: '#775DD0',
                    },
                    text: 'Mejor Recaudación',
                }
            }]
        },
        chart: {
            height: 200,
            type: 'bar',
        },
        plotOptions: {
            bar: {
                borderRadius: 0,
                columnWidth: '15%',
            }
        },
        dataLabels: {
            enabled: false,
        },
        grid: {
            row: {
                colors: ['#fff', '#f2f2f2']
            }
        },
        xaxis: {
            labels: {
                rotate: -45,
            },
            categories: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
        },
        yaxis: {
            title: {
                text: '',
            },
            labels: {
                formatter: (value) => {
                    return '€ ' + value.toFixed(2);
                },
            },
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: "horizontal",
                shadeIntensity: 0.25,
                gradientToColors: undefined,
                opacityFrom: 0.85,
                opacityTo: 0.85,
                stops: [50, 0, 100]
            },
        }
    };

    var chartWeek = new ApexCharts(document.querySelector("#chartWeek"), options2);
    chartWeek.render();

    var options3 = {
        series: [{
            name: 'Recaudación',
            data: [
                <?php echo $chartMont[1]; ?>,
                <?php echo $chartMont[2]; ?>,
                <?php echo $chartMont[3]; ?>,
                <?php echo $chartMont[4]; ?>,
                <?php echo $chartMont[5]; ?>,
                <?php echo $chartMont[6]; ?>,
                <?php echo $chartMont[7]; ?>,
                <?php echo $chartMont[8]; ?>,
                <?php echo $chartMont[9]; ?>,
                <?php echo $chartMont[10]; ?>,
                <?php echo $chartMont[11]; ?>,
                <?php echo $chartMont[12]; ?>
            ],
        }],
        annotations: {
            points: [{
                x: 'Recaudación',
                seriesIndex: 0,
                label: {
                    borderColor: '#775DD0',
                    offsetY: 0,
                    style: {
                        color: '#fff',
                        background: '#775DD0',
                    },
                    text: 'Mejor Recaudación',
                }
            }]
        },
        chart: {
            height: 200,
            type: 'bar',
        },
        plotOptions: {
            bar: {
                borderRadius: 0,
                columnWidth: '15%',
            }
        },
        dataLabels: {
            enabled: false,
        },
        grid: {
            row: {
                colors: ['#fff', '#f2f2f2']
            }
        },
        xaxis: {
            labels: {
                rotate: -45,
            },
            categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        },
        yaxis: {
            title: {
                text: '',
            },
            labels: {
                formatter: (value) => {
                    return '€ ' + value.toFixed(2);
                },
            },
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: "horizontal",
                shadeIntensity: 0.25,
                gradientToColors: undefined,
                opacityFrom: 0.85,
                opacityTo: 0.85,
                stops: [50, 0, 100]
            },
        }
    };

    var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
    chart3.render();
</script>