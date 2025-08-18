<?php

$title = 'Serviços';

?>

<div class="container">
    <div class="row mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="text-start flex-grow-1">SERVIÇOS</h1>
            <a type="button" data-bs-toggle="modal" data-bs-target="#modalAdicionarServico" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Adicionar
            </a>
        </div>
        <table class="table table-dark table-striped mt-5">
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
                      <div class="btn-group" role="group" aria-label="Basic example">
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
                        <a class="p-3 btn btn-danger btn-sm btnEditarServico"
                        onclick="excluirServicoService(<?= $servico['id'] ?>)"
                        data-bs-toggle="modal"
                        data-bs-target="#modalExcluirServico"
                        data-id="<?= $servico['id'] ?>">
                        <i class="fa-solid fa-xmark"></i></a>
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
      <div class="modal-body" id="modalBodyText">
        <form id="formEditarServico">
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnModalCancelar">Fechar</button>
        <button type="button" class="btn btn-primary" id="btnConfirmarEdicao">Salvar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" id="modalAdicionarServico">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar serviço</h5>
      </div>
      <div class="modal-body" id="modalAdicionarServicoBodyText">
        <form id="formAdicionarServico">
          <input type="hidden" id="servico_id" name="servico_id">
          <div class="mb-3">
            <label for="servico" class="form-label">Serviço</label>
            <input type="text" class="form-control" id="servico" name="servico" required>
          </div>
          <div class="mb-3">
            <label for="duracao" class="form-label">Duração</label>
            <input type="time" class="form-control" id="duracao" name="duracao" step="900" required>
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
            <input type="text" class="form-control" data-mask="00.00"id="preco" name="preco" placeholder="R$ 0.00" required>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnModalAdicionarServicoCancelar">Fechar</button>
        <button type="button" class="btn btn-primary" id="btnConfirmarAdicao">Salvar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" id="modalExcluirServico">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir serviço</h5>
      </div>
      <div class="modal-body">
        <p id="modalExcluirServicoBodyText">Deseja realmente excluir o serviço?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnModalExcluirServicoCancelar">Fechar</button>
        <button type="button" class="btn btn-danger" id="btnConfirmarExclusaoServico">Excluir</button>
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
        const modalEl = document.getElementById('modalEditarServico');
        const btnSalvar = document.getElementById('btnConfirmarEdicao');
        
        const dados = $('#formEditarServico').serialize();

        document.getElementById('modalBodyText').innerHTML = "<center><img src='/Cortai/public/assets/img/loading.gif' width='50'></img></center>";
        document.getElementById('btnModalCancelar').style.display = 'none';
        document.getElementById('btnConfirmarEdicao').style.display = 'none';

        $.ajax({
            method: 'POST',
            url: '/Cortai/admin/atualizarServico',
            data: dados,
            success: function(resposta) {
                try {
                    const resultado = JSON.parse(resposta);

                    if (resultado.erro) {
                        alert(resultado.erro);
                        return;
                    }

                    setTimeout(() => {
                        document.getElementById('modalBodyText').innerHTML = "<p>Serviço atualizado com sucesso!</p>";
                        document.getElementById('btnModalCancelar').style.display = 'inline';

                        const btnFechar = document.getElementById('btnModalCancelar');

                        btnFechar.addEventListener('click', function() {
                            location.reload();
                        });

                    }, 1000);

                } catch(e) {
                    alert("Erro ao interpretar resposta do servidor.");
                    console.log(e);
                }
            },
            error: function(erro) {
                alert("Erro ao editar serviço.");
                console.log(erro);
            },
            complete: function() {
                btnSalvar.disabled = false;
                loading.remove(); // remove o loading
            }
        });
    }

    function adicionarServicoService()
    {
        const modalAd = document.getElementById('modalAdicionarServico');
        const btnSalvar = document.getElementById('btnConfirmarAdicao');
        const dados = $('#formAdicionarServico').serialize();

        document.getElementById('modalAdicionarServicoBodyText').innerHTML = "<center><img src='/Cortai/public/assets/img/loading.gif' width='50'></img></center>";
        document.getElementById('btnModalAdicionarServicoCancelar').style.display = 'none';
        document.getElementById('btnConfirmarAdicao').style.display = 'none';

        $.ajax({
            method: 'POST',
            url: '/Cortai/admin/adicionarServicoService',
            data: dados,
            success: function(resposta) {
                try {
                    const resultado = JSON.parse(resposta);

                    if (resultado.erro) {
                        alert(resultado.erro);
                        return;
                    }

                    setTimeout(() => {
                        document.getElementById('modalAdicionarServicoBodyText').innerHTML = "<p>Serviço adicionado com sucesso!</p>";
                        document.getElementById('btnModalAdicionarServicoCancelar').style.display = 'inline';

                        const btnFechar = document.getElementById('btnModalAdicionarServicoCancelar');

                        btnFechar.addEventListener('click', function() {
                            location.reload();
                        });

                    }, 1000);

                } catch(e) {
                    alert("Erro ao interpretar resposta do servidor.");
                    console.log(e);
                }
            },
            error: function(erro) {
                alert("Erro ao editar serviço.");
                console.log(erro);
            },
            complete: function() {
                btnSalvar.disabled = false;
                loading.remove(); // remove o loading
            }
        });
    }

    function excluirServicoService(servico_id) {
        if (!servico_id) {
            alert("Serviço inválido.");
            return;
        }

        const dados = { servico_id: servico_id };

        const modalEl = document.getElementById('modalExcluirServico');
        modalEl.removeAttribute('aria-hidden'); // Remove atributo inválido antes de abrir
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        // Evita múltiplos bindings duplicados
        $('#btnConfirmarExclusaoServico').off('click').on('click', function () {
            document.getElementById('modalExcluirServicoBodyText').innerHTML = "<center><img src='/Cortai/public/assets/img/loading.gif' width='50'></img></center>";
            document.getElementById('btnModalExcluirServicoCancelar').style.display = 'none';
            document.getElementById('btnConfirmarExclusaoServico').style.display = 'none';

            $.ajax({
                method: 'POST',
                url: '/Cortai/admin/excluirServicoService',
                data: dados,
                success: function(resposta) {
                    try {
                        const resultado = JSON.parse(resposta);

                        if (resultado.erro) {
                            alert(resultado.erro);
                            return;
                        }

                        setTimeout(() => {
                            document.getElementById('modalExcluirServicoBodyText').innerHTML = "<p>Agendamento excluído com sucesso!</p>";

                            document.getElementById('btnModalExcluirServicoCancelar').style.display = 'inline';
                            document.getElementById('btnModalExcluirServicoCancelar').innerHTML = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnModalCancelar">Fechar</button>';

                            const btnFechar = document.getElementById('btnModalExcluirServicoCancelar');

                            btnFechar.addEventListener('click', function() {
                            location.reload();
                        });
                        }, 1000);

                    } catch (e) {
                        alert("Erro ao interpretar resposta do servidor.");
                        console.log(e);
                    }
                },
                error: function(erro) {
                    alert("Erro ao excluir serviço.");
                    console.log(erro);
                }
            });
        });
    }

    // Executa quando o DOM estiver carregado
    document.addEventListener('DOMContentLoaded', inicializarEdicaoServico);

    // Botão de salvar
    document.getElementById('btnConfirmarEdicao')
    .addEventListener('click', atualizarServicoService);
    
    document.getElementById('btnConfirmarAdicao')
    .addEventListener('click', adicionarServicoService);

</script>