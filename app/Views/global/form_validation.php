<script>
    function checkRequiredValues(className) {
       
        let response = 0;
        let value = "";
        let inputID = "";

        $("." + className).each(function() {

            value = $(this).val();

            if(value === "")
            {
                let selectContainer = $(this).next('.select2-container');

                if(selectContainer.length != 0) // CASE THE INPUT IS A SELECT 2
                {
                    selectContainer.css('border', '1px solid #f34e4e');
                    selectContainer.css('border-radius', '.25rem');
                }
                else
                    $(this).addClass("is-invalid");

                inputID = $(this).attr("id");
                $('#msg-' + inputID).html("Campo Requerido");
                response = 1;
            }
        });

        return response;
    }

    function checkEmailFormat(className) {
        
        let inputValue = '';
        let response = 0;
        let regex =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
        let resulTest = "";
        let inputID = "";

        $("." + className).each(function() {

            inputValue = $(this).val();

            if(inputValue != "") {

                resulTest = regex.test(inputValue);

                if(resulTest == false) {

                    $(this).addClass('is-invalid');
                    inputID = $(this).attr("id");
                    $('#msg-' + inputID).html("Email no válido");
                    response = 1;
                }
            }
        });

        return response;
    }

    $('.focus').on('focus change', function () {
       
        $(this).removeClass('is-invalid');

        let inputID = $(this).attr("id");
        $('#msg-' + inputID).html("");

    });
</script>