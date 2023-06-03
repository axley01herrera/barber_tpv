<div class="card">
    <div class="card-body">
        <h5 class="text-center mb-2"><i class="mdi mdi-clipboard-edit-outline"></i> Ticket</h5>
        <div class="scrollable-div-basket">
            <?php
            $total = 0;
            for ($i = 0; $i < $countBasketView; $i++) {

                $total = $total + (int) $basketView[$i]->productCost;
            ?>
                <div class="alert alert-secondary alert-top-border fade show" role="alert">
                    <div class="row">
                        <div class="col-4"><span><?php echo $basketView[$i]->productName; ?></span></div>
                        <div class="col-4"><span><?php echo '€ ' . number_format((float) $basketView[$i]->productCost, 2, ".", ','); ?></span></div>
                        <div class="col-4 text-end">
                            <button class="btn btn-sm btn-soft-danger delete-item-basket" data-id="<?php echo $basketView[$i]->basketproductID; ?>">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 text-end">
        <h4 id="basket-total" class="m-0 fw-semibold text-light">Total: <?php echo '€ ' . number_format((float) $total, 2, ".", ','); ?></h4>
    </div>
    <div class="col-12 text-end">
        <button type="button" id="btn-charge" class="btn btn-sm btn-success">Cobrar</button>
    </div>
</div>

<script>
    $('.delete-item-basket').on('click', function() { // DELETE

        $.ajax({

            type: "post",
            url: "<?php echo base_url('Main/deleteBasketProduct'); ?>",
            data: {
                'id': $(this).attr('data-id')
            },
            dataType: "json",

        }).done(function(jsonResponse) {

            if (jsonResponse.error == 0) { // SUCCESS

                loadBasket();
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
            } else if (sonResponse.error == 1) { // ERROR
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

    });

    $('#btn-charge').on('click', function() { // CHARGE

        console.log('click');
        let total = <?php echo $total; ?>;

        if (Number(total) > 0) {

            $('#btn-charge').attr('disabled', true);

                $.ajax({
                    type: "post",
                    url: "<?php echo base_url('Main/showModalSelectPayMethod');?>",
                    data: {
                        'basketID': basketID,
                        'total': total,
                        'action': 'create',
                    },
                    dataType: "html",

                    success: function (htmlResponse) {
                        $('#btn-charge').removeAttr('disabled');
                        $('#main-modal').html(htmlResponse);
                    }
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
                title: 'Debe añdir productos a su ticket'
            });
        }

    });
</script>