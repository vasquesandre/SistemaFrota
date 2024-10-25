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
                    if (user.nome_perfil == "Usuário Padrão") {
                        var botaoSetor = $('<button/>', {
                            type: 'button',
                            class: 'btn btn-primary',
                            text: 'Alterar Secretaria ou Setor',
                            onclick: 'editarUsuario("' + user.id_login + '", "' + user.nome + '")'
                        });
                        alterarSetorBtn.append(botaoSetor);
                    }

                    //botao ativar ou desativar
                    var alterarAtivoBtn = $('#alterarAtivoBtn');
                    alterarAtivoBtn.empty();
                    if (user.nome_perfil == "Usuário Padrão") {
                        if (user.ativo == 1) {
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
