Olá <?= $name ?>,<br><br>
Você solicitou uma alteração de senha.<br>
Seguindo o link abaixo você poderá alterar sua senha.<br>
Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço abaixo no seu navegador.<br><br>
<?= "<a href='" . $host_name . "/users/atualizar-senha/" . $recuperar_senha . "'>Clique aqui</a><br><br>" ?>
Usuário: <?= $username ?><br><br>
Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.<br><br>

<!--http://localhost/celke/admin/users/atualizar-senha/a8f8b5ba58fd93da24071665718dc56e20663c08d5a39cc21e1aed7fe7eec892-->


