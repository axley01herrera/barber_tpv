<div class="container">
    <div class="row">
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
            <?php echo view('main/component/navTPV');?>
        </div>
        <div class="col-12 col-lg-8 mt-5">
            <div class="card ">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th><strong>Fecha</strong></th>
                                    <th><strong>Ticket ID</strong></th>
                                    <th hidden><strong>Nombre</strong></th>
                                    <th hidden><strong>Apellido</strong></th>
                                    <th class="text-center"><strong>Tipo de Cobro</strong></th>
                                    <th class="text-end"><strong>Total</strong></th>
                                </tr>
                            </thead>
                        </table>
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
            type: "POST"
        },
        order: [
            [0, 'desc']
        ],
        columns: [{
                data: 'date'
            },
            {
                data: 'ticketID'
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
                class: 'text-center'
            },
            {
                data: 'Total',
                class: 'text-end'
            }
        ],
    });
</script>