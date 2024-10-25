document.addEventListener('DOMContentLoaded', function () {
    carregarNaoResolvidos();
});

function carregarNaoResolvidos() {
    $.ajax({
        url: 'carregar_nao_resolvidos.php',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            var tabelaIdSetor = '#tabelaVeiculoNaoResolvido';
            var tabelaSetor = $(tabelaIdSetor + ' tbody');
            tabelaSetor.empty();

            if (response.length > 0) {
                $.each(response, function (index, solicitacao) {

                    var linha = '<tr>' +
                        '<td data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="' +
                        '<span>Matrícula: ' + solicitacao.matricula + '</span>"><strong>' + solicitacao.nome + '</strong></td>' +
                        '<td>' + solicitacao.nome_setor + '</td>' +
                        '<td>' + solicitacao.veiculo + '</td>' +
                        '<td>' + solicitacao.data_solicitacao + '</td>' +
                        '<td>' +
                        '<div class="dropdown">' +
                        '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                        '<i class="bx bx-dots-vertical-rounded"></i>' +
                        '</button>' +
                        '<div class="dropdown-menu">' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="vincularVeiculoExistente(' + solicitacao.matricula + ', ' + solicitacao.texto + ')"><i class="bx bx-layer-plus me-1"></i>Vincular</a>' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="solicitacaoResolvida(' + solicitacao.id_solicitacao + ')"><i class="bx bx-check me-1"></i>Resolvido</a>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '</tr>';
                    tabelaSetor.append(linha);

                    $('[data-bs-toggle="tooltip"]').tooltip();

                });
            } else {
                tabelaSetor.append('<tr><td colspan="4">Nenhum resultado encontrado</td></tr>');
            }
        },
        error: function (error) {
            console.log("Erro na solicitação AJAX: ", error);
        }
    });
}


function carregarResolvidos() {
    $.ajax({
        url: 'carregar_resolvidos.php',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            var tabelaIdSetor = '#tabelaVeiculoResolvido';
            var tabelaSetor = $(tabelaIdSetor + ' tbody');
            tabelaSetor.empty();

            if (response.length > 0) {
                $.each(response, function (index, solicitacao) {

                    var linha = '<tr>' +
                        '<td data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="' +
                        '<span>Matrícula: ' + solicitacao.matricula + '</span>"><strong>' + solicitacao.nome + '</strong></td>' +
                        '<td>' + solicitacao.nome_setor + '</td>' +
                        '<td>' + solicitacao.veiculo + '</td>' +
                        '<td>' + solicitacao.data_solicitacao + '</td>' +
                        '</tr>';
                    tabelaSetor.append(linha);

                    $('[data-bs-toggle="tooltip"]').tooltip();

                });
            } else {
                tabelaSetor.append('<tr><td colspan="4">Nenhum resultado encontrado</td></tr>');
            }
        },
        error: function (error) {
            console.log("Erro na solicitação AJAX: ", error);
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    buscarSecretarias();
});

function buscarSecretarias() {
    $.ajax({
        url: '../../admin/viagens/buscar_secretarias.php',
        type: 'POST',
        success: function (response) {
            $('#secretaria').empty();
            $('#secretaria').append('<option value="default" selected>Selecione a Secretaria</option>');
            $('#secretaria').append(response);

            $('#secretaria_veiculo').empty();
            $('#secretaria_veiculo').append('<option value="default" selected>Selecione a Secretaria</option>');
            $('#secretaria_veiculo').append(response);
        }
    });
}

function enviarSolicitacaoSetor() {
    var matricula = $("#matricula").val().trim();
    var secretaria = $("#secretaria").val();
    var setor = $("#setor").val();

    $.ajax({
        url: 'enviar_alteracao_setor.php',
        type: 'POST',
        data: {
            matricula: matricula,
            secretaria: secretaria,
            setor: setor
        },
        dataType: 'json',
        success: function (response) {
            var toastMessage = response.message;

            if (response.status === "success") {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
                $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
                $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

                $("#matricula").val('');
                $("#nomeEncontrado").text('');
                $("#secretaria").val('default');
                $("#setor").val('default');

                selecionarSetor();
            } else {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Error");
                $(".toast-placement-ex").removeClass("bg-success").removeClass("bg-warning").addClass("bg-danger");
                $(".toast-placement-ex .notif-icon").removeClass("bx-check").removeClass("bx-edit-alt").addClass("bx-x");
            }

            $(".toast-placement-ex .toast-body").text(toastMessage);

            $("#showToastPlacement").click();
        },
        error: function (error) {
            console.log("Erro na solicitação AJAX.")
        }
    })
}

function enviarAlteracaoSecretariaVeiculo() {
    var placa = document.getElementById("placa_veiculo").value;
    var novaSecretariaVeiculo = document.getElementById("secretaria_veiculo").value;

    $.ajax({
        url: 'enviar_alteracao_secretaria_veiculo.php',
        type: 'POST',
        data: {
            placa: placa,
            novaSecretariaVeiculo: novaSecretariaVeiculo
        },
        dataType: 'json',
        success: function (response) {
            var toastMessage = response.message;

            if (response.status === "success") {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
                $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
                $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

                $("#placa_veiculo").val('');
                $("#secretaria_veiculo").val('default');
                verificarVeiculo();
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

function enviarProblema() {
    var textoProblema = $("#textoProblema").val().trim();

    $.ajax({
        url: 'enviar_problema.php',
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