function enviarProblema() {
    var textoProblema = $("#textoProblema").val().trim();

    $.ajax({
        url: '../../../../sistemacarro/php/scriptsajax/relatarbug/relatar_bug.php',
        type: 'POST',
        data: {
            textoProblema: textoProblema
        },
        dataType: 'json',
        success: function (response) {
            var toastMessage = response.message;

            if (response.status === "success") {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
                $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
                $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

                $("#textoProblema").val('');
                checarTexto();
            } else {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Error");
                $(".toast-placement-ex").removeClass("bg-success").removeClass("bg-warning").addClass("bg-danger");
                $(".toast-placement-ex .notif-icon").removeClass("bx-check").removeClass("bx-edit-alt").addClass("bx-x");
            }

            $(".toast-placement-ex .toast-body").text(toastMessage);

            $("#showToastPlacement").click();
        },
        error: function (error) {
            console.log(JSON.stringify(error))
        }
    })
}

function checarTexto() {
    var texto = $('#textoProblema').val();
    var contar = $('#caracteres');
    var btn = document.getElementById('problemBtn');

    if (texto.length > 0 && texto.length < 501) {
        contar.text(texto.length + "/500");
        btn.disabled = false;
    } else {
        contar.text(texto.length + "/500");
        btn.disabled = true;
    }
}