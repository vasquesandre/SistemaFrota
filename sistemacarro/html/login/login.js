$(document).ready(function () {
    $('#username').on('input', function () {
        $(this).val($(this).val().toLowerCase());
        $(this).val($(this).val().replace(/[^a-z.]/g, ''));
    });
});

function atualizarSetores() {
    var secretaria = document.getElementById('secretaria').value;
    
    if (secretaria !== 'default') {
        $.ajax({
            url: 'buscar_setores.php',
            type: 'POST',
            data: { secretaria: secretaria },
            success: function(response) {
                $('#setor').empty();
                $('#setor').append('<option value="default" selected>Selecione o Setor</option>');
                $('#setor').append(response);

                selecionarSetor();
            }
        });
    } else {
        $('#setor').empty();
        
        $('#setor').append('<option value="default" selected>Selecione o Setor</option>');

        selecionarSetor();
    }
}

$(document).ready(function() {
    $('#secretaria').change(function() {
        atualizarSetores();
    });
});

function selecionarSecretaria() {
    var selectSecretaria = document.getElementById("secretaria");
    var selectSetor = document.getElementById("setor");

    if (selectSecretaria.value !== "default") {
        selectSetor.disabled = false;
    } else {
        selectSetor.disabled = true;
    }
}

function selecionarSetor() {
    var selectSetor = document.getElementById("setor");
    var submitBtn = document.getElementById("submitBtn");

    if (selectSetor.value !== "default") {
        submitBtn.disabled = false;
    } else {
        submitBtn.disabled = true;
    }
}