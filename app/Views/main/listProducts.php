<div class="container">
    <div class="row mt-5">
        <div class="col-12 ">
            <h1 class="text-primary">
                Listado de Productos
            </h1>
        </div>
        <div class="col-12 mt-5">
            <?php echo view('main/component/btnControlPanel'); ?>
            <button id="btn-createProducts" class="btn btn-sm btn-success">Crear Producto</button>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th><strong>Nombre</strong></th>
                            <th><strong>Precio</strong></th>
                            <th class="text"><strong>Desactivar / Activar</strong></th>
                            <th class=""></th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $('#btn-createProducts').on('click', function() { // CREATE

        $.ajax({

            type: "post",
            url: "<?php echo base_url('Main/showModalProducts'); ?>",
            data: {
                'action': 'create'
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
            })

            Toast.fire({
                icon: 'error',
                title: 'Ha ocurrido un error'
            });

        });

    });

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
            url: "<?php echo base_url('Main/processingProducts'); ?>",
            type: "POST"
        },
        order: [
            [0, 'asc']
        ],
        columns: [{
                data: 'name'
            },
            {
                data: 'cost'
            },
            {
                data: 'switch',
                orderable: false,
                searchable: false
            },
            {
                data: 'status',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                class: 'text-end',
                searchable: false,
                orderable: false
            }
        ],
    });

    dataTable.on('click', '.btn-editProduct', function(event) { // EDIT

        event.preventDefault();

        $.ajax({

            type: "post",
            url: "<?php echo base_url('Main/showModalProducts'); ?>",
            data: {
                'userID': $(this).attr('data-id'),
                'action': 'update',
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

    dataTable.on('click', '.btn-delete-product', function(event) { // DELETE

        event.preventDefault();

        $.ajax({

            type: "post",
            url: "<?php echo base_url('Main/deleteProduct'); ?>",
            data: {
                'userID': $(this).attr('data-id'),
                'action': 'delete',
            },
            dataType: "json",

        }).done(function(jsonResponse) {

            if (jsonResponse.error == 0) // SUCCESS
            {
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
                    icon: 'success',
                    title: jsonResponse.msg
                });

                dataTable.draw();

            } else // ERROR
            {
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
                    title: jsonResponse.msg
                });

            }

            if (jsonResponse.error == 2) // SESSION EXPIRED
                window.location.href = "<?php echo base_url('Authentication'); ?>";

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

    dataTable.on('click', '.switch', function(event) { // ACTIVE / INACTIVE

        let status = $(this).attr('data-status');
        let newStatus = '';

        if (status == 0)
            newStatus = 1;
        else if (status == 1)
            newStatus = 0;

        $.ajax({

            type: "post",
            url: "<?php echo base_url('Main/changeProductStatus'); ?>",
            data: {
                'id': $(this).attr('data-id'),
                'status': newStatus,
            },
            dataType: "json",

        }).done(function(jsonResponse) {

            if (jsonResponse.error == 0) // SUCCESS
            {
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
                    icon: 'success',
                    title: jsonResponse.msg
                });

                dataTable.draw();
            } else // ERROR
            {
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
                    title: jsonResponse.msg
                });
            }

            if (jsonResponse.error == 2) // SESSION EXPIRED
                window.location.href = '<?php echo base_url('Authentication'); ?>'

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

    });
</script>