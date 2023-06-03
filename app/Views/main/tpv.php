<style>
    .cardStyle {
        transition: transform 0.3s;
        cursor: pointer;
    }

    .cardStyle:hover {
        transform: scale(1.03);
        border: 2px solid rgba(3, 142, 220, 1);
    }
    .scrollable-div {
        height: 600px; 
        overflow-y: scroll;
    }
    .scrollable-div-basket {
        height: 500px; 
        overflow-y: scroll;
    }
</style>

<div id="main-content" data-value="tpv" class="container">
    <div class="row mt-5">
        <div class="col-12 ">
            <h1 class="text-primary">
                TPV
            </h1>
        </div>
        <div class="col-12">
            <?php echo view('main/component/btnControlPanel'); ?>
        </div>
    </div>
    
    <div class="row">
    
        <div id="main-basket" class="col-12 col-lg-4 mt-5"></div>
        <div id="main-products" class="col-12 col-lg-8 mt-5"></div>
    
    </div>
</div>

<script>
    var basketID = <?php echo $basketID; ?>;

    loadBasket();
    loadProducts();

    function loadBasket() {

        $.ajax({

            type: "post",
            url: "<?php echo base_url('Main/returnBasket'); ?>",
            data: {
                'basketID': basketID
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