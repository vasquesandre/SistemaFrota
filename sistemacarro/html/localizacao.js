const getLocation = () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            let lat = position.coords.latitude;
            let long = position.coords.longitude;
            var latlong = lat + ", " + long

            iniciarViagem(latlong);
            startLocationUpdate();
        }, () => {
            console.log("Usuário recusou compartilhar a localização.");
        }, {
            enableHighAccuracy: true
        });
    }
}

// atualizar localizacao
let updateInterval;

const startLocationUpdate = () => {
    attLocation();

    updateInterval = setInterval(attLocation, 5000);
}

const stopLocationUpdate = () => {
    clearInterval(updateInterval);
}

const attLocation = () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            let lat = position.coords.latitude;
            let long = position.coords.longitude;
            let latlong = lat + ", " + long;

            atualizarLocalizacao(latlong);
        }, () => {
            console.log("Usuário recusou compartilhar a localização.");
        });
    }
}

const atualizarLocalizacao = (latlong) => {
    $.ajax({
        url: 'atualizar_localizacao.php',
        dataType: "json",
        method: 'POST',
        data: { latlong: latlong },
        success: function (response) {
            console.log("Localização atualizada com sucesso!");
        },
        error: function (xhr, status, error) {
            console.error("Erro ao atualizar a localização: " + error);
        }
    });
}