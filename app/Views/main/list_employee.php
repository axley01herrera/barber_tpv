<div class="row mt-5">
    <div class="col-12 ">
        <h1 class="text-primary">
           Listado de Empleados
        </h1>
    </div>
    <div class="col-12">
        <?php echo view('main/component/btn_control_panel');?>
        <button id="btn-create" class="btn btn-sm btn-success">Crear Empleado</button>
    </div>
</div>
<div class="card mt-5">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th class="text-center">Role</th>
                        <th class="text">Desactivar / Activar</th>
                        <th class=""></th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>

    $('#btn-create').on('click', function () { // CREATE EMPLOYEE

        $.ajax({

            type: "post",
            url: "<?php echo base_url('Main/showModalEmployee');?>",
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
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: { url: '<?php echo base_url('assets/libs/dataTable/es.json');?>'},
        ajax: {
            url: "<?php echo base_url('Main/processingEmployee');?>",
            type: "POST"
        },
        order: [[0, 'asc']],
        columns: [
            {data: 'name'},
            {data: 'lastName'},
            {data: 'email'},
            {data: 'role', class: 'text-center', searchable: false},
            {data: 'actionStatus', orderable: false, searchable: false},
            {data: 'status', orderable: false, searchable: false},
            {data: 'actionClave', class: 'text-center', orderable: false, searchable: false}
        ],
    });

    dataTable.on('click', '.switch_active_inactive', function (event) { // ACTIVE OR INACTIVE USER

        let data_role = $(this).attr('data-role');

        if(data_role == 1)
            showAlertForbidenChangeStatus('No se puede cambiar el estado de un usuario administrador');
        else
        {
            event.preventDefault();
            let user_logged_id = "<?php echo $user_logged_id;?>";
            let userID = $(this).attr('data-id'); 
    
            if(user_logged_id == userID)
            {
                event.preventDefault();
                showAlertForbidenChangeStatus('No se puede cambiar el estado del usuario logueado');
            }
            else
            {
                let status = $(this).attr('data-status');
                let newStatus = '';
                
                if(status == 0)
                    newStatus = 1;
                else if(status == 1)
                    newStatus = 0;
                
                $.ajax({
        
                    type: "post",
                    url: "<?php echo base_url('Main/changeUserStatus');?>",
                    data: {
                        'userID' : userID,
                        'status' : newStatus
                    },
                    dataType: "json",
                    
                }).done(function(jsonResponse) { console.log(jsonResponse)
        
                    if(jsonResponse.error == 0) // CASE SUCCESS
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
                    }
                    else // CASE ERROR
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
                            title:  jsonResponse.msg
                        });
                    }
        
                    if(jsonResponse.error == 2) // SESSION EXPIRED
                        window.location.href = '<?php echo base_url('Authentication');?>'
        
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
            }
        }

    });

    dataTable.on('click', '.btn-actions-clave', function (event) { // SET OR UPDATE CLAVE

        event.preventDefault();

        $.ajax({

            type: "post",
            url: "<?php echo base_url('Main/showModalSetClave');?>",
            data: {
                'userID': $(this).attr('data-id'),
                'action': $(this).attr('data-action'),
            },
            dataType: "html",
            
        }).done(function(htmlResponse){

            $('#main-modal').html(htmlResponse);

        }).fail(function(error) {

        });
    });

    function showAlertForbidenChangeStatus(msg) {

        event.preventDefault();

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
            title: msg
        });
    }

</script>


