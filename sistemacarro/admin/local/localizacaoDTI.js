document.addEventListener('DOMContentLoaded', function () {
    buscarNomes();
});

function buscarNomes() {
    $.ajax({
        url: 'buscar_motoristas_dti.php',
        type: 'POST',
        success: function (response) {
            $('#usuario').empty();
            $('#usuario').append('<option value="default" selected>Selecione o Usuário</option>');
            $('#usuario').append(response);
        }
    });
}

function buscarLocalizacaoUsuario() {
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