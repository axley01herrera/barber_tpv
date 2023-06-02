<div class="card">
    <div class="card-body">
        <h5 class="text-center mb-2"><i class="mdi mdi-clipboard-edit-outline"></i> Ticket</h5>
        <div class="scrollable-div-basket">
            <?php
            $total = 0;
            for ($i = 0; $i < $count_basket; $i++) {

                $total = $total + (int) $basket[$i]->product_cost;
            ?>
                <div class="alert alert-secondary alert-top-border alert-dismissible fade show" role="alert">
                    <div class="row">
                        <div class="col-4"><span><?php echo $basket[$i]->product_name; ?></span></div>
                        <div class="col-4"><span><?php echo '€ ' . number_format((float) $basket[$i]->product_cost, 2, ".", ','); ?></span></div>
                        <div class="col-4 text-end">
                            <button class="btn btn-sm btn-soft-danger delete-item-basket" data-product-id="<?php echo $basket[$i]->product_id; ?>" data-basket-id="<?php echo $basket[$i]->basket_id; ?>">
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
        <h4 id="basket-total" class="m-0 fw-semibold">Total: <?php echo '€ ' . number_format((float) $total, 2, ".", ','); ?></h4>
    </div>
    <div class="col-12 text-end">
        <button class="btn btn-sm btn-success">Cobrar</button>
    </div>
</div>

<script>
    $('.delete-item-basket').on('click', function() {

        $.ajax({

            type: "post",
            url: "<?php echo base_url('Main/deleteBasketProduct'); ?>",
            data: {
                'basket_id': $(this).attr('data-basket-id'),
                'product_id': $(this).attr('data-product-id')
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
</script>