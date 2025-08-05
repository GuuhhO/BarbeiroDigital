<?php

$title = 'Login do Administrador';

?>

<div class="container">
    <div class="row text-center pt-5">
        <h1 align="center">LOGIN</h1>
        <form id="formLogar" onsubmit="logarAdmin(event)">
            <div class="mb-3">
                <label for="inputUsuario" class="form-label">Usuário</label>
                <input type="text" class="form-control" id="inputUsuario" aria-describedby="Usuário">
            </div>
            <div class="mb-3">
                <label for="inputSenha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="inputSenha">
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
    </div>
</div>

<script>
    function logarAdmin(event) {
        event.preventDefault();

        const dados = {
            usuario: $('#inputUsuario').val(),
            senha: $('#inputSenha').val(),
        };

        $.ajax({
            method: 'POST',
            url: '/Cortai/admin/logar',
            data: dados,
            success: function(resposta) {
                window.location.href = "<?= BASE_URL ?>admin/Painel";
            },
            error: function(erro) {
                alert("Erro ao verificar horários.");
                console.log(erro);
            }
        });
    }
</script>