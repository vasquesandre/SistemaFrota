$(document).ready(function () {
    var switchPlaca = $('#flexSwitchCheckChecked');
    var inputPlaca = $('#placa_veiculo');

    switchPlaca.change(function () {
        if (this.checked) {
            inputPlaca.inputmask('AAA-9A99');
        } else {
            inputPlaca.inputmask('AAA-9999');
        }
    });

    inputPlaca.inputmask('AAA-9A99');

    inputPlaca.on('input', function () {
        var valorPlaca = inputPlaca.val();
        if (valorPlaca.indexOf('_') === -1) {
            verificarVeiculo();
        }
    });
});

function verificarVeiculo() {
    var placaVeiculo = $('#placa_veiculo').val();
    var sendBtn = $('#sendBtn');

    $.ajax({
        url: '../../../../sistemacarro/php/scriptsajax/verificarveiculo/verificar_veiculo.php',
        type: 'POST',
        data: {
            placaVeiculo: placaVeiculo
        },
        dataType: 'json',
        success: function (response) {

            if (response.status == "success") {
                var carData = response.message;

                if (carData.length > 0) {
                    var veiculo = carData[0];

                    $('#info').text("Foi encontrado um veículo com a placa " + veiculo.placa + ", modelo " + veiculo.modelo + ".");

                    sendBtn.prop('disabled', false);
                }
            } else {
                $('#info').text("Não foi encontrado nenhum veiculo com esta placa, peça a um supervisor para adicionar este veiculo.");

                sendBtn.prop('disabled', true);
            }
        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
    })
}

function enviarSolicitacaoVeiculo() {
    var placa = $("#placa_veiculo").val();

    var sendBtn = $('#sendBtn');

    $.ajax({
        url: 'enviar_vinculo_veiculo.php',
        type: 'POST',
        data: {
            placa: placa
        },
        dataType: 'json',
        success: function (response) {
            var toastMessage = response.message;

            if (response.status === "success") {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
                $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
                $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

                $("#placa_veiculo").val('');
                $("#info").val('');

                sendBtn.prop('disabled', true);
            } else if (response.status === "warning") {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Warning");
                $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-success").addClass("bg-warning");
                $(".toast-placement-ex .notif-icon").removeClass("bx-check").removeClass("bx-x").addClass("bx-error");

                sendBtn.prop('disabled', false);
            } else {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Error");
                $(".toast-placement-ex").removeClass("bg-success").removeClass("bg-warning").addClass("bg-danger");
                $(".toast-placement-ex .notif-icon").removeClass("bx-check").removeClass("bx-edit-alt").addClass("bx-x");

                sendBtn.prop('disabled', false);
            }

            $(".toast-placement-ex .toast-body").text(toastMessage);

            $("#showToastPlacement").click();
        },
        error: function (error) {
            console.log(JSON.stringify(error))
        }
    })
}