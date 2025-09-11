<?php

$title = 'Agendamentos';

?>

<div class="container">
    <div class="row mt-5 m-auto">
        <h1 align="center">AGENDAMENTOS</h1>
        <div class="table-responsive">
            <table class="table table-dark table-striped" id="tabelaAgendamentos">
                <thead>
                    <tr>
                    <th scope="col">CLIENTE</th>
                    <th scope="col">DATA</th>
                    <th scope="col">SERVIÇO</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agendamentos as $agendamento): 
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($agendamento['cliente']) ?></td>
                            <td><?= date("d/m/Y", strtotime($agendamento['dia'])) ?> <?= htmlspecialchars($agendamento['horario']) ?></td>
                            <td><?= htmlspecialchars($agendamento['servico_nome']) ?></td>
                            <td>
                                
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-warning btn-sm btnEditarAgendamento dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Ação
                                        </button>
                                        <ul class="dropdown-menu" style="padding: 0px; border-radius: 0px;">
                                            <li id="dropdownAcoesAgendamento">
                                                <a class="dropdown-item btnEditarAgendamento"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditarAgendamento"
                                                data-id="<?= $agendamento['id'] ?>"
                                                data-cliente="<?= htmlspecialchars($agendamento['cliente'], ENT_QUOTES) ?>"
                                                data-telefone="<?= htmlspecialchars($agendamento['telefone'], ENT_QUOTES) ?>"
                                                data-servico="<?= htmlspecialchars($agendamento['servico_id'], ENT_QUOTES) ?>"
                                                data-dia="<?= htmlspecialchars($agendamento['dia'], ENT_QUOTES) ?>"
                                                data-horario="<?= htmlspecialchars($agendamento['horario'], ENT_QUOTES) ?>"
                                                style="cursor: pointer">
                                                Editar</a>
                                            </li>
                                            <li id="dropdownAcoesAgendamento">
                                                <a id="TrocarHorario"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditarHorarioAgendamento"
                                                class="dropdown-item btnEditarAgendamento"
                                                data-id="<?= $agendamento['id'] ?>"
                                                data-cliente="<?= htmlspecialchars($agendamento['cliente'], ENT_QUOTES) ?>"
                                                data-telefone="<?= htmlspecialchars($agendamento['telefone'], ENT_QUOTES) ?>"
                                                data-servico="<?= htmlspecialchars($agendamento['servico_id'], ENT_QUOTES) ?>"
                                                data-dia="<?= htmlspecialchars($agendamento['dia'], ENT_QUOTES) ?>"
                                                data-horario="<?= htmlspecialchars($agendamento['horario'], ENT_QUOTES) ?>"
                                                style="cursor: pointer"
                                                onclick="editarHorarioAgendamento(this)">
                                                Mudar Horário</a>
                                            </li>
                                            <li id="dropdownAcoesAgendamento">
                                                <a data-bs-toggle="modal"
                                                data-bs-target="#modalExcluirAgendamento"
                                                class="dropdown-item btnRemoverAgendamento"
                                                data-id="<?= (int) $agendamento['id'] ?>"
                                                style="cursor: pointer">
                                                Remover</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row m-auto">
        <?php if (isset($totalPaginas) && $totalPaginas > 1): ?>
            <nav aria-label="Navegação de página">
                <ul class="pagination justify-content-center">

                    <!-- Botão Anterior -->
                    <li class="page-item <?= ($pagina <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $pagina - 1 ?>" tabindex="-1">&laquo;</a>
                    </li>

                    <!-- Números -->
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <li class="page-item <?= ($i == $pagina) ? 'active' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Botão Próximo -->
                    <li class="page-item <?= ($pagina >= $totalPaginas) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $pagina + 1 ?>">&raquo;</a>
                    </li>

                </ul>
            </nav>
        <?php endif; ?>
    </div>
    <hr>
</div>

