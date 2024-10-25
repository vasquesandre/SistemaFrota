function validarNumero(input) {
    input.value = input.value.replace(/\D/g, '');
}

function verificarCamposPreenchidos() {
    var veiculo = $('#meusVeiculos').val();
    var km = $('#km').val();
    var destino = $('#destino').val();

    if (veiculo !== '' && km !== '' && destino !== '') {
        $('#iniciarViagemBtn').prop('disabled', false);
    } else {
        $('#iniciarViagemBtn').prop('disabled', true);
    }
}

$('#meusVeiculos, #km, #destino').on('input', verificarCamposPreenchidos);

function iniciarViagem(latlong) {
    var veiculo = document.getElementById("meusVeiculos").value;
    var km = document.getElementById("km").value;
    var destino = document.getElementById("destino").value;

    $.ajax({
        url: 'processa_iniciar_viagem.php',
        dataType: "json",
        method: 'POST',
        data: { veiculo: veiculo, km: km, destino: destino, latlong: latlong },
        success: function (response) {
            var toastMessage = response.message;

            if (response.status === "success") {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
                $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
                $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

                var iniciarViagemBtn = $('#iniciarViagemBtn');
                iniciarViagemBtn.removeClass("btn-primary").addClass("btn-danger");

                var iniciarViagemBtnAClass = $('#iniciarViagemBtnAClass');
                iniciarViagemBtnAClass.removeAttr('onclick').attr('href', 'finalizar_viagem.php');
                iniciarViagemBtnAClass.text("Finalizar Viagem");

                $('#meusVeiculos').prop('disabled', true);
                $('#km').prop('disabled', true);
                $('#destino').prop('disabled', true);

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
        error: function (xhr, status, error) {
            console.error("Erro ao iniciar a viagem: " + error);
        }
    });
}