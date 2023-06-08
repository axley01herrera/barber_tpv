<div class="row">
    <div class="col-12 text-center">
        <h4>TPV BARBER</h4>
        <p>Empleado: <br> <?php echo $ticket['user'][0]->name.' '.$ticket['user'][0]->lastName; ?></p>
    </div>
</div>
<div class="row mt-5">
    <div class="col-12">
        <table style="border: none;" align="center">
            <?php
            $total = 0;
            for ($i = 0; $i < sizeof($ticket['products']); $i++) {
                $total = $total + $ticket['products'][$i]->cost;
            ?>
                <tr>
                    <td><?php echo $ticket['products'][$i]->name; ?></td>
                    <td><?php echo '€ ' . number_format((float) $ticket['products'][$i]->cost, 2, ".", ','); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

</div>
<div class="row mt-5">
    <div class="col-12 text-center">
        <p>Total : <?php echo '€ ' . number_format((float) $total, 2, ".", ','); ?></p>
        <p>Tipo de Pago: <br> <?php echo $ticket['payType']; ?></p>
        <h4>Gracias por su visita!</h4>
    </div>
</div>

<script>
    $(document).ready(function() {
        window.print();
        window.location.reload();
    });
</script>