<div class="modal" tabindex="-1" id="modalEditarAgendamento">
    <div class="modal-dialog modal-dialog-centered m-auto">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar agendamento</h5>
            </div>
            <div class="modal-body" id="modalEditarAgendamentoBodyText">
                <form id="formEditarAgendamento">
                    <input type="hidden" id="agendamento_id" name="agendamento_id">
                    <div class="mb-3">
                        <label for="cliente" class="form-label">Cliente</label>
                        <input type="text" class="form-control" id="cliente" name="cliente" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" required>
                    </div>
                    <div class="mb-3">
                        <label for="servico" class="form-label">Serviço</label>
                        <select class="form-control" id="servico" name="servico_id" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($servicos as $servico): ?>
                                <option value="<?= htmlspecialchars($servico['id']) ?>">
                                    <?= htmlspecialchars($servico['servico']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnModalEditarAgendamentoCancelar">Fechar</button>
                <button type="button" class="btn btn-primary" id="btnModalEditarAgendamentoSalvar">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalSelecionarHorario" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered m-auto">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Alterar horário de atendimento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body" id="modalEditarHorarioAgendamentoBodyText">
        <div class="container text-center">

            <input type="hidden" id="agendamento_id" name="agendamento_id">
            <input type="hidden" id="cliente" name="cliente">
            <input type="hidden" id="telefone" name="telefone">
            <input type="hidden" id="servico" name="servico">
            <input type="hidden" id="dia" name="dia">

            <label for=""><b>Dia selecionado:</b></label>
            <br>
            <p id="modalBodyExibirDia"></p>   
            <label class="form-label">Horários disponíveis:</label>
            <div class="row row-cols-auto justify-content-center" id="containerHorarios">
                <!-- caixas serão geradas aqui -->
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnModalEditarHorarioAgendamentoCancelar">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="atualizarHorarioAgendamentoService()" id="btnModalEditarHorarioAgendamentoSalvar">Re-agendar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" id="modalExcluirAgendamento">
  <div class="modal-dialog modal-dialog-centered m-auto">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir agendamento</h5>
      </div>
      <div class="modal-body">
        <p id="modalExcluirAgendamentoBodyText">Deseja realmente excluir o agendamento?</p>
        <form id="formExcluirAgendamento" style="display: none;">
            <input type="hidden" id="agendamento_id" name="agendamento_id">
            <div class="mb-3">
                <label for="cliente" class="form-label">Cliente</label>
                <input type="text" class="form-control" id="cliente" name="cliente" disabled>
            </div>
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" disabled>
            </div>
            <div class="mb-3">
                <label for="servico" class="form-label">Serviço</label>
                <select class="form-control" id="servico" name="servico_id" disabled>
                    <option value="">Selecione...</option>
                    <?php foreach ($servicos as $servico): ?>
                        <option value="<?= htmlspecialchars($servico['id']) ?>">
                            <?= htmlspecialchars($servico['servico']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCancelarExclusaoAgendamento">Fechar</button>
        <button type="button" class="btn btn-danger" id="btnConfirmarExclusaoAgendamento">Excluir</button>
      </div>
    </div>
  </div>
</div>

<script>
    function inicializarEdicaoAgendamento() {
        var modal = document.getElementById('modalEditarAgendamento');

        modal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;

            var agendamento_id = button.getAttribute('data-id');
            var cliente        = button.getAttribute('data-cliente');
            var telefone       = button.getAttribute('data-telefone');
            var servico_id     = button.getAttribute('data-servico');

            modal.querySelector('#agendamento_id').value = agendamento_id;
            modal.querySelector('#cliente').value        = cliente;
            modal.querySelector('#telefone').value       = telefone;
            modal.querySelector('#servico').value        = servico_id;
        });
    }

    function inicializarRemocaoAgendamento() {
        var modal = document.getElementById('modalExcluirAgendamento');

        modal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;

            var agendamento_id = button.getAttribute('data-id');
            var cliente        = button.getAttribute('data-cliente');
            var telefone       = button.getAttribute('data-telefone');
            var servico_id     = button.getAttribute('data-servico');

            modal.querySelector('#agendamento_id').value = agendamento_id;
            modal.querySelector('#cliente').value        = cliente;
            modal.querySelector('#telefone').value       = telefone;
            modal.querySelector('#servico').value        = servico_id;
        });
    }

    function editarAgendamentoService()
    {
        const modalEl = document.getElementById('modalEditarAgendamento');
        const btnSalvar = document.getElementById('btnModalEditarAgendamentoSalvar');

        const dados = $('#formEditarAgendamento').serialize();

        document.getElementById('modalEditarAgendamentoBodyText').innerHTML = "<center><img src='/Cortai/public/assets/img/loading.gif' width='50'></img></center>";
        document.getElementById('btnModalEditarAgendamentoCancelar').style.display = 'none';
        document.getElementById('btnModalEditarAgendamentoSalvar').style.display = 'none';

        $.ajax({
            method: 'POST',
            url: '/Cortai/admin/editarAgendamentoService',
            data: dados,
            success: function(resposta) {
                try {
                    const resultado = JSON.parse(resposta);

                    if (resultado.erro) {
                        document.getElementById('modalEditarAgendamentoBodyText').innerHTML = "<p>"+resultado.erro+"</p>";
                        document.getElementById('btnModalEditarAgendamentoCancelar').style.display = 'inline';
                        const btnFechar = document.getElementById('btnModalEditarAgendamentoCancelar');

                        btnFechar.addEventListener('click', function() {
                            location.reload();
                        });
                        return;
                    }

                    setTimeout(() => {
                        document.getElementById('modalEditarAgendamentoBodyText').innerHTML = "<p>Agendamento atualizado com sucesso!</p>";
                        document.getElementById('btnModalEditarAgendamentoCancelar').style.display = 'inline';

                        const btnFechar = document.getElementById('btnModalEditarAgendamentoCancelar');

                        btnFechar.addEventListener('click', function() {
                            location.reload();
                        });

                    }, 1000);
                } catch(e) {
                    document.getElementById('modalEditarAgendamentoBodyText').innerHTML = "<p>"+resultado.erro+"</p>";
                    document.getElementById('btnModalEditarAgendamentoCancelar').style.display = 'inline';
                    const btnFechar = document.getElementById('btnModalEditarAgendamentoCancelar');

                    btnFechar.addEventListener('click', function() {
                        location.reload();
                    });
                    console.log(e);
                }
            },
            error: function(erro) {
                alert("Erro ao editar agendamento.");
                console.log(erro);
            },
            complete: function() {
                btnSalvar.disabled = false;
            }
        });
    }

    function removerAgendamentoService()
    {
        const modalEl = document.getElementById('modalExcluirAgendamento');
        const btnSalvar = document.getElementById('btnConfirmarExclusaoAgendamento');

        const dados = $('#formExcluirAgendamento').serialize();

        document.getElementById('modalExcluirAgendamentoBodyText').innerHTML = "<center><img src='/Cortai/public/assets/img/loading.gif' width='50'></img></center>";
        document.getElementById('btnCancelarExclusaoAgendamento').style.display = 'none';
        document.getElementById('btnConfirmarExclusaoAgendamento').style.display = 'none';

        $.ajax({
            method: 'POST',
            url: '/Cortai/admin/removerAgendamentoService',
            data: dados,
            success: function(resposta) {
                try {
                    const resultado = JSON.parse(resposta);

                    if (resultado.erro) {
                        document.getElementById('modalExcluirAgendamentoBodyText').innerHTML = "<p>"+resultado.erro+"</p>";
                        document.getElementById('btnCancelarExclusaoAgendamento').style.display = 'inline';
                        const btnFechar = document.getElementById('btnCancelarExclusaoAgendamento');

                        btnFechar.addEventListener('click', function() {
                            location.reload();
                        });
                        return;
                    }

                    setTimeout(() => {
                        document.getElementById('modalExcluirAgendamentoBodyText').innerHTML = "<p>Agendamento removido com sucesso!</p>";
                        document.getElementById('btnCancelarExclusaoAgendamento').style.display = 'inline';

                        const btnFechar = document.getElementById('btnCancelarExclusaoAgendamento');

                        btnFechar.addEventListener('click', function() {
                            location.reload();
                        });

                    }, 1000);
                } catch(e) {
                    document.getElementById('modalExcluirAgendamentoBodyText').innerHTML = "<p>"+resultado.erro+"</p>";
                    document.getElementById('btnModalEditarAgendamentoCancelar').style.display = 'inline';
                    const btnFechar = document.getElementById('btnModalEditarAgendamentoCancelar');

                    btnFechar.addEventListener('click', function() {
                        location.reload();
                    });
                    console.log(e);
                }
            },
            error: function(erro) {
                alert("Erro ao editar agendamento.");
                console.log(erro);
            },
            complete: function() {
                btnSalvar.disabled = false;
            }
        });
    }

    function editarHorarioAgendamento(el) {
        // 'el' é o link que foi clicado
        const agendamento_id = el.dataset.id;
        const cliente = el.dataset.cliente;
        const telefone = el.dataset.telefone;
        const servico_id = el.dataset.servico;
        const dia = el.dataset.dia;
        const horario = el.dataset.horario;

        const [year, month, day] = dia.split('-');
        const diaFormatado = `${day}/${month}/${year}`;

        document.querySelector('#agendamento_id').value = agendamento_id;
        document.querySelector('#cliente').value = cliente;
        document.querySelector('#telefone').value = telefone;
        document.querySelector('#servico').value = servico_id;
        document.querySelector('#dia').value = dia;

        const dados = {
            cliente: cliente,
            telefone: telefone,
            servico_id: servico_id,
            dia: diaFormatado,
        };

        $.ajax({
            method: 'POST',
            url: '/Cortai/agendar/verificarHorariosDisponiveis',
            data: dados,
            success: function(resposta) {
                let horariosDisponiveis = typeof resposta === 'string' ? JSON.parse(resposta) : resposta;

                if (horariosDisponiveis.length === 0) {
                    alert("Nenhum horário disponível para essa data/serviço.");
                    $('#containerHorarios').hide();
                    return;
                }

                document.querySelector('#modalBodyExibirDia').innerHTML = diaFormatado;

                mostrarHorariosComoCaixas(horariosDisponiveis);

                // Abrir modal Bootstrap
                const modalElement = document.getElementById('modalSelecionarHorario');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            },
            error: function(erro) {
                alert("Erro ao verificar horários.");
                console.log(erro);
            }
        });

        // Se quiser guardar em inputs ocultos
        document.querySelector('#agendamento_id').value = agendamento_id;
        document.querySelector('#cliente').value = cliente;
        document.querySelector('#telefone').value = telefone;
        document.querySelector('#servico').value = servico_id;
    }

    function mostrarHorariosComoCaixas(horarios) {
        const container = $('#containerHorarios');
        container.empty();

        horarios.forEach(horario => {
            const box = $('<div class="col box-horario"></div>').text(horario);
            container.append(box);
        });

        // Evento para marcar o horário selecionado
        $('.box-horario').click(function() {
            $('.box-horario').removeClass('selected');
            $(this).addClass('selected');
        });
    }

    function atualizarHorarioAgendamentoService() {
        const agendamento_id = document.querySelector('#agendamento_id').value;
        const cliente = document.querySelector('#cliente').value;
        const telefone = document.querySelector('#telefone').value;
        const servico_id = document.querySelector('#servico').value;
        const dia = document.querySelector('#dia').value;

        const horarioSelecionadoEl = document.querySelector('.box-horario.selected');
        if (!horarioSelecionadoEl) {
            alert("Selecione um horário antes de salvar.");
            return;
        }
        const horarioSelecionado = horarioSelecionadoEl.textContent;

        const dados = {
            agendamento_id,
            cliente,
            telefone,
            servico_id,
            horario: horarioSelecionado,
            dia: dia
        };

        // Mostrar loading
        document.getElementById('modalEditarHorarioAgendamentoBodyText').innerHTML = "<center><img src='/Cortai/public/assets/img/loading.gif' width='50'></center>";
        document.getElementById('btnModalEditarHorarioAgendamentoCancelar').style.display = 'none';
        document.getElementById('btnModalEditarHorarioAgendamentoSalvar').style.display = 'none';

        $.ajax({
            method: 'POST',
            url: '/Cortai/admin/atualizarHorarioAgendamentoService', // ajuste para a rota correta
            data: dados,
            success: function(resposta) {
                try {
                    const resultado = JSON.parse(resposta);

                    if (resultado.erro) {
                        alert(resultado.erro);
                        return;
                    }

                    setTimeout(() => {
                        document.getElementById('modalEditarHorarioAgendamentoBodyText').innerHTML = "<p>Horário atualizado com sucesso!</p>";
                        document.getElementById('btnModalEditarHorarioAgendamentoCancelar').style.display = 'inline';

                        const btnFechar = document.getElementById('btnModalEditarHorarioAgendamentoCancelar');

                        btnFechar.addEventListener('click', function() {
                            location.reload();
                        });

                    }, 1000);

                } catch(e) {
                    console.error(e);
                    alert("Erro inesperado ao atualizar horário.");
                }
            },
            error: function(erro) {
                console.error(erro);
                alert("Erro ao atualizar horário.");
            }
        });
    }

    function AgendamentoService(apiUrl) {
        this.remover = function(agendamentoId) {
            return $.ajax({
                method: 'POST',
                url: apiUrl + '/removerAgendamento',
                data: { agendamento_id: agendamentoId },
                dataType: 'json'
            });
        };
    }

    function ModalHelper(modalId) {
        this.abrir = function() {
            new bootstrap.Modal(document.getElementById(modalId)).show();
        };
        this.fechar = function() {
            const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
            if (modal) modal.hide();
        };
    }

    function mascaraTelefone() {
        Inputmask({
            mask: ["(99) 9999-9999","(99) 99999-9999"],
            keepStatic: true
        }).mask("#telefone");
    }

    document.addEventListener('DOMContentLoaded', inicializarEdicaoAgendamento);
    document.addEventListener('DOMContentLoaded', inicializarRemocaoAgendamento);

    document.getElementById('btnModalEditarAgendamentoSalvar')
    .addEventListener('click', editarAgendamentoService);

    document.getElementById('btnModalEditarHorarioAgendamentoSalvar')
    .addEventListener('click', atualizarHorarioAgendamentoService);

    document.getElementById('modalExcluirAgendamento')
    .addEventListener('click', removerAgendamentoService);

    $(document).ready(function() {
        mascaraTelefone();
    });
</script>
