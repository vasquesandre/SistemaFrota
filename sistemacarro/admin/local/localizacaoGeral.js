document.addEventListener('DOMContentLoaded', function () {
    buscarSecretarias();
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
            url: 'buscar_nomes_secretaria.php',
            type: 'POST',
            data: { secretaria: secretaria },
            success: function (response) {
                $('#usuario').empty();
                $('#usuario').append('<option value="default" selected>Selecione o Usuário</option>');
                $('#usuario').append(response);
            }
        });
    } else {
        $('#usuario').empty();

        $('#usuario').append('<option value="default" selected>Selecione o Usuário</option>');
    }

    if (setor !== 'default') {
        $.ajax({
            url: 'buscar_nomes_setor.php',
            type: 'POST',
            data: { setor: setor },
            success: function (response) {
                $('#usuario').empty();
                $('#usuario').append('<option value="default" selected>Selecione o Usuário</option>');
                $('#usuario').append(response);
            }
        });
    } else {
        $('#usuario').empty();

        $('#usuario').append('<option value="default" selected>Selecione o Usuário</option>');
    }
}

function buscarCoordenadasUsuario() {
    var usuario = document.getElementById("usuario").value;

    $.ajax({
        url: 'buscar_localizacao_dti.php',
        type: 'POST',
        data: {
            usuario: usuario
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
        }
    })
}