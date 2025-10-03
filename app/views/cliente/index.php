<?php

$title = 'Painel do Cliente';

?>

<div class="container">
    <div class="row pt-5 pb-5">
        <H1 align="center">MEU PAINEL</H1>
    </div>
    <div class="row flex align-items-center justify-content-center text-center">
        <h3>AGENDAMENTOS</h3>
        <table class="table table-dark table-striped mt-3">
            <thead>
                <tr>
                <th scope="col">Dia</th>
                <th scope="col">Horário</th>
                <th scope="col">Serviço</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="tBodyAgendamentos">
                <?php if (!empty($agendamentos)): ?>
                    <?php foreach ($agendamentos as $agendamento): ?>
                        <tr id="<?=  $agendamento['id'] ?>">
                            <th scope="row">
                                <?= htmlspecialchars(
                                    date('d/m/Y', strtotime($agendamento['dia'] ?? ''))
                                ) ?>
                            </th>
                            <td>
                                <?= htmlspecialchars(
                                    substr($agendamento['horario'] ?? '', 0, 5)
                                ) ?>
                            </td>
                            <td><?= htmlspecialchars($servicos[$agendamento['servico_id']] ?? 'Desconhecido') ?></td>
                            <td>
                                <a class="btn btn-danger"
                                onclick="excluirAgendamentoService(<?= (int)$agendamento['id'] ?>)">
                                Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Nenhum agendamento encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal" tabindex="-1" id="modalExcluirAgendamento">
  <div class="modal-dialog modal-dialog-centered m-auto">
    <div class="modal-content">
      <div class="modal-body">
        <p id="modalBodyText">Deseja realmente excluir a sua reserva?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnModalCancelar">Cancelar</button>
        <button type="button" class="btn btn-danger" id="confirmarExclusao">Excluir</button>
      </div>
    </div>
  </div>
</div>


<script>
    function excluirAgendamentoService(agendamento_id) {
        if (!agendamento_id) {
            alert("Agendamento inválido.");
            return;
        }

        const dados = { agendamento_id: agendamento_id };

        const modalEl = document.getElementById('modalExcluirAgendamento');
        modalEl.removeAttribute('aria-hidden'); // Remove atributo inválido antes de abrir
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        // Evita múltiplos bindings duplicados
        $('#confirmarExclusao').off('click').on('click', function () {
            document.getElementById('modalBodyText').innerHTML = "<center><img src='/BarbeiroDigital/public/assets/img/loading.gif' width='50'></img></center>";
            document.getElementById('btnModalCancelar').style.display = 'none';
            document.getElementById('confirmarExclusao').style.display = 'none';

            $.ajax({
                method: 'POST',
                url: '/BarbeiroDigital/Cliente/excluirAgendamento',
                data: dados,
                success: function(resposta) {
                    try {
                        const resultado = JSON.parse(resposta);

                        if (resultado.erro) {
                            alert(resultado.erro);
                            return;
                        }

                        setTimeout(() => {
                            document.getElementById('modalBodyText').innerHTML = "<p>Agendamento excluído com sucesso!</p>";

                            // Remove visualmente a linha da tabela
                            const linha = document.getElementById(agendamento_id);
                            if (linha) linha.remove();

                            document.getElementById('btnModalCancelar').style.display = 'inline';
                            document.getElementById('btnModalCancelar').innerHTML = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnModalCancelar">Fechar</button>';
                        }, 1000);

                        const tbody = document.getElementById('tBodyAgendamentos');
                        if (tbody.children.length === 0) {
                            const linhaVazia = document.createElement('tr');
                            const coluna = document.createElement('td');
                            coluna.colSpan = 4;
                            coluna.className = "text-center text-muted";
                            coluna.textContent = "Nenhum agendamento encontrado.";
                            linhaVazia.appendChild(coluna);
                            tbody.appendChild(linhaVazia);
                        }

                    } catch (e) {
                        alert("Erro ao interpretar resposta do servidor.");
                        console.log(e);
                    }
                },
                error: function(erro) {
                    alert("Erro ao excluir agendamento.");
                    console.log(erro);
                }
            });
        });
    }

</script>