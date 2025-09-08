<?php

$title = 'Expedientes';

?>

<div class="container">
    <div class="row text-center pt-5">
        <h1 align="center">EXPEDIENTES</h1>
        <div class="table-responsive">
          <table class="table table-dark table-striped">
              <thead>
                  <tr>
                  <th scope="col">DIA</th>
                  <th scope="col">ATIVO</th>
                  <th scope="col">TURNO 1</th>
                  <th scope="col">TURNO 2</th>
                  <th scope="col"></th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($expedientes as $expediente): ?>
                  <tr>
                      <td><?= htmlspecialchars($expediente['dia']) ?></td>
                      <td><?= $expediente['ativo'] ? 'Sim' : 'Não' ?></td>
                      <td><?= htmlspecialchars($expediente['inicio']) ?> até <?= htmlspecialchars($expediente['almoco']) ?></td>
                      <td><?= htmlspecialchars($expediente['retorno'])?> até <?= htmlspecialchars($expediente['termino'])?></td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <a class="p-3 btn btn-warning btn-sm btnEditarExpediente"
                          data-bs-toggle="modal"
                          data-bs-target="#modalEditarExpediente"
                          data-id="<?= $expediente['id'] ?>"
                          data-dia="<?= htmlspecialchars($expediente['dia'], ENT_QUOTES) ?>"
                          data-ativo="<?= htmlspecialchars($expediente['ativo'], ENT_QUOTES) ?>"
                          data-inicio="<?= htmlspecialchars($expediente['inicio'], ENT_QUOTES) ?>"
                          data-almoco="<?= htmlspecialchars($expediente['almoco'], ENT_QUOTES) ?>"
                          data-retorno="<?= htmlspecialchars($expediente['retorno'], ENT_QUOTES) ?>"
                          data-termino="<?= htmlspecialchars($expediente['termino'], ENT_QUOTES) ?>"
                          data-barbeiros="<?= htmlspecialchars($expediente['barbeiros'], ENT_QUOTES) ?>">
                          <i class="fa-solid fa-pen-to-square"></i>
                          </a>
                        </div>
                      </td>
                  </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="modalEditarExpediente">
  <div class="modal-dialog modal-dialog-centered m-auto">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar expediente</h5>
      </div>
      <div class="modal-body" id="modalEditarExpedienteBodyText">
        <form id="formEditarExpediente">
          <input type="hidden" id="expediente_id" name="expediente_id">
          <div class="mb-3">
            <label for="dia" class="form-label">Dia</label>
            <input type="text" class="form-control" id="dia" name="dia" disabled>
          </div>
          <div class="mb-3">
            <label for="ativo" class="form-label">Ativo</label>
            <select class="form-select" id="ativo" name="ativo" required>
              <option value="TRUE">Sim</option>
              <option value="FALSE">Não</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="inicio" class="form-label">Início</label>
            <input type="time" class="form-control" id="inicio" name="inicio" required>
          </div>
          <div class="mb-3">
            <label for="almoco" class="form-label">Almoço</label>
            <input type="time" class="form-control" id="almoco" name="almoco" required>
          </div>
          <div class="mb-3">
            <label for="retorno" class="form-label">Retorno</label>
            <input type="time" class="form-control" id="retorno" name="retorno" required>
          </div>
          <div class="mb-3">
            <label for="termino" class="form-label">Término</label>
            <input type="time" class="form-control" id="termino" name="termino" required>
          </div>
          <div class="mb-3">
            <label for="barbeiros" class="form-label">Barbeiros</label>
              <?php foreach($barbeiros as $b): ?>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" 
                        name="barbeiros[]" value="<?= $b['id'] ?>" 
                        id="barbeiro_<?= $b['id'] ?>">
                  <label class="form-check-label" for="barbeiro_<?= $b['id'] ?>">
                      <?= htmlspecialchars($b['nome']) ?>
                  </label>
                </div>
              <?php endforeach; ?>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnModalExpedienteCancelar">Fechar</button>
        <button type="button" class="btn btn-primary" id="btnModalExpedienteSalvar">Salvar</button>
      </div>
    </div>
  </div>
</div>

