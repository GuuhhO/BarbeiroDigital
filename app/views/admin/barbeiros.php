<?php

$title = 'Barbeiros';

?>

<div class="container">
    <div class="row mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="text-start flex-grow-1">BARBEIROS</h1>
            <a type="button" data-bs-toggle="modal" data-bs-target="#modalAdicionarBarbeiro" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Adicionar
            </a>
        </div>
        <table class="table table-dark table-striped mt-5">
            <thead>
                <tr>
                <th scope="col">NOME</th>
                <th scope="col">TELEFONE</th>
                <th scope="col">ATIVO</th>
                <th scope="col">COMISSÃO</th>
                <th scope="col">SERVIÇOS</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barbeiros as $barbeiro): ?>
                <tr>
                    <td><?= htmlspecialchars($barbeiro['nome']) ?></td>
                    <td><?= htmlspecialchars($barbeiro['telefone']) ?></td>
                    <td><?= $barbeiro['ativo'] ? 'Sim' : 'Não' ?></td>
                    <td><?= htmlspecialchars($barbeiro['comissao']) ?>%</td>
                    <td>
                      <div class="btn-group" role="group" aria-label="Basic example">
                        <a class="p-3 btn btn-warning btn-sm btnEditarBarbeiro"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEditarBarbeiro"
                        data-id="<?= $barbeiro['id'] ?>"
                        data-nome="<?= htmlspecialchars($barbeiro['nome'], ENT_QUOTES) ?>"
                        data-telefone="<?= htmlspecialchars($barbeiro['telefone'], ENT_QUOTES) ?>"
                        data-ativo="<?= htmlspecialchars($barbeiro['ativo'], ENT_QUOTES) ?>"
                        data-comissao="<?= htmlspecialchars($barbeiro['comissao'], ENT_QUOTES) ?>"
                        data-servicos_id="<?= htmlspecialchars($barbeiro['servicos_id'], ENT_QUOTES) ?>">
                        Editar
                        </a>
                        <a class="p-3 btn btn-danger btn-sm btnEditarBarbeiro"
                        onclick="excluirBarbeiroService(<?= $barbeiro['id'] ?>)"
                        data-bs-toggle="modal"
                        data-bs-target="#modalExcluirBarbeiro"
                        data-id="<?= $barbeiro['id'] ?>">
                        <i class="fa-solid fa-xmark"></i></a>
                      </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal" tabindex="-1" id="modalEditarBarbeiro">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar barbeiro</h5>
      </div>
      <div class="modal-body" id="modalBodyText">
        <form id="formEditarBarbeiro">
          <input type="hidden" id="barbeiro_id" name="barbeiro_id">
          <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
          </div>
          <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" required>
          </div>
          <div class="mb-3">
            <label for="ativo" class="form-label">Ativo</label>
            <select class="form-select" id="ativo" name="ativo" required>
              <option value="TRUE">Sim</option>
              <option value="FALSE">Não</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="comissao" class="form-label">Comissão</label>
            <input type="text" class="form-control" id="comissao" name="comissao" required>
          </div>
          <div class="mb-3">
            <label for="servicos_id" class="form-label">Serviços</label>
            <input type="text" class="form-control" id="servicos_id" name="servicos_id" required>
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

<div class="modal" tabindex="-1" id="modalAdicionarBarbeiro" >
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar barbeiro</h5>
      </div>
      <div class="modal-body" id="modalAdicionarBarbeiroBodyText">
        <form id="formAdicionarBarbeiro">
          <input type="hidden" id="barbeiro_id" name="barbeiro_id">
          <div class="mb-3">
            <label for="nome" class="form-label">Barbeiro</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
          </div>
          <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" required>
          </div>
          <div class="mb-3 col-md-6 m-auto">
            <label for="ativo" class="form-label">Ativo</label>
            <select class="form-select" id="ativo" name="ativo" required>
              <option value="TRUE">Sim</option>
              <option value="FALSE">Não</option>
            </select>
          </div>
          <div class="mb-3 col-md-6 m-auto">
            <label for="comissao" class="form-label">Comissão</label>
            <div class="input-group">
              <input type="text" class="form-control" id="comissao" name="comissao" required>
              <span class="input-group-text">%</span>
            </div>
          </div>
          <div class="mb-3">
            <label for="servicos_id" class="form-label">Serviços</label>
            <input type="text" class="form-control" id="servicos_id" name="servicos_id" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnmodalAdicionarBarbeiroCancelar">Fechar</button>
        <button type="button" class="btn btn-primary" id="btnConfirmarAdicao">Salvar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" id="modalExcluirBarbeiro">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir barbeiro</h5>
      </div>
      <div class="modal-body">
        <p id="modalExcluirBarbeiroBodyText">Deseja realmente excluir o barbeiro?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnModalExcluirBarbeiroCancelar">Fechar</button>
        <button type="button" class="btn btn-danger" id="btnConfirmarExclusaoBarbeiro">Excluir</button>
      </div>
    </div>
  </div>
</div>

