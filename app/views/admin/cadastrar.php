<?php

$title = 'Cadastrar';

?>

<div class="container">
    <div class="row text-center pt-5">
        <form id="formLogar" onsubmit="cadastrarAdmin(event)">
            <div class="mb-3">
                <label for="inputUsuario" class="form-label">Usuário</label>
                <input type="text" class="form-control" id="inputUsuario" aria-describedby="Usuário">
            </div>
            <div class="mb-3">
                <label for="inputEmail" class="form-label">E-mail</label>
                <input type="text" class="form-control" id="inputEmail" aria-describedby="Usuário">
            </div>
            <div class="mb-3">
                <label for="inputSenha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="inputSenha">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
    <div class="row text-center flex align-items-center justify-content-center" id="alert">
        <div class="alert col-10 mt-5 alert-dismissible fade show" role="alert" style="display: none;">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    function cadastrarAdmin(event) {
        event.preventDefault();

        const dados = {
            usuario: $('#inputUsuario').val(),
            email: $('#inputEmail').val(),
            senha: $('#inputSenha').val(),
        };

        $.ajax({
            method: 'POST',
            url: '/Cortai/admin/cadastrarAdmin',
            data: dados,
            success: function(resposta) {
                let resultado;

                try {
                    resultado = typeof resposta === 'string' ? JSON.parse(resposta) : resposta;
                } catch (e) {
                    console.error("Erro ao interpretar resposta JSON:", e);
                    return;
                }

                const alertEl = document.getElementById('alert');
                alertEl.innerHTML = '';
                alertEl.style.display = 'block';

                if (resultado.erro) {
                    alertEl.innerHTML =
                        `<div class='alert alert-danger col-8 mt-5 alert-dismissible fade show m-auto' role='alert'>
                            ${resultado.erro}
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>`;
                    return;
                }

                // Sucesso
                $('#inputUsuario').val('');
                $('#inputEmail').val('');
                $('#inputSenha').val('');

                alertEl.innerHTML =
                    `<div class='alert alert-success col-8 mt-5 alert-dismissible fade show m-auto' role='alert'>
                        Usuário cadastrado com sucesso.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>`;
            },
            error: function(erro) {
                const alertEl = document.getElementById('alert');
                alertEl.style.display = 'block';
                alertEl.innerHTML =
                    `<div class='alert alert-danger col-8 mt-5 alert-dismissible fade show m-auto' role='alert'>
                        Ocorreu um erro ao cadastrar.<br>
                        ${erro.responseText || 'Erro desconhecido'}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>`;
                console.error(erro);
            }
        });
    }

</script>