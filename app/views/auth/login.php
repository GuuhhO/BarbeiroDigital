<?php

$title = 'Login';

?>


<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh !important;">
    <div class="row w-100">
        <h1 class="text-center mb-5">LOGIN</h1>
        <form id="formLogin" class="w-100 text-center">
            <div class="mb-3 col-8 m-auto">
                <label for="usuario" class="form-label">Usuário</label>
                <input type="text" class="form-control" id="usuario" name="usuario">
            </div>
            <div class="mb-5 col-8 m-auto">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha">
            </div>
            <div class="mb-3 col-8 m-auto text-center">
                <button type="button" class="btn btn-primary" onclick="verificarCredencialService()">LOGIN</button>
            </div>
        </form>
    </div>
</div>


<script>
    function verificarCredencialService()
    {
        const dados = {
            usuario: $('#usuario').val(),
            senha: $('#senha').val()
        };

        $.ajax({
            method: 'POST',
            url: '/Cortai/auth/verificarCredencial',
            data: dados,
            success: function(resposta) {
                if (resposta.sucesso) window.location.href = '/Cortai/dashboard';
            },
            error: function(erro) {
                alert("Erro! Verifique sua credencial e tente novamente.");
            }
        });
    }
</script>