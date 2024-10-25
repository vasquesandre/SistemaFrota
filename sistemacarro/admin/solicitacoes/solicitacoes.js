document.addEventListener('DOMContentLoaded', function () {
    carregarNaoResolvidos();
});

function carregarNaoResolvidos() {
    $.ajax({
        url: 'carregar_nao_resolvidos.php',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            console.log(response)

            var tabelaIdVinculo = '#tabelaVinculoVeiculoNaoResolvido';
            var tabelaVinculo = $(tabelaIdVinculo + ' tbody');
            tabelaVinculo.empty();

            var tabelaIdSetor = '#tabelaSetorNaoResolvido';
            var tabelaSetor = $(tabelaIdSetor + ' tbody');
            tabelaSetor.empty();

            var tabelaIdBug = '#tabelaBugNaoResolvido';
            var tabelaBug = $(tabelaIdBug + ' tbody');
            tabelaBug.empty();

            var tabelaIdSecretariaVeiculo = '#tabelaAlterarSecretariaVeiculoNaoResolvido';
            var tabelaSecretariaVeiculo = $(tabelaIdSecretariaVeiculo + ' tbody');
            tabelaSecretariaVeiculo.empty();

            if (response.length > 0) {
                $.each(response, function (index, solicitacao) {
                    if (solicitacao.tipo == 1) {
                        var linha = '<tr>' +
                            '<td data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="' +
                            '<span>Matrícula: ' + solicitacao.matricula + '</span>"><strong>' + solicitacao.nome + '</strong></td>' +
                            '<td>' + solicitacao.matricula + '</td>' +
                            '<td>' + solicitacao.setor + '</td>' +
                            '<td>' + solicitacao.data_solicitacao + '</td>' +
                            '<td>' +
                            '<div class="dropdown">' +
                            '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                            '<i class="bx bx-dots-vertical-rounded"></i>' +
                            '</button>' +
                            '<div class="dropdown-menu">' +
                            '<a class="dropdown-item" href="javascript:void(0);" onclick="solicitacaoResolvida(' + solicitacao.id_solicitacao + ')"><i class="bx bx-check me-1"></i>Resolvido</a>' +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            '</tr>';
                        tabelaSetor.append(linha);

                        $('[data-bs-toggle="tooltip"]').tooltip();
                    }

                    if (solicitacao.tipo == 2) {
                        function quebrarTexto(texto, limite) {
                            var quebrado = [];
                            while (texto.length > limite) {
                                var pedaco = texto.substring(0, limite);
                                var ultimoEspaco = pedaco.lastIndexOf(' ');
                                pedaco = (ultimoEspaco > 0) ? pedaco.substring(0, ultimoEspaco) : pedaco;
                                quebrado.push(pedaco);
                                texto = texto.substring(pedaco.length).trim();
                            }
                            quebrado.push(texto);
                            return quebrado.join('<br>');
                        }

                        var textoFormatado = quebrarTexto(solicitacao.texto, 80);

                        var linha = '<tr>' +
                            '<td data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="' +
                            '<span>Matrícula: ' + solicitacao.matricula + '</span>"><strong>' + solicitacao.nome + '</strong></td>' +
                            '<td>' + textoFormatado + '</td>' +
                            '<td>' + solicitacao.data_solicitacao + '</td>' +
                            '<td>' +
                            '<div class="dropdown">' +
                            '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                            '<i class="bx bx-dots-vertical-rounded"></i>' +
                            '</button>' +
                            '<div class="dropdown-menu">' +
                            '<a class="dropdown-item" href="javascript:void(0);" onclick="solicitacaoResolvida(' + solicitacao.id_solicitacao + ')"><i class="bx bx-check me-1"></i>Resolvido</a>' +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            '</tr>';

                        tabelaBug.append(linha);

                        $('[data-bs-toggle="tooltip"]').tooltip();
                    }

                    if (solicitacao.tipo == 3) {
                        var linha = '<tr>' +
                            '<td data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="' +
                            '<span>Matrícula: ' + solicitacao.matricula + '</span>"><strong>' + solicitacao.nome + '</strong> / ' + solicitacao.nome_setor + '</td>' +
                            '<td>' + solicitacao.veiculo + '</td>' +
                            '<td>' + solicitacao.data_solicitacao + '</td>' +
                            '<td>' +
                            '<div class="dropdown">' +
                            '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                            '<i class="bx bx-dots-vertical-rounded"></i>' +
                            '</button>' +
                            '<div class="dropdown-menu">' +
                            '<a class="dropdown-item" href="javascript:void(0);" onclick="vincularVeiculoExistente(' + solicitacao.matricula + ', ' + solicitacao.texto + ', ' + solicitacao.id_solicitacao + ')"><i class="bx bx-layer-plus me-1"></i>Vincular</a>' +
                            '<a class="dropdown-item" href="javascript:void(0);" onclick="solicitacaoResolvida(' + solicitacao.id_solicitacao + ')"><i class="bx bx-check me-1"></i>Resolvido</a>' +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            '</tr>';
                        tabelaVinculo.append(linha);

                        $('[data-bs-toggle="tooltip"]').tooltip();
                    }

                    if (solicitacao.tipo == 4) {
                        var linha = '<tr>' +
                            '<td data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="' +
                            '<span>Matrícula: ' + solicitacao.matricula + '</span>"><strong>' + solicitacao.nome + '</strong></td>' +
                            '<td>' + solicitacao.texto + '</td>' +
                            '<td>' + solicitacao.data_solicitacao + '</td>' +
                            '<td>' +
                            '<div class="dropdown">' +
                            '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                            '<i class="bx bx-dots-vertical-rounded"></i>' +
                            '</button>' +
                            '<div class="dropdown-menu">' +
                            '<a class="dropdown-item" href="javascript:void(0);" onclick="solicitacaoResolvida(' + solicitacao.id_solicitacao + ')"><i class="bx bx-check me-1"></i>Resolvido</a>' +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            '</tr>';

                        tabelaSecretariaVeiculo.append(linha);

                        $('[data-bs-toggle="tooltip"]').tooltip();
                    }

                });
            }
        },
        error: function (error) {
            console.log("Erro na solicitação AJAX: ", error);
        }
    });
}


