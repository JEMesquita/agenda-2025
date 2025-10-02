// script.js

function openModal(url, title = "Editar Registro") {
    const modal = document.getElementById('modal');
    const modalTitle = document.getElementById('modal-title');
    const modalBody = document.getElementById('modal-body');

    modalTitle.innerText = title;
    modalBody.innerHTML = '<div style="text-align:center; padding:20px;"><img src="https://i.imgur.com/JNZdL8A.gif" width="40" alt="Carregando..."></div>';

    fetch(url)
        .then(response => response.text())
        .then(html => {
            modalBody.innerHTML = html;
            modal.style.display = 'block';
        })
        .catch(err => {
            modalBody.innerHTML = '<p style="color:red;">Erro ao carregar.</p>';
        });
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

function confirmDelete(id, nome) {
    const modal = document.getElementById('confirm-modal');
    const message = document.getElementById('confirm-message');
    const confirmBtn = document.getElementById('confirm-btn');

    message.innerHTML = `Tem certeza que deseja excluir a vara <strong>${nome}</strong>? Esta ação não pode ser desfeita.`;
    confirmBtn.onclick = function () {
        fetch(`delete_agenda.php?id=${id}`)
            .then(() => {
                location.reload(); // recarrega a página após exclusão
            })
            .catch(err => alert('Erro ao excluir.'));
    };

    modal.style.display = 'block';
}

function closeConfirmModal() {
    document.getElementById('confirm-modal').style.display = 'none';
}

 body {
    margin: 0;
    padding: 0;
    display: flex;
    justify - content: center;
    align - items: center;
    height: 100vh;
    background: linear - gradient(to bottom, #008000, #ffffff);
}
        .splash {
    text - align: center;
}
        .splash img {
    width: 500px;
    margin - bottom: 30px;
}
        .splash p {
    font - size: 18px;
    color: #333;
}