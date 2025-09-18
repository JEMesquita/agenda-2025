/*  adicionar_usuario.php

    Página para adicionar novos usuários ao sistema.
    1. Verifique se o usuário logado é Administrador ou Suporte.
    2. Exiba um formulário para inserir nome, email, senha e perfil do novo usuário.
    3. No envio do formulário, valide os dados e insira o novo usuário no banco de dados.
    4. Redirecione de volta ao dashboard com uma mensagem de sucesso ou erro.               
Se quiser permitir que Administradores e Suporte criem novos usuários, crie um formulário semelhante ao de edição, mas sem o id, e com as mesmas regras de perfil.

Exemplo de validação no POST:

if ($_SESSION['perfil'] == 'Administrador' && ($perfil == 'Suporte' || $perfil == 'Desenvolvimento')) {
    $erro = "Você não pode criar usuários com este perfil.";
}

Passo 1: Atualizar dashboard.php — Adicionar link condicional para gerenciar usuários */

        <?php if ($_SESSION['perfil'] == 'Administrador' || $_SESSION['perfil'] == 'Suporte'): ?>
            <p><a href="gerenciar_usuarios.php">👥 Gerenciar Usuários</a></p>
        <?php endif; ?>
*/

