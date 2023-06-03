<button type="button" id="btn-control-panel" class="btn btn-sm btn-primary"><i class="mdi mdi-application-cog"></i> Panel de Control</button>

<script>
    $('#btn-control-panel').on('click', function () {
        window.location.href = "<?php echo base_url('Main');?>";
    });
</script>