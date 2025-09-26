document.addEventListener("DOMContentLoaded", () => {
    const fileInput = document.getElementById('file-upload');
    const preview = document.getElementById('preview');
    const icon = document.querySelector('.profile-pic i');

    if (fileInput && preview) {
        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    preview.src = reader.result;
                    preview.style.display = "block";
                    if (icon) icon.style.display = "none"; // esconde o ícone se existir
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Toast de notificações (se existir)
    const toast = document.getElementById('toast');
    if (toast && toast.textContent.trim() !== "") {
        toast.style.display = "block";
        setTimeout(() => {
            toast.classList.add("show");
        }, 100);

        setTimeout(() => {
            toast.classList.remove("show");
            setTimeout(() => toast.style.display = "none", 500);
        }, 3000);
    }
});

function toggleSenha() {
  const input = document.getElementById("senha");
  const icon = document.querySelector(".toggle-senha i");

  if (input.type === "password") {
    input.type = "text";
    icon.classList.remove("fa-eye");
    icon.classList.add("fa-eye-slash");
  } else {
    input.type = "password";
    icon.classList.remove("fa-eye-slash");
    icon.classList.add("fa-eye");
  }
}

