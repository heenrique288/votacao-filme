/////////////////////////////////////
//
// ÍCONE DE HAMBURGUER NO CELULAR
//
////////////////////////////////////
// Abre e fecha o menu no celular
function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.classList.toggle('menu-ativo');
}

// Abre e fecha o dropdown do perfil
function toggleDropdown() {
    const dropdown = document.getElementById('dropdownMenu');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}

// Fecha dropdown se clicar fora
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('dropdownMenu');
    const perfil = document.querySelector('.perfil');
    if (!perfil.contains(e.target)) {
        dropdown.style.display = 'none';
    }
});