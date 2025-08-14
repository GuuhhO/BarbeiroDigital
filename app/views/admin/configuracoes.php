<?php

$title = 'Configurações';

?>

<div class="container">
    <div class="row mt-5">
        <h1 align="center">SERVIÇOS</h1>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                <th scope="col">SERVIÇO</th>
                <th scope="col">DURAÇÃO</th>
                <th scope="col">ATIVO</th>
                <th scope="col">PREÇO</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($servicos as $servico): ?>
                <tr>
                    <td><?= htmlspecialchars($servico['servico']) ?></td>
                    <td><?= htmlspecialchars($servico['duracao']) ?></td>
                    <td><?= $servico['ativo'] ? 'Sim' : 'Não' ?></td>
                    <td><?= 'R$ ' . number_format($servico['preco'], 2, ',', '.') ?></td>
                    <td>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="p-3 btn btn-warning btn-sm btnEditarServico"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEditarServico"
                            data-id="<?= $servico['id'] ?>"
                            data-servico="<?= htmlspecialchars($servico['servico'], ENT_QUOTES) ?>"
                            data-duracao="<?= htmlspecialchars($servico['duracao'], ENT_QUOTES) ?>"
                            data-ativo="<?= htmlspecialchars($servico['ativo'], ENT_QUOTES) ?>"
                            data-preco="<?= htmlspecialchars($servico['preco'], ENT_QUOTES) ?>">
                            Editar
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal" tabindex="-1" id="modalEditarServico">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar serviço</h5>
            </div>
            <div class="modal-body">
                <form id="formEditarAgendamento">
                    <!-- Campo hidden dentro do formulário -->
                    <input type="hidden" id="servico_id" name="servico_id">
                    <div class="mb-3">
                        <label for="servico" class="form-label">Serviço</label>
                        <input type="text" class="form-control" id="servico" name="servico" required>
                    </div>
                    <div class="mb-3">
                        <label for="duracao" class="form-label">Duração</label>
                        <input type="text" class="form-control" id="duracao" name="duracao" required>
                    </div>
                    <div class="mb-3">
                        <label for="ativo" class="form-label">Ativo</label>
                        <select class="form-select" id="ativo" name="ativo" required>
                            <option value="TRUE">Sim</option>
                            <option value="FALSE">Não</option>
                        </select>

                    </div>
                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço</label>
                        <input type="text" class="form-control" id="preco" name="preco" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarEdicao">Salvar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function inicializarEdicaoServico() {
        var modal = document.getElementById('modalEditarServico');

        modal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // botão que abriu o modal

            var servico_id = button.getAttribute('data-id');
            var servico = button.getAttribute('data-servico');
            var duracao = button.getAttribute('data-duracao');
            var ativo = button.getAttribute('data-ativo'); // "0" ou "1"
            modal.querySelector('#ativo').value = (ativo == 1 ? 'TRUE' : 'FALSE');
            var preco = button.getAttribute('data-preco');
            modal.querySelector('#preco').value = Number(preco).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            // Converte 1/0 para TRUE/FALSE
            modal.querySelector('#ativo').value = (ativo == 1 ? 'TRUE' : 'FALSE');

            modal.querySelector('#servico_id').value = servico_id;
            modal.querySelector('#servico').value = servico;
            modal.querySelector('#duracao').value = duracao;
            modal.querySelector('#preco').value   = preco;
        });
    }

    function atualizarServicoService() {
        var precoInput = document.getElementById('preco').value;
        // Substitui vírgula por ponto para o banco
        var preco = precoInput.replace(',', '.');
        
        var dados = $('#formEditarAgendamento').serialize(); // pega todos os inputs

        console.log(dados);

        $.ajax({
            method: 'POST',
            url: '/Cortai/admin/atualizarServico',
            data: dados,
            success: function(resposta) {
                alert("Serviço atualizado com sucesso.");
                location.reload();
            },
            error: function(erro) {
                alert("Erro ao atualizar serviço.");
                console.log(erro);
            }
        });
    }


    // Executa quando o DOM estiver carregado
    document.addEventListener('DOMContentLoaded', inicializarEdicaoServico);

    // Botão de salvar
    document.getElementById('btnConfirmarEdicao')
        .addEventListener('click', atualizarServicoService);

</script>