function modalAlterarSecretariaVeiculo(placa, modelo) {
    var modal = $('#modalSecretariaVeiculo');

    modal.find('.modal-title').text(placa + ' / ' + modelo);

    modal.find('.btn-primary').off('click').on('click', function () {
        var novaSecretaria = modal.find('#secretaria').val();
        alterarSecretariaVeiculo(placa, novaSecretaria);
        modal.modal('hide');
    });

    modal.modal('show');
}

function verificarSecretaria() {
    var selectSecretaria = document.getElementById("secretaria");
    var saveBtn = document.getElementById("saveBtn");

    if (selectSecretaria.value !== "default") {
        saveBtn.disabled = false;
    } else {
        saveBtn.disabled = true;
    }
}

function alterarSecretariaVeiculo(placa, novaSecretaria) {
    console.log(placa, novaSecretaria)
    $.ajax({
        url: '../../../../sistemacarro/php/scriptsajax/alterarsecretariaveiculo/alterar_secretaria_veiculo.php',
        type: 'POST',
        data: {
            placa: placa,
            novaSecretaria: novaSecretaria
        },
        dataType: 'json',
        success: function (response) {
            console.log(response)
            var toastMessage = response.message;
            var currentPage = window.location.pathname;

            if (response.status === "success") {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
                $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
                $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

                if (currentPage.includes("admin/gerenciarveiculos/gerenciamento_veiculos.php")) {
                    carregarVeiculos();
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