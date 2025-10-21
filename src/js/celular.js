/////////////////////////////////////
//
// ÍCONE DE HAMBURGUER NO CELULAR
//
////////////////////////////////////
const menuToggle = document.querySelector('.menu-toggle');
const menu = document.querySelector('header > ul');

// cria overlay dinamicamente
const overlay = document.createElement('div');
overlay.classList.add('overlay');
document.body.appendChild(overlay);

function toggleMenu() {
  menu.classList.toggle('menu-ativo');
  overlay.classList.toggle('ativo');
}

// abre/fecha ao clicar no hambúrguer
menuToggle.addEventListener('click', toggleMenu);

// fecha ao clicar fora
overlay.addEventListener('click', toggleMenu);
