function carregarAdmins() {
    $.ajax({
        url: 'carregar_admins.php',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            var tabelaID = '#tabelaAdmin';
            var tabelaBody = $(tabelaID + ' tbody');
            tabelaBody.empty();

            if (response.length > 0) {
                $.each(response, function (index, usuario) {
                    var linha = '<tr>' +
                        '<td><strong>' + usuario.nome + '</strong></td>' +
                        '<td>' + usuario.secretaria + ' / ' + usuario.setor + '</td>' +
                        '<td>' + usuario.matricula + '</td>' +
                        '<td>' +
                        '<div class="dropdown">' +
                        '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                        '<i class="bx bx-dots-vertical-rounded"></i>' +
                        '</button>' +
                        '<div class="dropdown-menu">' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="confirmarRebaixarNivelSupervisor(' + usuario.id_login + ', \'' + usuario.nome + '\')"><i class="bx bxs-star-half me-1"></i>Rebaixar para Supervisor</a>' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="editarUsuario(' + usuario.id_login + ', \'' + usuario.nome + '\')"><i class="bx bx-edit-alt me-1"></i>Alterar Setor</a>' + 
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="confirmarDesativarUsuario(' + usuario.id_login + ', \'' + usuario.nome + '\')"><i class="bx bx-user-x me-1"></i>Desativar</a>' +
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


function carregarSupervisores() {
    $.ajax({
        url: 'carregar_supervisores.php',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            var tabelaID = '#tabelaSupervisor';
            var tabelaBody = $(tabelaID + ' tbody');
            tabelaBody.empty();

            if (response.length > 0) {
                $.each(response, function (index, usuario) {
                    var linha = '<tr>' +
                        '<td><strong>' + usuario.nome + '</strong></td>' +
                        '<td>' + usuario.secretaria + ' / ' + usuario.setor + '</td>' +
                        '<td>' + usuario.matricula + '</td>' +
                        '<td>' +
                        '<div class="dropdown">' +
                        '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                        '<i class="bx bx-dots-vertical-rounded"></i>' +
                        '</button>' +
                        '<div class="dropdown-menu">' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="confirmarAumentarNivelAdmin(' + usuario.id_login + ', \'' + usuario.nome + '\')"><i class="bx bxs-star me-1"></i>Definir Admin</a>' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="confirmarRebaixarNivelUsuario(' + usuario.id_login + ', \'' + usuario.nome + '\')"><i class="bx bx-star me-1"></i>Rebaixar para Usuário Padrão</a>' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="editarUsuario(' + usuario.id_login + ', \'' + usuario.nome + '\')"><i class="bx bx-edit-alt me-1"></i>Alterar Setor</a>' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="confirmarDesativarUsuario(' + usuario.id_login + ', \'' + usuario.nome + '\')"><i class="bx bx-user-x me-1"></i>Desativar</a>' +
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


function carregarUsuarios() {
    $.ajax({
        url: 'carregar_usuarios.php',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            var tabelaID = '#tabelaUsuarios';
            var tabelaBody = $(tabelaID + ' tbody');
            tabelaBody.empty();

            if (response.length > 0) {
                $.each(response, function (index, usuario) {
                    var linha = '<tr>' +
                        '<td><strong>' + usuario.nome + '</strong></td>' +
                        '<td>' + usuario.secretaria + ' / ' + usuario.setor + '</td>' +
                        '<td>' + usuario.matricula + '</td>' +
                        '<td>' +
                        '<div class="dropdown">' +
                        '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                        '<i class="bx bx-dots-vertical-rounded"></i>' +
                        '</button>' +
                        '<div class="dropdown-menu">' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="confirmarAumentarNivelSupervisor(' + usuario.id_login + ', \'' + usuario.nome + '\')"><i class="bx bxs-star-half me-1"></i>Definir Supervisor</a>' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="editarUsuario(' + usuario.id_login + ', \'' + usuario.nome + '\')"><i class="bx bx-edit-alt me-1"></i>Alterar Setor</a>' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="confirmarDesativarUsuario(' + usuario.id_login + ', \'' + usuario.nome + '\')"><i class="bx bx-user-x me-1"></i>Desativar</a>' +
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


function carregarUsuariosDesativados() {
    $.ajax({
        url: 'carregar_usuarios_desativados.php',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            var tabelaID = '#tabelaUsuariosDesativados';
            var tabelaBody = $(tabelaID + ' tbody');
            tabelaBody.empty();

            if (response.length > 0) {
                $.each(response, function (index, usuario) {
                    var linha = '<tr>' +
                        '<td><strong>' + usuario.nome + '</strong></td>' +
                        '<td>' + usuario.secretaria + ' / ' + usuario.setor + '</td>' +
                        '<td>' + usuario.matricula + '</td>' +
                        '<td>' +
                        '<div class="dropdown">' +
                        '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                        '<i class="bx bx-dots-vertical-rounded"></i>' +
                        '</button>' +
                        '<div class="dropdown-menu">' +
                        '<a class="dropdown-item" href="javascript:void(0);" onclick="confirmarReativarUsuario(' + usuario.id_login + ', \'' + usuario.nome + '\')"><i class="bx bx-user-plus me-1"></i>Reativar</a>' +
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