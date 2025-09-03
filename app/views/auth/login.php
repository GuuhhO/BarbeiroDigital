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
                <div class="input-group">
                    <input type="password" class="form-control" id="senha" name="senha">
                    <button class="btn btn-outline-secondary" type="button" id="toggleSenha" title="Clique para exibir/esconder a senha">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3 col-8 m-auto text-center">
                <button type="submit" class="btn btn-primary" onclick="verificarCredencialService()">LOGIN</button>
            </div>
        </form>
    </div>
</div>

<script>
    function verificarCredencialService() {
        // captura o submit do form
        $('#formLogin').on('submit', function(e) {
            e.preventDefault(); // evita reload da página

            const dados = {
                usuario: $('#usuario').val(),
                senha: $('#senha').val()
            };

            $.ajax({
                method: 'POST',
                url: '/Cortai/auth/verificarCredencial',
                data: dados,
                dataType: 'json',
                success: function(resposta) {
                    if (resposta.sucesso) {
                        window.location.href = '/Cortai/admin';
                    } else {
                        alert(resposta.mensagem || "Credenciais inválidas.");
                    }
                },
                error: function(erro) {
                    alert("Erro na comunicação com o servidor. Tente novamente.");
                    console.error(erro);
                }
            });
        });
    }

    document.getElementById("toggleSenha").addEventListener("click", function () {
        const input = document.getElementById("senha");
        const icon = this.querySelector("i");

        if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
        } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
        }
    });

    // chama a função assim que a página carregar
    $(document).ready(function() {
        verificarCredencialService();
    });
</script>