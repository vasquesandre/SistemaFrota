document.addEventListener('DOMContentLoaded', function () {
    buscarSecretarias();
    buscarVeiculos();
});

function buscarSecretarias() {
    $.ajax({
        url: '../../admin/viagens/buscar_secretarias.php',
        type: 'POST',
        success: function (response) {
            $('#secretaria').empty();
            $('#secretaria').append('<option value="default" selected>Selecione a Secretaria</option>');
            $('#secretaria').append(response);

            buscarSetores();
        }
    });
}

function buscarSetores() {
    var secretaria = document.getElementById('secretaria').value;

    if (secretaria !== 'default') {
        $.ajax({
            url: '../../php/scriptsajax/buscar_setores.php',
            type: 'POST',
            data: { secretaria: secretaria },
            success: function (response) {
                $('#setor').empty();
                $('#setor').append('<option value="default" selected>Selecione o Setor</option>');
                $('#setor').append(response);

                buscarNomes();
            }
        });
    } else {
        $('#setor').empty();

        $('#setor').append('<option value="default" selected>Selecione o Setor</option>');
    }
}

function buscarNomes() {
    var secretaria = document.getElementById('secretaria').value;
    var setor = document.getElementById('setor').value;

    if (secretaria !== 'default') {
        $.ajax({
            url: '../../php/scriptsajax/buscar_usuarios_secretaria.php',
            type: 'POST',
            data: { secretaria: secretaria },
            success: function (response) {
                $('#usuario').empty();
                $('#usuario').append('<option value="default" selected>Selecione o Usuário</option>');
                $('#usuario').append(response);

                buscarViagensUsuario();
            }
        });
    } else {
        $('#usuario').empty();

        $('#usuario').append('<option value="default" selected>Selecione o Usuário</option>');
    }

    if (setor !== 'default') {
        $.ajax({
            url: '../../php/scriptsajax/buscar_usuarios_setor.php',
            type: 'POST',
            data: { setor: setor },
            success: function (response) {
                $('#usuario').empty();
                $('#usuario').append('<option value="default" selected>Selecione o Usuário</option>');
                $('#usuario').append(response);

                buscarViagensUsuario();
            }
        });
    } else {
        $('#usuario').empty();

        $('#usuario').append('<option value="default" selected>Selecione o Usuário</option>');
    }
}

function buscarViagensUsuario() {
    var usuario = document.getElementById('usuario').value;

    if (usuario !== 'default') {
        $.ajax({
            url: '../../php/scriptsajax/buscar_viagens_usuario.php',
            type: 'POST',
            data: { usuario: usuario },
            success: function (response) {
                $('#viagens').empty();
                $('#viagens').append(response);
            }
        });
    } else {
        $('#viagens').empty();
    }
}

function buscarVeiculos() {
    $.ajax({
        url: '../../php/scriptsajax/buscar_veiculos.php',
        type: 'POST',
        success: function (response) {
            console.log(response);
            $('#veiculos').empty();
            $('#veiculos').append('<option value="default">--</option>');
            $('#veiculos').append(response);
        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }

    })
}

function buscarViagensVeiculo() {
    var veiculo = document.getElementById('veiculos').value;

    if (veiculo !== 'default') {
        $.ajax({
            url: '../../php/scriptsajax/buscar_viagens_veiculo.php',
            type: 'POST',
            data: { veiculo: veiculo },
            success: function (response) {
                $('#viagensveiculo').empty();
                $('#viagensveiculo').append(response);
            }
        });
    } else {
        $('#viagensveiculo').empty();
    }
}

function buscarCoordenadas(index) {
    $.ajax({
        url: '../../php/scriptsajax/buscar_coordenadas.php',
        type: 'POST',
        data: {
            index: index
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            map.eachLayer(function (layer) {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });

            eval(response.coordenadas);

            var markersData = response.coordenadas;

            var markersArray = markersData.split('var ');

            markersArray.shift();

            for (var i = 1; i < markersArray.length; i++) {
                markersArray[i] = 'var ' + markersArray[i];
            }

            console.log(markersArray);


            $('#description').empty();
            $('#description').append(response.veiculo + '<br>');
            $('#description').append(response.km + '<br>');
            $('#description').append(response.km_total + '<br>');
            $('#description').append(response.tempo_total + '<br>');
            $('#description').append(response.destino);

            var group = L.featureGroup(markers).addTo(map);
            map.fitBounds(group.getBounds());
        }
    });
}


function buscarCoordenadasVeiculo(index) {
    $.ajax({
        url: '../../php/scriptsajax/buscar_coordenadas_veiculo.php',
        type: 'POST',
        data: {
            index: index
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            map.eachLayer(function (layer) {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });

            eval(response.coordenadas);

            $('#description').empty();
            $('#description').append(response.motorista + '<br>');
            $('#description').append(response.km + '<br>');
            $('#description').append(response.km_total + '<br>');
            $('#description').append(response.tempo_total + '<br>');
            $('#description').append(response.destino);
        }
    });
}