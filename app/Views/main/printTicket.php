<div class="row">
    <div class="col-12 text-center">
        <h4>TPV BARBER</h4>
        <p>Empleado: <br> <?php echo $ticket['user']; ?></p>
    </div>
</div>
<div class="row mt-5">
    <div class="col-12">
        <table style="border: none;" align="center">
            <?php
            $totalProduct = sizeof($ticket['product']);
            for ($i = 0; $i < $totalProduct; $i++) {
            ?>
                <tr>
                    <td><?php echo $ticket['product'][$i]['name']; ?></td>
                    <td><?php echo '€ ' . number_format((float) $ticket['product'][$i]['cost'], 2, ".", ','); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

</div>
<div class="row mt-5">
    <div class="col-12 text-center">
        <p>Total : <?php echo '€ ' . number_format((float) $ticket['total'], 2, ".", ','); ?></p>
        <p>Tipo de Pago: <br> <?php echo $ticket['payType']; ?></p>
        <p>Fecha: <br> <?php echo $ticket['date']; ?></p>
        <h4>Gracias por su visita!</h4>
    </div>
</div>

<script>
    $(document).ready(function() {
        window.print();
        window.location.reload();
    });
</script>