var currentPage = window.location.pathname;

function buscarNome() {
    var matricula = $('#matricula').val();

    if (matricula.length > 3) {
        $.ajax({
            url: '../../php/scriptsajax/buscarnome/buscar_nome.php',
            type: 'POST',
            data: {
                matricula: matricula
            },
            dataType: 'json',
            success: function (response) {
                if (currentPage.includes("supervisor/solicitacoes/solicitacoes.php")) {
                    var secretariaSolic = document.getElementById("secretaria");
                    var setorSolic = document.getElementById("setor");

                    if (response.status == "success") {
                        var userData = response.message;

                        if (userData.length > 0) {
                            var user = userData[0];

                            $('#nomeEncontrado').text(user.nome);

                            secretariaSolic.disabled = false;
                        }
                    } else {
                        $('#nomeEncontrado').text("Nenhum resultado encontrado.");

                        secretariaSolic.disabled = true;
                        setorSolic.disabled = true;
                    }
                } else {
                    if (response.status == "success") {
                        var userData = response.message;
    
                        if (userData.length > 0) {
                            var user = userData[0];
    
                            $('#nomeEncontrado').text(user.nome);
                            
                            matriculaTrue = true;
                            verificarTrue();
                        }
                    } else {
                        $('#nomeEncontrado').text("Nenhum resultado encontrado.");
    
                        matriculaTrue = false;
                        verificarTrue();
                    }
                }

            },
            error: function (error) {
                console.log("Erro na solicitação AJAX: " + error);
            }
        })
    } else {
        $('#nomeEncontrado').text('Nenhum resultado encontrado.');
    }
}