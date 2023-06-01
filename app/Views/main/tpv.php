<style>
    .cardStyle {
        transition: transform 0.3s;
        cursor: pointer;
    }

    .cardStyle:hover {
        transform: scale(1.03);
        border: 2px solid rgba(3, 142, 220, 1);
    }
</style>
<div class="row mt-5">
    <div class="col-12 ">
        <h1 class="text-primary">
            TPV
        </h1>
    </div>
    <div class="col-12">
        <?php echo view('main/component/btn_control_panel'); ?>
    </div>
</div>

<div class="row mt-5">

    <div id="main-basket" class="col-12 col-lg-4"></div>
    <div id="main-products" class="col-12 col-lg-8"></div>

</div>

<script>

    var basket_id = <?php echo $basket_id;?>; console.log(basket_id);

    loadBasket();
    loadProducts();

    function loadBasket() {

        $.ajax({

            type: "post",
            url: "<?php echo base_url('Main/returnBasket'); ?>",
            data: {
                'basket_id': basket_id
            },
            dataType: "html",

        }).done(function(htmlResponse) {

            $('#main-basket').html(htmlResponse);

        });
    }

    function loadProducts() {

        $.ajax({

            type: "post",
            url: "<?php echo base_url('Main/returnProducts'); ?>",
            dataType: "html",

        }).done(function(htmlResponse) {

            $('#main-products').html(htmlResponse);

        });
    }

</script>