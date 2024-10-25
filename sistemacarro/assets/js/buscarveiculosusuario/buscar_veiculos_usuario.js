function buscarVeiculosUsuario(matricula) {
    $.ajax({
        type: 'POST',
        url: '../../../sistemacarro/php/scriptsajax/buscarveiculosusuario/buscar_veiculos_usuario.php',
        data: {
            matricula: matricula
        },
        dataType: 'json',
        success: function (response) {
            $('#meusVeiculos').html('');

            if (response.length > 0) {
                var opcoesHTML = '<div class="mb-1">';
                response.forEach(function (veiculo) {
                    opcoesHTML += '<div class="card card-veiculo">';
                    opcoesHTML += '<span style="padding: 10px;" data-idveiculo="' + veiculo.id_veiculo + '">' + veiculo.placa + ' / ' + veiculo.modelo + '</span>';
                    opcoesHTML += '<button type="button" class="btn btn-icon btn-excluir-veiculo" data-bs-toggle="modal" data-bs-target="#modalCenterConfirm" onclick="modalDesvincularVeiculoUsuario(' + veiculo.id_veiculo + ', \'' + veiculo.placa + '\', \'' + veiculo.modelo + '\', \'' + matricula + '\')"><i class="bx bx-x"></i></button>';
                    opcoesHTML += '</div>';
                });
                opcoesHTML += '</div>';
                $('#meusVeiculos').html(opcoesHTML);
            } else {
                var opcoesHTML = '<div class="card-body" padding-top: 0;">Nenhum veículo vinculado.</div>';
                $('#meusVeiculos').html(opcoesHTML);
            }
        },
        error: function (error) {
            console.log("Erro na solicitação AJAX: ", error);
        }
    });
}

