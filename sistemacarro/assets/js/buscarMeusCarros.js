document.addEventListener('DOMContentLoaded', function () {
    buscarMeusVeiculos();
});

function buscarMeusVeiculos() {
    $.ajax({
        type: 'POST',
        url: '../../../sistemacarro/php/scriptsajax/buscar_meus_veiculos.php',
        dataType: 'json',
        success: function (response) {
            var currentPage = window.location.pathname;

            $('#meusVeiculos').html('');

            if (currentPage.includes("html/conta/configuracoes_conta.php")) {
                if (response.length > 0) {
                    var opcoesHTML = '<div class="mb-1">';
                    response.forEach(function (veiculo) {
                        opcoesHTML += '<div class="card card-veiculo">';
                        opcoesHTML += '<span style="padding: 10px;" data-idveiculo="' + veiculo.id_veiculo + '">' + veiculo.placa + ' / ' + veiculo.modelo + '</span>';
                        opcoesHTML += '<button type="button" class="btn btn-icon btn-excluir-veiculo" data-bs-toggle="modal" data-bs-target="#modalCenterConfirm" onclick="modalDesvincularVeiculoUsuario(' + veiculo.id_veiculo + ', \'' + veiculo.placa + '\', \'' + veiculo.modelo + '\', \'' + veiculo.matricula + '\')"><i class="bx bx-x"></i></button>';
                        opcoesHTML += '</div>';
                    });
                    opcoesHTML += '</div>';
                    $('#meusVeiculos').html(opcoesHTML);
                }
            } else if (currentPage.includes("iniciar_viagem.php")) {
                var opcoesHTML = '';
                response.forEach(function (veiculo) {
                    opcoesHTML += '<option value="' + veiculo.id_veiculo + '">' + veiculo.placa + ' / ' + veiculo.modelo + '</option>';
                });
                $('#meusVeiculos').html(opcoesHTML);
            }
        },
        error: function (error) {
            console.log("Erro na solicitação AJAX: ", error);
        }
    });
}