function carregarResolvidos() {
    
    $.ajax({
        url: 'carregar_resolvidos.php',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            console.log(response)
            var tabelaIdVinculo = '#tabelaVinculoVeiculoResolvido';
            var tabelaVinculo = $(tabelaIdVinculo + ' tbody');
            tabelaVinculo.empty();

            var tabelaIdSetor = '#tabelaSetorResolvido';
            var tabelaSetor = $(tabelaIdSetor + ' tbody');
            tabelaSetor.empty();

            var tabelaIdBug = '#tabelaBugResolvido';
            var tabelaBug = $(tabelaIdBug + ' tbody');
            tabelaBug.empty();

            var tabelaIdSecretariaVeiculo = '#tabelaAlterarSecretariaVeiculoResolvido';
            var tabelaSecretariaVeiculo = $(tabelaIdSecretariaVeiculo + ' tbody');
            tabelaSecretariaVeiculo.empty();

            if (response.length > 0) {
                $.each(response, function (index, solicitacao) {
                    if (solicitacao.tipo == 1) {
                        var linha = '<tr>' +
                            '<td data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="' +
                            '<span>Matrícula: ' + solicitacao.matricula + '</span>"><strong>' + solicitacao.nome + '</strong></td>' +
                            '<td>' + solicitacao.matricula + '</td>' +
                            '<td>' + solicitacao.setor + '</td>' +
                            '<td>' + solicitacao.data_solicitacao + '</td>' +
                            '<td>' + solicitacao.data_resolvido + ' / ' + solicitacao.nome_resolvido + '</td>' +
                            '</tr>';
                        tabelaSetor.append(linha);

                        $('[data-bs-toggle="tooltip"]').tooltip();
                    }

                    if (solicitacao.tipo == 2) {
                        function quebrarTexto(texto, limite) {
                            var quebrado = [];
                            while (texto.length > limite) {
                                var pedaco = texto.substring(0, limite);
                                var ultimoEspaco = pedaco.lastIndexOf(' ');
                                pedaco = (ultimoEspaco > 0) ? pedaco.substring(0, ultimoEspaco) : pedaco;
                                quebrado.push(pedaco);
                                texto = texto.substring(pedaco.length).trim();
                            }
                            quebrado.push(texto);
                            return quebrado.join('<br>');
                        }

                        var textoFormatado = quebrarTexto(solicitacao.texto, 60);

                        var linha = '<tr>' +
                            '<td data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="' +
                            '<span>Matrícula: ' + solicitacao.matricula + '</span>"><strong>' + solicitacao.nome + '</strong></td>' +
                            '<td>' + textoFormatado + '</td>' +
                            '<td>' + solicitacao.data_solicitacao + '</td>' +
                            '<td>' + solicitacao.data_resolvido + ' / ' + solicitacao.nome_resolvido + '</td>' +
                            '</tr>';

                        tabelaBug.append(linha);

                        $('[data-bs-toggle="tooltip"]').tooltip();
                    }

                    if (solicitacao.tipo == 3) {
                        var linha = '<tr>' +
                            '<td data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="' +
                            '<span>Matrícula: ' + solicitacao.matricula + '</span>"><strong>' + solicitacao.nome + '</strong> / '+ solicitacao.nome_setor + '</td>' +
                            '<td>' + solicitacao.veiculo + '</td>' +
                            '<td>' + solicitacao.data_solicitacao + '</td>' +
                            '<td>' + solicitacao.data_resolvido + ' / ' + solicitacao.nome_resolvido + '</td>' +
                            '<td>' +
                            '</td>' +
                            '</tr>';
                        tabelaVinculo.append(linha);

                        $('[data-bs-toggle="tooltip"]').tooltip();
                    }

                    if (solicitacao.tipo == 4) {
                        var linha = '<tr>' +
                            '<td data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="' +
                            '<span>Matrícula: ' + solicitacao.matricula + '</span>"><strong>' + solicitacao.nome + '</strong></td>' +
                            '<td>' + solicitacao.texto + '</td>' +
                            '<td>' + solicitacao.data_solicitacao + '</td>' +
                            '<td>' + solicitacao.data_resolvido + ' / ' + solicitacao.nome_resolvido + '</td>' +
                            '<td>' +
                            '</td>' +
                            '</tr>';

                        tabelaSecretariaVeiculo.append(linha);

                        $('[data-bs-toggle="tooltip"]').tooltip();
                    }

                });
            }
        },
        error: function (error) {
            console.log("Erro na solicitação AJAX: ", error);
        }
    });
}