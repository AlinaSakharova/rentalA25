$(document).ready(function() {
    var form = $('#form');
    form.submit(function(event) {
        event.preventDefault();
        var days = $('#customRange1').val();
        const regex2 = new RegExp('/^[1-9]\d*$');
        console.log(regex2);
        $("#error").remove();
        if (!regex2 || days == 0) {
            $('#customRange1').after("<span class='alert alert-danger d-flex align-items-center' id='error'>Некорректный ввод</span>");
            return false;
        }
        $.ajax({
            url: 'backend/form.php',
            type: 'POST',
            data: form.serialize(), // Передаём данные
            success: function(response) {
                var result = jQuery.parseJSON(response);
                $("#form_answer").html('Итого: ' + result.total);
            },
        });
    })
});