<script>
    function inicializarEdicaoExpediente() {
        var modal = document.getElementById('modalEditarExpediente');

        modal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // botão que abriu o modal

            var expediente_id = button.getAttribute('data-id');
            var dia = button.getAttribute('data-dia');
            var ativo = button.getAttribute('data-ativo');
            var inicio = button.getAttribute('data-inicio');
            var almoco = button.getAttribute('data-almoco');
            var retorno = button.getAttribute('data-retorno');
            var termino = button.getAttribute('data-termino');
            var barbeiros = button.getAttribute('data-barbeiros');

            modal.querySelector('#ativo').value = (ativo == 1 ? 'TRUE' : 'FALSE');
            modal.querySelector('#expediente_id').value = expediente_id;
            modal.querySelector('#dia').value = dia;
            modal.querySelector('#inicio').value = inicio;
            modal.querySelector('#almoco').value = almoco;
            modal.querySelector('#retorno').value   = retorno;
            modal.querySelector('#termino').value   = termino;
            
            var checkboxes = modal.querySelectorAll('#barbeirosContainer input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = false);

            if (barbeiros) {
              barbeiros.split(',').map(id => id.trim()).forEach(id => {
                  var checkbox = modal.querySelector('#barbeiro_' + id);
                  if (checkbox) checkbox.checked = true;
              });
            }
        });
    }

    function atualizarExpedienteService() {
        const modalEl = document.getElementById('modalEditarExpediente');
        const btnSalvar = document.getElementById('btnModalExpedienteSalvar');
        
        const dados = $('#formEditarExpediente').serialize();

        document.getElementById('modalEditarExpedienteBodyText').innerHTML = "<center><img src='/Cortai/public/assets/img/loading.gif' width='50'></img></center>";
        document.getElementById('btnModalExpedienteCancelar').style.display = 'none';
        document.getElementById('btnModalExpedienteSalvar').style.display = 'none';

        $.ajax({
            method: 'POST',
            url: '/Cortai/admin/atualizarExpedienteService',
            data: dados,
            success: function(resposta) {
                try {
                    const resultado = JSON.parse(resposta);

                    if (resultado.erro) {
                        document.getElementById('modalEditarExpedienteBodyText').innerHTML = "<p>"+resultado.erro+"</p>";
                        document.getElementById('btnModalExpedienteCancelar').style.display = 'inline';
                        const btnFechar = document.getElementById('btnModalExpedienteCancelar');

                        btnFechar.addEventListener('click', function() {
                            location.reload();
                        });
                        return;
                    }

                    setTimeout(() => {
                        document.getElementById('modalEditarExpedienteBodyText').innerHTML = "<p>Expediente atualizado com sucesso!</p>";
                        document.getElementById('btnModalExpedienteCancelar').style.display = 'inline';

                        const btnFechar = document.getElementById('btnModalExpedienteCancelar');

                        btnFechar.addEventListener('click', function() {
                            location.reload();
                        });

                    }, 1000);
                } catch(e) {
                    document.getElementById('modalEditarExpedienteBodyText').innerHTML = "<p>"+resultado.erro+"</p>";
                    document.getElementById('btnModalExpedienteCancelar').style.display = 'inline';
                    const btnFechar = document.getElementById('btnModalExpedienteCancelar');

                    btnFechar.addEventListener('click', function() {
                        location.reload();
                    });
                    console.log(e);
                }
            },
            error: function(erro) {
                alert("Erro ao editar expediente.");
                console.log(erro);
            },
            complete: function() {
                btnSalvar.disabled = false;
                loading.remove();
            }
        });
    }

    function resetarModalExpediente() {
      location.reload();
    }

    function inicializarBotaoFecharModal() {
      const btnFechar = document.getElementById('btnModalExpedienteCancelar');
      btnFechar.addEventListener('click', resetarModalExpediente);
    }

    document.addEventListener("DOMContentLoaded", function() {
      inicializarEdicaoExpediente(); // sua função original
      inicializarBotaoFecharModal();  // novo listener de reset
      document.getElementById("btnModalExpedienteSalvar")
          .addEventListener("click", atualizarExpedienteService);
    });
</script>