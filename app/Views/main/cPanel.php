<style>
    .card {
        transition: transform 0.3s;
    }
    .card:hover {
        transform: scale(1.03);
        border: 2px solid rgba(3, 142, 220, 1);
    }
</style>
<div class="container">
    <div class="row mt-5">
        <div class="col-12 text-center">
            <h1 class="text-primary">
               <i class="mdi mdi-application-cog"></i> Panel de Control
            </h1>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-12 col-lg-4 mt-5">
            <a href="<?php echo base_url('Main/listEmployee');?>">
                <div class="card">
                    <div class="mt-2">
                        <img class="card-img-top img-fluid" src="<?php echo base_url('assets/images/small/img-1.jpg')?>" alt="Card image cap">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h4 class="card-title mb-2">Empleados</h4> 
                            </div>
                        </div>
    
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-lg-4 mt-5">
            <a href="<?php echo base_url('Main/listProduct');?>">
                <div class="card">
                    <div class="mt-2">
                        <img class="card-img-top img-fluid" src="<?php echo base_url('assets/images/small/img-2.jpg')?>" alt="Card image cap">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h4 class="card-title mb-2">Productos</h4> 
                            </div>
                        </div>
    
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-lg-4 mt-5">
            <a href="<?php echo base_url('Main/tpv');?>">
                <div class="card">
                    <div class="mt-2">
                        <img class="card-img-top img-fluid" src="<?php echo base_url('assets/images/small/img-3.jpg')?>" alt="Card image cap">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h4 class="card-title mb-2">TPV</h4> 
                            </div>
                        </div>
    
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>