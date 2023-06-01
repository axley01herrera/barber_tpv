<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <!-- TITLE -->
                <h5 class="modal-title" id="staticBackdropLabel"><?php echo $title;?></h5>
                <!-- CLOSE -->
                <button type="button" class="btn-close closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 mt-2">
                        <label for="txt-name">Nombre</label>
                        <input id="txt-name" type="text" class="form-control modal-required focus">
                        <p id="msg-txt-name" class="text-danger text-end"></p>
                    </div>
                    <div class="col-12 ">
                        <label for="txt-cost">Precio</label>
                        <input id="txt-cost" type="text" class="form-control modal-required focus modal-email" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                        <p id="msg-txt-cost" class="text-danger text-end"></p>
                    </div>
                </div>
            </div>
            <?php echo view('modals/footer');?>
        </div>
    </div>
</div>

<script>

    $('#btn-modal-submit').on('click', function () { // SUBMIT
        
        let resultCheckRequiredValues = checkRequiredValues('modal-required');

        if(resultCheckRequiredValues == 0)
        {
            $.ajax({

                type: "post",
                url: "<?php echo base_url('Main/createProducts');?>",
                data: {
                    'name': $('#txt-name').val(),
                    'cost': $('#txt-cost').val(),
                },
                dataType: "json",
                
            }).done(function(jsonResponse) { console.log(jsonResponse)

                if(jsonResponse.error == 0) // SUCCESS
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

                    closeModal();

                }
                else // ERROR
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

                if(jsonResponse.error == 2) // SESSION EXPIRED
                    window.location.href = "<?php echo base_url('Authentication');?>";

                    
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
        }
    });

</script>