<div class="container">
    <div class="row mt-5">
        <div class="col-12 text-center">
            <h1 class="text-primary">
               <i class="mdi mdi-application-cog"></i> Panel de Control
            </h1>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12 text-end">
            <!-- BTN LOGOUT -->
            <?php echo view('main/component/btnLogout');?>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-12 col-lg-4 mt-5">
            <!-- NAV EMPLOYEE -->
            <?php echo view('main/component/navEmployee');?>
        </div>
        <div class="col-12 col-lg-4 mt-5">
            <!-- NAV PRODUCTS -->
            <?php echo view('main/component/navProducts');?>
        </div>
        <div class="col-12 col-lg-4 mt-5">
            <!-- NAV TPV -->
            <?php echo view('main/component/navTPV');?>
        </div>
    </div>
</div>