<script>
    function inicializarEdicaoBarbeiro() {
        var modal = document.getElementById('modalEditarBarbeiro');

        modal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // botão que abriu o modal

            var barbeiro_id = button.getAttribute('data-id');
            var nome = button.getAttribute('data-nome');
            var telefone = button.getAttribute('data-telefone');
            var ativo = button.getAttribute('data-ativo'); // "0" ou "1"
            modal.querySelector('#ativo').value = (ativo == 1 ? 'TRUE' : 'FALSE');
            var comissao = button.getAttribute('data-comissao');
            var servicos_id = button.getAttribute('data-servicos_id');

            // Converte 1/0 para TRUE/FALSE
            modal.querySelector('#ativo').value = (ativo == 1 ? 'TRUE' : 'FALSE');

            modal.querySelector('#barbeiro_id').value = barbeiro_id;
            modal.querySelector('#nome').value = nome;
            modal.querySelector('#telefone').value = telefone;
            modal.querySelector('#comissao').value   = comissao;
            modal.querySelector('#servicos_id').value   = servicos_id;
        });
    }

    function atualizarBarbeiroService() {
        const modalEl = document.getElementById('modalEditarBarbeiro');
        const btnSalvar = document.getElementById('btnConfirmarEdicao');
        
        const dados = $('#formEditarBarbeiro').serialize();

        document.getElementById('modalBodyText').innerHTML = "<center><img src='/Cortai/public/assets/img/loading.gif' width='50'></img></center>";
        document.getElementById('btnModalCancelar').style.display = 'none';
        document.getElementById('btnConfirmarEdicao').style.display = 'none';

        $.ajax({
            method: 'POST',
            url: '/Cortai/admin/atualizarBarbeiroService',
            data: dados,
            success: function(resposta) {
                try {
                    const resultado = JSON.parse(resposta);

                    if (resultado.erro) {
                        alert(resultado.erro);
                        return;
                    }

                    setTimeout(() => {
                        document.getElementById('modalBodyText').innerHTML = "<p>Barbeiro atualizado com sucesso!</p>";
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
                alert("Erro ao editar barbeiro.");
                console.log(erro);
            },
            complete: function() {
                btnSalvar.disabled = false;
                loading.remove(); // remove o loading
            }
        });
    }

    function adicionarBarbeiroService()
    {
        const modalAd = document.getElementById('modalAdicionarBarbeiro');
        const btnSalvar = document.getElementById('btnConfirmarAdicao');
        const dados = $('#formAdicionarBarbeiro').serialize();

        document.getElementById('modalAdicionarBarbeiroBodyText').innerHTML = "<center><img src='/Cortai/public/assets/img/loading.gif' width='50'></img></center>";
        document.getElementById('btnmodalAdicionarBarbeiroCancelar').style.display = 'none';
        document.getElementById('btnConfirmarAdicao').style.display = 'none';

        $.ajax({
            method: 'POST',
            url: '/Cortai/admin/adicionarBarbeiroService',
            data: dados,
            success: function(resposta) {
                try {
                    const resultado = JSON.parse(resposta);

                    if (resultado.erro) {
                        alert(resultado.erro);
                        return;
                    }

                    setTimeout(() => {
                        document.getElementById('modalAdicionarBarbeiroBodyText').innerHTML = "<p>Barbeiro adicionado com sucesso!</p>";
                        document.getElementById('btnmodalAdicionarBarbeiroCancelar').style.display = 'inline';

                        const btnFechar = document.getElementById('btnmodalAdicionarBarbeiroCancelar');

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
                alert("Erro ao editar barbeiro.");
                console.log(erro);
            },
            complete: function() {
                btnSalvar.disabled = false;
                loading.remove(); // remove o loading
            }
        });
    }

    function excluirBarbeiroService(barbeiro_id) {
        if (!barbeiro_id) {
            alert("Barbeiro inválido.");
            return;
        }

        const dados = { barbeiro_id: barbeiro_id };

        const modalEl = document.getElementById('modalExcluirBarbeiro');

        // Evita múltiplos bindings duplicados
        $('#btnConfirmarExclusaoBarbeiro').off('click').on('click', function () {
            document.getElementById('modalExcluirBarbeiroBodyText').innerHTML = "<center><img src='/Cortai/public/assets/img/loading.gif' width='50'></img></center>";
            document.getElementById('btnModalExcluirBarbeiroCancelar').style.display = 'none';
            document.getElementById('btnConfirmarExclusaoBarbeiro').style.display = 'none';

            $.ajax({
                method: 'POST',
                url: '/Cortai/admin/excluirBarbeiroService',
                data: dados,
                success: function(resposta) {
                    try {
                        const resultado = JSON.parse(resposta);

                        if (resultado.erro) {
                            alert(resultado.erro);
                            return;
                        }

                        setTimeout(() => {
                            document.getElementById('modalExcluirBarbeiroBodyText').innerHTML = "<p>Barbeiro excluído com sucesso!</p>";

                            document.getElementById('btnModalExcluirBarbeiroCancelar').style.display = 'inline';
                            document.getElementById('btnModalExcluirBarbeiroCancelar').innerHTML = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnModalCancelar">Fechar</button>';

                            const btnFechar = document.getElementById('btnModalExcluirBarbeiroCancelar');

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
                    alert("Erro ao excluir barbeiro.");
                    console.log(erro);
                }
            });
        });
    }

    // Executa quando o DOM estiver carregado
    document.addEventListener('DOMContentLoaded', inicializarEdicaoBarbeiro);

    // Botão de salvar
    document.getElementById('btnConfirmarEdicao')
    .addEventListener('click', atualizarBarbeiroService);
    
    document.getElementById('btnConfirmarAdicao')
    .addEventListener('click', adicionarBarbeiroService);

</script>