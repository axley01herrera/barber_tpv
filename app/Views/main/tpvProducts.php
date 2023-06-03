<div class="row">
    <?php
    for ($i = 0; $i < $count_products; $i++) {
    ?>

        <div class="col-12 col-lg-4 product-item" data-product-id="<?php echo $products[$i]->id; ?>">
            <div class="card cardStyle">
                <!-- <img class="card-img-top img-fluid" src="assets/images/small/img-1.jpg" alt="Card image cap"> -->
                <div class="card-body">
                    <h5 class="text-center mb-1"><?php echo $products[$i]->name; ?></h5>
                    <div class="text-center">
                        <p class="card-text text-center">
                        <h3 class="text-center"><?php echo '€ ' . number_format((float) $products[$i]->cost, 2, ".", ','); ?></h3>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }
    ?>
</div>

<script>
    $('.product-item').on('click', function() {

        $.ajax({

            type: "post",
            url: "<?php echo base_url('Main/createBasketProduct'); ?>",
            data: {
                'basketID': basketID,
                'productID': $(this).attr('data-product-id')
            },
            dataType: "json",

        }).done(function(jsonResponse) {

            if (jsonResponse.error == 0) {

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