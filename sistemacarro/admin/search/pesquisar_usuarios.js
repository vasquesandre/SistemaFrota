function pesquisarUsuario() {
    var matricula = $('#numeroMatricula').val();

    $.ajax({
        url: 'processa_pesquisar_usuario.php',
        type: 'POST',
        data: {
            matricula: matricula
        },
        dataType: 'json',
        success: function (response) {
            console.log(response)
            if (response.status === 'success') {
                var userData = response.message;

                if (userData.length > 0) {
                    var user = userData[0];

                    $('#error').hide();
                    $('#success').show();
                    $('#nome').val(user.nome);
                    $('#usuario').val(user.usuario);
                    $('#email').val(user.email);
                    $('#matricula_usuario').val(user.matricula);
                    $('#matricula').val(user.matricula);
                    $('#nomesecretaria').val(user.nome_secretaria);
                    $('#nomesetor').val(user.nome_setor);
                    $('#perfil').val(user.nome_perfil);

                    buscarVeiculosUsuario(user.matricula);

                    //botao alterar setor
                    var alterarSetorBtn = $('#alterarSetorBtn');
                    alterarSetorBtn.empty();
                    var botaoSetor = $('<button/>', {
                        type: 'button',
                        class: 'btn btn-primary',
                        text: 'Alterar Secretaria ou Setor',
                        onclick: 'editarUsuario("' + user.id_login + '", "' + user.nome + '")'
                    });
                    alterarSetorBtn.append(botaoSetor);

                    //botao alterar nivel de permissao
                    var alterarNivelBtn = $('#alterarNivelBtn');
                    alterarNivelBtn.empty();

                    var dropdownToggle = $('<button/>', {
                        type: 'button',
                        class: 'btn btn-primary dropdown-toggle',
                        id: 'dropdownMenuOffset',
                        'data-bs-toggle': 'dropdown',
                        'aria-expanded': 'false',
                        'data-bs-offset': '10,20',
                        text: 'Alterar Nível de Permissão'
                    });

                    var dropdownMenu = $('<ul/>', {
                        class: 'dropdown-menu',
                        'aria-labelledby': 'dropdownMenuOffset',
                        style: ''
                    });

                    var perfil = $('#perfil').val();
                    if (perfil == "Administrador") {
                        $('<li/>').appendTo(dropdownMenu).append(
                            $('<a/>', {
                                class: 'dropdown-item',
                                href: 'javascript:void(0)',
                                onclick: 'confirmarRebaixarNivelSupervisor("' + user.id_login + '", "' + user.nome + '")'
                            }).append(
                                $('<i/>', {
                                    class: 'bx bxs-star-half me-1'
                                }),
                                'Rebaixar para Supervisor'
                            )
                        );
                    } else if (perfil == "Supervisor") {
                        $('<li/>').appendTo(dropdownMenu).append(
                            $('<a/>', {
                                class: 'dropdown-item',
                                href: 'javascript:void(0)',
                                onclick: 'confirmarAumentarNivelAdmin("' + user.id_login + '", "' + user.nome + '")'
                            }).append(
                                $('<i/>', {
                                    class: 'bx bxs-star me-1'
                                }),
                                'Definir como Administrador'
                            )
                        );
                        $('<li/>').appendTo(dropdownMenu).append(
                            $('<a/>', {
                                class: 'dropdown-item',
                                href: 'javascript:void(0)',
                                onclick: 'confirmarRebaixarNivelUsuario("' + user.id_login + '", "' + user.nome + '")'
                            }).append(
                                $('<i/>', {
                                    class: 'bx bx-star me-1'
                                }),
                                'Rebaixar para Usuario Padrão'
                            )
                        );
                    } else {
                        $('<li/>').appendTo(dropdownMenu).append(
                            $('<a/>', {
                                class: 'dropdown-item',
                                href: 'javascript:void(0)',
                                onclick: 'confirmarAumentarNivelSupervisor("' + user.id_login + '", "' + user.nome + '")'
                            }).append(
                                $('<i/>', {
                                    class: 'bx bxs-star-half me-1'
                                }),
                                'Definir como Supervisor'
                            )
                        );
                    }
                    dropdownToggle.appendTo(alterarNivelBtn);
                    dropdownMenu.appendTo(alterarNivelBtn);

                    //botao ativar ou desativar
                    var alterarAtivoBtn = $('#alterarAtivoBtn');
                    alterarAtivoBtn.empty();

                    if(user.ativo == 1) {
                        var botaoSetor = $('<button/>', {
                            type: 'button',
                            class: 'btn btn-primary',
                            text: 'Desativar Usuário',
                            onclick: 'confirmarDesativarUsuario("' + user.id_login + '", "' + user.nome + '")'
                        });
                        alterarAtivoBtn.append(botaoSetor);
                    } else {
                        var botaoSetor = $('<button/>', {
                            type: 'button',
                            class: 'btn btn-primary',
                            text: 'Reativar Usuário',
                            onclick: 'confirmarReativarUsuario("' + user.id_login + '", "' + user.nome + '")'
                        });
                        alterarAtivoBtn.append(botaoSetor);
                    }

                    //botao vincular veiculo
                    var vincularVeiculoBtn = $('#vincularVeiculoBtn');
                    vincularVeiculoBtn.empty();

                    var botaoVincular = $('<button/>', {
                        type: 'button',
                        class: 'btn btn-primary',
                        text: 'Vincular Veículo',
                        onclick: 'modalVincularVeiculoUsuario()'
                    });
                    vincularVeiculoBtn.append(botaoVincular);
                }
            } else {
                $('#success').hide();
                $('#error').show();
                $('#errorMessage').val("Matrícula não encontrada.");
            }
        },
        error: function (error) {
            console.log("Erro na solicitação AJAX: " + error)
        }
    })
}
