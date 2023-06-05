<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <!-- TITLE -->
                <h5 class="modal-title" id="staticBackdropLabel"><?php echo $title; ?></h5>
                <!-- CLOSE -->
                <button type="button" class="btn-close closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 text-center">
                        <input id="radio-e" type="radio" class="radio-payType" name="radio-payType" value="1" /> Efectivo
                    </div>
                    <div class="col-6 text-center">
                        <input id="radio-t" type="radio" class="radio-payType" name="radio-payType" value="2" /> Tarjeta
                    </div>

                </div>
            </div>
            <?php echo view('modals/footer'); ?>
        </div>
    </div>
</div>

<script>
    var paymentType = '<?php echo @$type; ?>';
    var type = '<?php echo @$type; ?>';

    if (type != '') {

        switch (Number(type)) {

            case 1:
                $('#radio-e').trigger('click');
                break;

            case 2:
                $('#radio-t').trigger('click');
                break;

        }
    }

    $('.radio-payType').on('click', function() {
        paymentType = $(this).val();
    });

    $('#btn-modal-submit').on('click', function() {

        if (paymentType != '') {

            $('#btn-modal-submit').attr('disabled', true);

            $.ajax({
                type: "post",
                url: "<?php echo base_url('Main/updateBasket') ?>",
                data: {
                    'basketID': '<?php echo $basketID; ?>',
                    'total': '<?php echo $total; ?>',
                    'payType': paymentType
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

                    let from = $('#main-content').attr('data-value');

                    if (from == 'tpv')
                        window.location.href = "<?php echo base_url('Main/employee'); ?>" + "/<?php echo $userID; ?>";
                    if (from == 'employeeDetail') {
                        dataTable.draw();
                        closeModal();
                    }

                } else if (jsonResponse.error == 1) // ERROR
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
            });

            Toast.fire({
                icon: 'error',
                title: 'Debe seleccionar un metodo de pago'
            });
        }

    });
</script>