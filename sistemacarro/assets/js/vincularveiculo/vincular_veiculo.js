var currentPage = window.location.pathname;

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

function modalVincularVeiculoUsuario() {
    var modal = $('#modalVincularVeiculo');

    modal.find('.modal-title').text("Digite a placa do veículo e a matrícula.");

    modal.modal('show');

    buscarNome();
}

var veiculoTrue = false;
var matriculaTrue = false;

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

            if (response.status == "success") {
                var carData = response.message;

                if (carData.length > 0) {
                    var veiculo = carData[0];

                    $('#modelo_veiculo').val(veiculo.modelo);
                    $('#veiculoEncontrado').text("Foi encontrado um veiculo com a placa " + veiculo.placa + ", modelo: " + veiculo.modelo + ".");

                    if (currentPage.includes("supervisor/solicitacoes/solicitacoes.php")) {
                        var secretariaVeiculo = document.getElementById("secretaria_veiculo");

                        secretariaVeiculo.disabled = false;
                    } else {
                        veiculoTrue = true;
                        verificarTrue();
                    }
                }
            } else {
                $('#modelo_veiculo').val('');
                $('#veiculoEncontrado').text("Não foi encontrado nenhum veiculo com esta placa.");

                if (currentPage.includes("supervisor/solicitacoes/solicitacoes.php")) {
                    var secretariaVeiculo = document.getElementById("secretaria_veiculo");

                    secretariaVeiculo.disabled = true;
                } else {
                    veiculoTrue = false;
                    verificarTrue();
                }
            }
        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
    })
}

function verificarTrue() {
    if (veiculoTrue == true && matriculaTrue == true) {
        var placa = $('#placa_veiculo').val();
        var matricula = $('#matricula').val();

        var vincCarBtn = $('#vincCarBtn');

        vincCarBtn.off('click').on('click', function () {
            vincularVeiculoExistente(matricula, placa);
            $('#modalVincularVeiculo').modal('hide');
        });

    }
}

function vincularVeiculoExistente(matricula, index, token) {

    if (arguments.length === 2) {
        $.ajax({
            url: '../../../../sistemacarro/php/scriptsajax/vincularveiculo/vincular_veiculo_usuario.php',
            type: 'POST',
            data: {
                matricula: matricula,
                index: index
            },
            dataType: 'json',
            success: function (response) {
                var toastMessage = response.message;

                if (response.status === "success") {
                    $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
                    $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
                    $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

                    if (currentPage.includes("search/pesquisar_usuarios.php")) {
                        buscarVeiculosUsuario(matricula);
                    }
                } else if (response.status === "warning") {
                    $(".toast-placement-ex .toast-header .fw-semibold").text("Warning");
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
    } else if (arguments.length === 3) {
        console.log("3")
        $.ajax({
            url: '../../../../sistemacarro/php/scriptsajax/vincularveiculo/vincular_veiculo_usuario.php',
            type: 'POST',
            data: {
                matricula: matricula,
                index: index
            },
            dataType: 'json',
            success: function (response) {
                console.log("response")
                var toastMessage = response.message;

                if (response.status === "success") {
                    $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
                    $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
                    $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

                    if (currentPage.includes("admin/solicitacoes/solicitacoes.php")) {
                        solicitacaoResolvida(token);
                    } else if (currentPage.includes("search/pesquisar_usuarios.php")) {
                        buscarVeiculosUsuario(matricula);
                    }

                } else if (response.status === "warning") {
                    $(".toast-placement-ex .toast-header .fw-semibold").text("Warning");
                    $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-success").addClass("bg-warning");
                    $(".toast-placement-ex .notif-icon").removeClass("bx-check").removeClass("bx-x").addClass("bx-edit-alt");

                    setTimeout(function () {
                        solicitacaoResolvida(token);
                    }, 2000);
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
}