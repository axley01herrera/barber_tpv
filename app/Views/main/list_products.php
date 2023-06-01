<div class="row mt-5">
    <div class="col-12 ">
        <h1 class="text-primary">
           Listado de Productos
        </h1>
    </div>
    <div class="col-12">
        <?php echo view('main/component/btn_control_panel');?>
        <button id="btn-createProducts" class="btn btn-sm btn-success">Añadir Productos</button>
    </div>
</div>
<div class="card mt-5">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio <span class="text-muted fst-italic">(EUR)</span></th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>

$('#btn-createProducts').on('click', function () { // CREATE PRODUCT

$.ajax({

    type: "post",
    url: "<?php echo base_url('Main/showModalProducts');?>",
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
            url: "<?php echo base_url('Main/processingProducts');?>",
            type: "POST"
        },
        order: [[0, 'asc']],
        columns: [
            {data: 'name'},
            {data: 'cost'},
            {data: 'edit'},
        ],
    });

    dataTable.on('click', '.btn-editProduct', function (event) { // SET OR UPDATE CLAVE

    event.preventDefault();

    $.ajax({

        type: "post",
        url: "<?php echo base_url('Main/showModalProducts');?>",
        data: {
            'userID': $(this).attr('data-id'),
            'action': 'update'
        },
        dataType: "html",
        
    }).done(function(htmlResponse){

        $('#main-modal').html(htmlResponse);

    }).fail(function(error) {

    });
    });
    
</script>