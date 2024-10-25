$(document).ready(function () {
    // Seleciona o switch
    var switchPlaca = $('#flexSwitchCheckChecked');
    // Seleciona o input da placa
    var inputPlaca = $('#placa');

    // Adiciona um listener para o evento change do switch
    switchPlaca.change(function () {
        // Verifica se o switch está marcado
        if (this.checked) {
            // Aplica a máscara AAA-9A99
            inputPlaca.inputmask('AAA-9A99');
        } else {
            // Aplica a máscara AAA-9999
            inputPlaca.inputmask('AAA-9999');
        }
    });

    // Inicializa a máscara com o formato AAA-9A99
    inputPlaca.inputmask('AAA-9A99');
});
