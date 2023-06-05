<div class="container">
    <div class="row mt-5">
        <div class="col-12">
            <h1 class="text-primary">
                <i class="mdi mdi-application-cog"></i> Panel de Control
            </h1>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12">
            <!-- BTN LOGOUT -->
            <?php echo view('main/component/btnLogout'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-4 mt-3">
            <!-- NAV EMPLOYEE -->
            <?php echo view('main/component/navEmployee'); ?>
        </div>
        <div class="col-12 col-lg-4 mt-3">
            <!-- NAV PRODUCTS -->
            <?php echo view('main/component/navProducts'); ?>
        </div>
        <div class="col-12 col-lg-4 mt-3">
            <!-- NAV TPV -->
            <?php echo view('main/component/navTPV'); ?>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="font-size-xs text-uppercase">Recaudación de Hoy</h6>
                    <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center"><?php echo '€ ' . number_format((float) $totalDayProduction, 2, ".", ','); ?></h4>
                    <div class="text-muted">Recaudación por Empleado</div>
                    <div id="chart"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h6 class="font-size-xs text-uppercase">Recaudación Semanal </h6>
                    <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center"><?php echo '€ ' . number_format((float) $chartWeek['total'], 2, ".", ','); ?></h4>
                    <div class="text-muted">Acumulada por todos los empleados</div>
                    <div id="chart2"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="font-size-xs text-uppercase">Recaudación Mensual</h6>
                    <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center"><?php echo '€ ' . number_format((float) $chartMont['total'], 2, ".", ','); ?></h4>
                    <div class="text-muted">Acumulada por todos los empleados</div>
                    <div id="chart3"></div>
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-2">
                            <label for="">Año</label>
                            <select id="sel-year" class="form-select">
                                <?php
                                
                                $start = $currentYear - 10;
                                while ($start <= $currentYear) {

                                ?>
                                    <option <?php if($start == $year) echo 'selected';?> value="<?php echo $start; ?>"><?php echo $start; ?></option>
                                <?php
                                    $start = $start + 1;
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var options = {
        series: [{
            name: 'Recaudación de hoy',
            data: <?php echo json_encode($charData['serie']); ?>,
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
            categories: <?php echo json_encode($charData['cat']); ?>,
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

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

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

    var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
    chart2.render();

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

    $('#sel-year').on('change', function() {

        let value = $(this).val();
        window.location.href = "<?php echo base_url('Main/index') . '?year='; ?>" + value;

    });
</script>