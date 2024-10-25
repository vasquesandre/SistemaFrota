function confirmarAumentarNivelSupervisor(login, nome) {
    var modal = $('#modalCenterConfirm');

    modal.find('.modal-title').text(nome);
    modal.find('.form-label').text("Deseja realmente definir este usuário como supervisor?");

    modal.find('.btn-primary').off('click').on('click', function () {
        aumentarNivel(login);
        modal.modal('hide');
    });

    modal.modal('show');
}

function confirmarAumentarNivelAdmin(login, nome) {
    var modal = $('#modalCenterConfirm');

    modal.find('.modal-title').text(nome);
    modal.find('.form-label').text("Deseja realmente definir este usuário como administrador?");

    modal.find('.btn-primary').off('click').on('click', function () {
        aumentarNivel(login);
        modal.modal('hide');
    });

    modal.modal('show');
}

function confirmarRebaixarNivelUsuario(login, nome) {
    var modal = $('#modalCenterConfirm');

    modal.find('.modal-title').text(nome);
    modal.find('.form-label').text("Deseja realmente rebaixar este supervisor para usuário padrão?");

    modal.find('.btn-primary').off('click').on('click', function () {
        rebaixarNivel(login);
        modal.modal('hide');
    });

    modal.modal('show');
}

function confirmarRebaixarNivelSupervisor(login, nome) {
    var modal = $('#modalCenterConfirm');

    modal.find('.modal-title').text(nome);
    modal.find('.form-label').text("Deseja realmente rebaixar este administrador para supervisor?");

    modal.find('.btn-primary').off('click').on('click', function () {
        rebaixarNivel(login);
        modal.modal('hide');
    });

    modal.modal('show');
}

function aumentarNivel(login) {
    $.ajax({
        url: '../../php/scriptsajax/nivelacesso/aumentar_nivel.php',
        type: 'POST',
        data: {
            id_login: login
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
        }
    })
}

function rebaixarNivel(login) {
    $.ajax({
        url: '../../php/scriptsajax/nivelacesso/rebaixar_nivel.php',
        type: 'POST',
        data: {
            id_login: login
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
        }
    })
}