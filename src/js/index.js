document.addEventListener("DOMContentLoaded", () => {
  const perfilIcon = document.getElementById('perfilIcon');
  const dropdownMenu = document.getElementById('dropdownMenu');

  if (perfilIcon && dropdownMenu) {
      perfilIcon.addEventListener('click', (e) => {
          e.stopPropagation(); // evita fechar imediatamente
          dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
      });

      window.addEventListener('click', (e) => {
          if (!dropdownMenu.contains(e.target)) {
              dropdownMenu.style.display = 'none';
          }
      });
  }
});
