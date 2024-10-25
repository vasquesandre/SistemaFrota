function modalDesvincularVeiculoUsuario(index, placa, veiculo, matricula) {
    var modal = $('#modalCenterConfirm');

    modal.find('.modal-title').text(placa + " / " + veiculo);
    modal.find('.form-label').text("Deseja realmente desvincular este veículo?");

    modal.find('.btn-primary').off('click').on('click', function () {
        desvincularVeiculoUsuario(index, matricula, placa);
        modal.modal('hide');
    });

    modal.modal('show');
}

function desvincularVeiculoUsuario(index, usuario, placa) {
    $.ajax({
        url: '../../../../sistemacarro/php/scriptsajax/desvincularveiculo/desvincular_veiculo_usuario.php',
        type: 'POST',
        data: {
            usuario: usuario,
            index: index
        },
        dataType: 'json',
        success: function (response) {
            var toastMessage = response.message;
            var currentPage = window.location.pathname;

            if (response.status === "success") {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
                $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
                $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

                if (currentPage.includes("html/conta/configuracoes_conta.php")) {
                    buscarMeusVeiculos();
                } else if (currentPage.includes("admin/search/pesquisar_usuarios.php")) {
                    buscarVeiculosUsuario(usuario);
                } else if (currentPage.includes("admin/gerenciarveiculos/gerenciamento_veiculos.php")) {
                    buscarUsuariosVeiculo(placa);
                } else if (currentPage.includes("supervisor/search/pesquisar_usuarios.php")) {
                    buscarVeiculosUsuario(usuario);
                }
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