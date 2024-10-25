$(document).ready(function() {
    startLocationUpdate();
})

function verificarCamposPreenchidos() {
    var km = $('#kmFinal').val();

    if (km !== '') {
        $('#finalizarViagemBtn').prop('disabled', false);
    } else {
        $('#finalizarViagemBtn').prop('disabled', true);
    }
}

$('#kmFinal').on('input', verificarCamposPreenchidos);

function finalizarViagem() {
    var kmFinal = $('#kmFinal').val();

    $.ajax({
        url: 'processa_finalizar_viagem.php',
        type: 'POST',
        data: {
            kmFinal: kmFinal
        },
        dataType: 'json',
        success: function (response) {
            var toastMessage = response.message;

            if (response.status === "success") {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
                $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
                $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

                setTimeout(function() {
                    window.location.href = 'iniciar_viagem.php';
                }, 3000);
            } else if (response.status === "warning") {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Campo em branco");
                $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-success").addClass("bg-warning");
                $(".toast-placement-ex .notif-icon").removeClass("bx-check").removeClass("bx-x").addClass("bx-edit-alt");
            } else {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Error");
                $(".toast-placement-ex").removeClass("bg-success").removeClass("bg-warning").addClass("bg-danger");
                $(".toast-placement-ex .notif-icon").removeClass("bx-check").removeClass("bx-edit-alt").addClass("bx-x");
            }

            $(".toast-placement-ex .toast-body").text(toastMessage);

            $("#showToastPlacement").click();
        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
    })
}