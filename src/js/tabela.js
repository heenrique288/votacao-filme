function abrirPopup(usuarioId) {
    fetch("get_filme_tmdb.php?id=" + usuarioId)
    .then(response => response.json())
    .then(data => {
        if(data.length === 0){
            Swal.fire({
                icon: 'info',
                title: 'Nenhum filme encontrado',
                text: 'Este usuário não possui filmes cadastrados.',
                confirmButtonText: 'Fechar',
                background: '#333',
                color: '#ffffff'
            });
            return;
        }

        // Monta o HTML com estilo customizado
        let html = "";
        data.forEach(filme => {
            html += `
                <div style="
                    display: flex;
                    background-color: #333;
                    gap: 15px; 
                    margin-bottom: 15px; 
                    align-items: center;
                    border-bottom: 1px solid #ccc; 
                    padding-bottom: 10px;">
                    <img src="${filme.banner}" width="120" style="border-radius: 8px; object-fit: cover;">
                    <div style="max-width: 500px;">
                        <strong style="font-size: 23px; color: #daa520;">${filme.titulo}</strong>
                        <p style="font-size: 15px; color: #ffffff; margin: 20px 0 10px 20px; line-height: 2; text-align: justify">${filme.sinopse}</p>
                    </div>
                </div>
            `;
        });

        Swal.fire({
            title: '<span style="color:#daa520; display:block; margin-bottom: 50px; ">Filmes do usuário</span>',
            html: html,
            width: 800,             // largura do pop-up
            padding: '30px',        // padding interno
            background: '#333',     // cor de fundo
            color: '#ffffff',          // cor do texto
            showCloseButton: true,  // botão de fechar no canto
            confirmButtonText: 'Fechar',
            confirmButtonColor: '#3085d6',
            scrollbarPadding: false,
            customClass: {
                popup: 'meu-popup-personalizado'
            },
            didOpen: () => {
                document.body.style.overflow = 'hidden';
                document.documentElement.style.overflow = 'hidden'; // ✅ bloqueia também html
            },
            willClose: () => {
                document.body.style.overflow = '';
                document.documentElement.style.overflow = '';        // ✅ libera scroll novamente
            }
        });
    });
}