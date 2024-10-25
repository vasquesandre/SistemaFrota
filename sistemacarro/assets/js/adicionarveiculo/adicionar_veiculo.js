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

$(document).ready(function () {
    var modelo = $('#modelo_veiculo');
    var addCarBtn = $('#addCarBtn');

    modelo.on('input', function () {
        var modeloUpperCase = modelo.val().toUpperCase();
        modelo.val(modeloUpperCase);

        if (modelo.val() == '') {
            addCarBtn.prop('disabled', true);
        } else {
            addCarBtn.prop('disabled', false);
        }
    });
});

function modalAdicionarVeiculo() {
    var modal = $('#modalVeiculo');

    var placaVeiculo = modal.find('#placa_veiculo').val('');
    var modeloVeiculo = modal.find('#modelo_veiculo').val('');
    $('#veiculoEncontrado').text('');

    modal.find('.modal-title').text('Digite a placa e o modelo do veiculo.');

    modal.find('.btn-primary').off('click').on('click', function () {
        placaVeiculo.val();
        modeloVeiculo.val();
        adicionarVeiculoNovo(placaVeiculo, modeloVeiculo);
        modal.modal('hide');
    });

    modal.modal('show');
}

function verificarVeiculo() {
    var placaVeiculo = $('#placa_veiculo').val();

    $.ajax({
        url: '../../../../sistemacarro/php/scriptsajax/verificarveiculo/verificar_veiculo.php',
        type: 'POST',
        data: {
            placaVeiculo: placaVeiculo
        },
        dataType: 'json',
        success: function (response) {
            var modeloVeiculo = document.getElementById("modelo_veiculo");
            var addCarBtn = $('#addCarBtn');
            var tipoPerfil = $('#tipo_perfil').text();

            if (response.status == "success") {
                var carData = response.message;

                if (carData.length > 0) {
                    var veiculo = carData[0];

                    $('#modelo_veiculo').val(veiculo.modelo);
                    $('#veiculoEncontrado').text("Foi encontrado um veiculo com a placa " + veiculo.placa + ", confirme para adicionar ao seu usuário.");

                    addCarBtn.prop('disabled', false);
                    addCarBtn.off('click').on('click', function () {
                        vincularVeiculoExistente(veiculo.id_veiculo);
                        $('#modalVeiculo').modal('hide');
                    });
                }
            } else {
                if (tipoPerfil == "Usuário Padrão") {
                    modeloVeiculo.disabled = true;
                    $('#modelo_veiculo').val('');
                    $('#veiculoEncontrado').text("Não foi encontrado nenhum veiculo com esta placa, peça a um supervisor para adicionar este veiculo.");
                } else {
                    $('#modelo_veiculo').val('');
                    $('#veiculoEncontrado').text("Não foi encontrado nenhum veiculo com esta placa, digite o modelo para adicionar.");

                    modeloVeiculo.disabled = false;
                    addCarBtn.off('click').on('click', function () {
                        var placa = $('#placa_veiculo').val();
                        var modelo = $('#modelo_veiculo').val();
                        adicionarVeiculoNovo(placa, modelo);
                        $('#modalVeiculo').modal('hide');
                    });
                }
            }
        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
    })
}

function adicionarVeiculoNovo(placa, modelo) {
    $.ajax({
        url: '../../../../sistemacarro/php/scriptsajax/adicionarveiculo/adicionar_veiculo.php',
        type: 'POST',
        data: {
            placa: placa,
            modelo: modelo
        },
        dataType: 'json',
        success: function (response) {
            var toastMessage = response.message;

            if (response.status === "success") {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
                $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
                $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

                var btnBuscarVeiculos = $('button[data-bs-target="#veiculos"]');
                btnBuscarVeiculos.click();
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
            console.log(JSON.stringify(error))
        }
    })
}