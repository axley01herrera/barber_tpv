<div class="row">
    <div class="col-12 text-center">
        <h4>TPV BARBER</h4>
    </div>
</div>
<div class="row mt-5">
    <div class="col-12">
        <table style="border: none;" align="center">
            <?php 
                $total = 0;
                for($i = 0; $i < sizeof($ticket); $i++) {
                    $total = $total + $ticket[$i]->cost;
            ?>
                    <tr>
                        <td><?php echo $ticket[$i]->name;?></td>
                        <td><?php echo '€ ' . number_format((float) $ticket[$i]->cost, 2, ".", ','); ?></td>
                    </tr>
            <?php }?>
        </table>
    </div>
    
</div>
<div class="row mt-5">
    <div class="col-12 text-center">
    <p>Total : <?php echo '€ ' . number_format((float) $total, 2, ".", ','); ?></p>
        <h4>Gracias por su visita!</h4>
    </div>
</div>

<script>
    $(document).ready(function () {
        window.print();
        window.location.reload();
    });
</script>