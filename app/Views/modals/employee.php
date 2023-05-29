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
                        <label for="txt-lastName">Apellido</label>
                        <input id="txt-lastName" type="text" class="form-control modal-required focus">
                        <p id="msg-txt-lastName" class="text-danger text-end"></p>
                    </div>
                    <div class="col-12 ">
                        <label for="txt-email">Email</label>
                        <input id="txt-email" type="text" class="form-control modal-required focus modal-email">
                        <p id="msg-txt-email" class="text-danger text-end"></p>
                    </div>
                    <div class="col-12 ">
                        <label for="sel-role">Role</label>
                        <select id="sel-role" class="form-select modal-required focus">
                            <option value="" hidden></option>
                            <option value="1">Administrador</option>
                            <option value="2">Básico</option>
                        </select>
                        <p id="msg-sel-role" class="text-danger text-end"></p>
                    </div>

                    <div class="col-12 ">
                        <div class="alert alert-warning">
                            <div>
                                <span>Role <strong>Administrador</strong> acceso total al sistema.</span>
                                <br>
                                <span>Role <strong>Básico</strong> acceso al TPV.</span>
                            </div>
                        </div>
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
        let resultCheckEmailFormat = checkEmailFormat('modal-email');

        if(resultCheckRequiredValues == 0 && resultCheckEmailFormat == 0)
        {
            $.ajax({

                type: "post",
                url: "<?php echo base_url('Main/createEmployee');?>",
                data: {
                    'name': $('#txt-name').val(),
                    'lastName': $('#txt-lastName').val(),
                    'email': $('#txt-email').val(),
                    'role': $('#sel-role').val(),
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

                
                if(jsonResponse.error == 3)
                    $("#txt-email").addClass('is-invalid');
                    
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