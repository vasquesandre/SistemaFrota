function editarUsuario(login, nome) {
    var modal = $('#modalCenter');

    modal.find('.modal-title').text(nome);

    modal.find('.btn-primary').off('click').on('click', function () {
        var novaSecretaria = modal.find('#secretaria').val();
        var novoSetor = modal.find('#setor').val();
        atualizarUsuario(login, novaSecretaria, novoSetor);
        modal.modal('hide');
    });

    modal.modal('show');
}

function atualizarUsuario(login, novaSecretaria, novoSetor) {
    $.ajax({
        url: '../../php/scriptsajax/atualizar_usuario.php',
        type: 'POST',
        data: {
            id_login: login,
            novaSecretaria: novaSecretaria,
            novoSetor: novoSetor
        },
        dataType: 'json',
        success: function (response) {
            var toastMessage = response.message;
            var currentPage = window.location.pathname;

            if (response.status === "success") {
                $(".toast-placement-ex .toast-header .fw-semibold").text("Success");
                $(".toast-placement-ex").removeClass("bg-danger").removeClass("bg-warning").addClass("bg-success");
                $(".toast-placement-ex .notif-icon").removeClass("bx-x").removeClass("bx-edit-alt").addClass("bx-check");

                if (currentPage.includes("admin/gerenciamento/gerenciamento.php")) {
                    carregarAdmins();
                    carregarSupervisores();
                    carregarUsuarios();
                    carregarUsuariosDesativados();
                } else if (currentPage.includes("pesquisar_usuarios.php")) {
                    pesquisarUsuario();
                } else if (currentPage.includes("supervisor/gerenciamento/gerenciamento.php")) {
                    carregarUsuarios();
                    carregarUsuariosDesativados();
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

function atualizarSetores() {
    var secretaria = document.getElementById('secretaria').value;

    if (secretaria !== 'default') {
        $.ajax({
            url: '../../../sistemacarro/php/scriptsajax/buscar_setores.php',
            type: 'POST',
            data: { secretaria: secretaria },
            success: function (response) {
                $('#setor').empty();
                $('#setor').append('<option value="default" selected>Selecione o Setor</option>');
                $('#setor').append(response);

                selecionarSetor();
            },
            error: function (error) {
                console.log(JSON.stringify(error))
            }
        });
    } else {
        $('#setor').empty();

        $('#setor').append('<option value="default" selected>Selecione o Setor</option>');

        selecionarSetor();
    }
}

$(document).ready(function () {
    var currentPage = window.location.pathname;

    if (currentPage.includes("admin/gerenciamento/gerenciamento.php")) {
        carregarAdmins();
    } else if (currentPage.includes("supervisor/gerenciamento/gerenciamento.php")) {
        carregarUsuarios();
    }
});

function selecionarSecretaria() {
    atualizarSetores();

    var selectSecretaria = document.getElementById("secretaria");
    var selectSetor = document.getElementById("setor");

    if (selectSecretaria.value !== "default") {
        selectSetor.disabled = false;
    } else {
        selectSetor.disabled = true;
    }

    if (currentPage.includes("supervisor/solicitacoes/solicitacoes.php")) {
        var selectSecretariaVeiculo = document.getElementById("secretaria_veiculo");
        var veiculoBtn = document.getElementById("veiculoBtn");

        if (selectSecretariaVeiculo.value !== "default") {
            veiculoBtn.disabled = false;
        } else {
            veiculoBtn.disabled = true;
        }   
    }
}

function selecionarSetor() {
    var selectSetor = document.getElementById("setor");
    var saveBtn = document.getElementById("saveBtn");

    if (selectSetor.value !== "default") {
        saveBtn.disabled = false;
    } else {
        saveBtn.disabled = true;
    }
}