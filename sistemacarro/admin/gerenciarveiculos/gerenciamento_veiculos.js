$(document).ready(function () {
    carregarVeiculos();
});

function carregarVeiculos() {
    $.ajax({
        url: 'carregar_veiculos.php',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            var tabelaID = '#tabelaVeiculos';
            var tabelaBody = $(tabelaID + ' tbody');
            tabelaBody.empty();

            console.log(response)

            if (response.length > 0) {
                $.each(response, function (index, veiculo) {
                    var linha = '<tr>' +
                        '<td><strong>' + veiculo.placa + ' / ' + veiculo.modelo + '</strong></td>' +
                        '<td>' + veiculo.secretaria_veiculo + '</td>' +
                        '<td data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="' +
                        '<span>Matrícula: ' + veiculo.matricula + '</span>">' + veiculo.nome + '</td>' +
                        '<td>' + veiculo.secretaria_setor + '</td>' +
                        '<td>' +
                        '<div class="dropdown">' +
                        '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                        '<i class="bx bx-dots-vertical-rounded"></i>' +
                        '</button>' +
                        '<div class="dropdown-menu">' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="buscarUsuarios(\'' + veiculo.placa + '\')"><i class="bx bx-search me-1"></i>Buscar Usuários do Veículo</a>' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="modalAlterarSecretariaVeiculo(\'' + veiculo.placa + '\', \'' + veiculo.modelo + '\')"><i class="bx bx-edit me-1"></i>Alterar Secretaria do Veículo</a>' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="confirmarDesativarVeiculo(\'' + veiculo.placa + '\', \'' + veiculo.modelo + '\')"><i class="bx bx-x me-1"></i>Desativar</a>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '</tr>';
                    tabelaBody.append(linha);

                    $('[data-bs-toggle="tooltip"]').tooltip();
                });
            } else {
                tabelaBody.append('<tr><td colspan="4">Nenhum resultado encontrado</td></tr>');
            }
        },
        error: function (error) {
            console.log("Erro na solicitação AJAX: ", error);
        }
    });
}

function carregarVeiculosDesativados() {
    $.ajax({
        url: 'carregar_veiculos_desativados.php',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            var tabelaID = '#tabelaVeiculosDesativados';
            var tabelaBody = $(tabelaID + ' tbody');
            tabelaBody.empty();

            if (response.length > 0) {
                $.each(response, function (index, veiculo) {
                    var linha = '<tr>' +
                        '<td><strong>' + veiculo.placa + ' / ' + veiculo.modelo + '</strong></td>' +
                        '<td data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="' +
                        '<span>Matrícula: ' + veiculo.matricula + '</span>">' + veiculo.nome + '</td>' +
                        '<td>' + veiculo.secretaria_setor + '</td>' +
                        '<td>' +
                        '<div class="dropdown">' +
                        '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                        '<i class="bx bx-dots-vertical-rounded"></i>' +
                        '</button>' +
                        '<div class="dropdown-menu">' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="confirmarReativarVeiculo(\'' + veiculo.placa + '\', \'' + veiculo.modelo + '\')"><i class="bx bx-plus me-1"></i>Reativar</a>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '</tr>';
                    tabelaBody.append(linha);

                    $('[data-bs-toggle="tooltip"]').tooltip();
                });
            } else {
                tabelaBody.append('<tr><td colspan="4">Nenhum resultado encontrado</td></tr>');
            }
        },
        error: function (error) {
            console.log("Erro na solicitação AJAX: ", error);
        }
    });
}

function buscarUsuarios(placa) {
    var btnBuscarUsuarios = $('button[data-bs-target="#usuariosveiculo"]');
    btnBuscarUsuarios.click();
    buscarUsuariosVeiculo(placa);
}


function buscarUsuariosVeiculo(placa) {
    $.ajax({
        url: 'carregar_usuarios_veiculo.php',
        type: 'POST',
        data: {
            placa: placa
        },
        dataType: 'json',
        success: function (response) {
            var tabelaID = '#tabelaUsuariosVeiculo';
            var tabelaBody = $(tabelaID + ' tbody');
            tabelaBody.empty();

            if (response.length > 0) {
                $.each(response, function (index, veiculo) {
                    var linha = '<tr>' +
                        '<td><strong>' + veiculo.nome + '</strong></td>' +
                        '<td>' + veiculo.matricula + '</td>' +
                        '<td>' + veiculo.secretaria_setor + '</td>' +
                        '<td>' +
                        '<div class="dropdown">' +
                        '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                        '<i class="bx bx-dots-vertical-rounded"></i>' +
                        '</button>' +
                        '<div class="dropdown-menu">' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="modalDesvincularVeiculoUsuario(' + veiculo.token + ', \'' + veiculo.placa + '\', \'' + veiculo.modelo + '\', \'' + veiculo.matricula + '\')"><i class="bx bx-x me-1"></i>Desvincular</a>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '</tr>';
                    tabelaBody.append(linha);
                });
            } else {
                tabelaBody.append('<tr><td colspan="4">Nenhum resultado encontrado</td></tr>');
            }
        },
        error: function (error) {
            console.log("Erro na solicitação AJAX: ", error);
        }
    });
}