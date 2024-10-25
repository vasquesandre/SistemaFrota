document.addEventListener("DOMContentLoaded", function() {
    // Obtém o caminho da página atual
    var path = window.location.pathname;

    // Remove a classe 'active' de todos os itens do menu
    var menuItems = document.querySelectorAll('.pagina');
    menuItems.forEach(function(item) {
        item.classList.remove('active');
    });

    // Remove as classes 'active' e 'open' das dropdowns de página
    var dropdowns = document.querySelectorAll('.pagina-dropdown');
    dropdowns.forEach(function(dropdown) {
        dropdown.classList.remove('active');
        dropdown.classList.remove('open');
    });

    // Adiciona a classe 'active' ao item de menu correspondente à página atual
    var activeMenuItem = document.querySelector('a[href="' + path + '"]');
    if (activeMenuItem) {
        var menuItem = activeMenuItem.closest('.pagina');
        menuItem.classList.add('active');

        // Adiciona as classes 'active' e 'open' à dropdown de página pai do item de menu
        var parentDropdown = menuItem.closest('.pagina-dropdown');
        if (parentDropdown) {
            parentDropdown.classList.add('active');
            parentDropdown.classList.add('open');
        }
    }
});
