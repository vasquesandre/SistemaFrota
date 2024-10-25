document.addEventListener('DOMContentLoaded', function () {
    buscarNomesSecretaria();
});

function buscarNomesSecretaria() {
    $.ajax({
        url: 'buscar_nomes_secretaria.php',
        type: 'POST',
        success: function (response) {
            $('#usuario').empty();
            $('#usuario').append('<option value="default" selected>Selecione o Usuário</option>');
            $('#usuario').append(response);

            buscarSetores();
        }
    });
}

function buscarSetores() {
    $.ajax({
        url: '../../php/scriptsajax/buscar_setores.php',
        type: 'POST',
        success: function (response) {
            $('#setor').empty();
            $('#setor').append('<option value="default" selected>Selecione o Setor</option>');
            $('#setor').append(response);
        }
    });
}

function buscarNomes() {
    var setor = document.getElementById('setor').value;

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