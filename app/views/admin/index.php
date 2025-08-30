<?php

$title = 'Painel do Administrador';

?>

<div class="container">
    <div class="row mt-5 m-auto">
        <h1 align="center">PAINEL</h1>
            <div class="row m-auto">
                <h4 align="center">Desempenho</h4>
                <div class="col-md-6">
                    <div class="d-flex align-items-center shadow-sm rounded overflow-hidden mb-3" style="background: #e3e3e3; height: 100px;">
                        <div class="d-flex justify-content-center align-items-center" 
                            style="width: 100px; height: 100%; background: #12a033ff; color: #ffffffff;">
                            <i class="fa-solid fa-calendar fa-2x" style="font-size: 50px !important;"></i>
                        </div>
                        <div class="p-3 flex-fill">
                            <span class="text-muted d-block" style="font-size: 18px;">Atendimentos para hoje</span>
                            <h4 class="mb-0" style="color: #333333ff;">Restam <?php echo $contagemAgendamentosHoje['count']; ?> de <?php echo $contagemAgendamentosHojeTotal['count']; ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center shadow-sm rounded overflow-hidden mb-3" style="background: #e3e3e3; height: 100px;">
                        <div class="d-flex justify-content-center align-items-center" 
                            style="width: 100px; height: 100%; background: #1539b1ff; color: #ffffffff;">
                            <i class="fa-solid fa-calendar-week fa-2x" style="font-size: 50px !important;"></i>
                        </div>
                        <div class="p-3 flex-fill">
                            <span class="text-muted d-block" style="font-size: 18px;">Atendimentos para amanhã</span>
                            <h4 class="mb-0" style="color: #333333ff;"><?php echo $contagemAgendamentosAmanha['count']; ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center shadow-sm rounded overflow-hidden mb-3" style="background: #e3e3e3; height: 100px;">
                        <div class="d-flex justify-content-center align-items-center" 
                            style="width: 100px; height: 100%; background: #e92929ff; color: #ffffffff;">
                            <i class="fa-solid fa-calendar-days fa-2x" style="font-size: 50px !important;"></i>
                        </div>
                        <div class="p-3 flex-fill">
                            <span class="text-muted d-block" style="font-size: 18px;">Atendimentos no mês</span>
                            <h4 class="mb-0" style="color: #333333ff;"><?php echo $contagemAgendamentosMes['count']; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-auto">
                <h4 align="center">Saúde financeira</h4>
                <div class="col-md-6">
                    <div class="d-flex align-items-center shadow-sm rounded overflow-hidden mb-3" style="background: #e3e3e3; height: 100px;">
                        <div class="d-flex justify-content-center align-items-center" 
                            style="width: 100px; height: 100%; background: #1539b1ff; color: #ffffffff;">
                            <i class="fa-solid fa-hand-holding-dollar fa-2x" style="font-size: 50px !important;"></i>
                        </div>
                        <div class="p-3 flex-fill">
                            <span class="text-muted d-block" style="font-size: 18px;">Faturamento de hoje</span>
                            <h4 class="mb-0" style="color: #333333ff;"><?= 'R$ ' . number_format($faturamentoHoje['0']['total'], 2, ',', '.') ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center shadow-sm rounded overflow-hidden mb-3" style="background: #e3e3e3; height: 100px;">
                        <div class="d-flex justify-content-center align-items-center" 
                            style="width: 100px; height: 100%; background: #12a033ff; color: #ffffffff;">
                            <i class="fa-solid fa-sack-dollar fa-2x" style="font-size: 50px !important;"></i>
                        </div>
                        <div class="p-3 flex-fill">
                            <span class="text-muted d-block" style="font-size: 18px;">Faturamento mensal</span>
                            <h4 class="mb-0" style="color: #333333ff;"><?= 'R$ ' . number_format($faturamentoMensal['0']['total'], 2, ',', '.') ?></h4>
                        </div>
                    </div>
                </div>
            </div>   
    </div>

    <div class="row mt-5 m-auto">
        <canvas id="graficoAgendamentos" width="200" height="200"></canvas>
    </div>
    <div class="row mt-5 m-auto">
        <h1 align="center">AGENDAMENTOS</h1>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                <th scope="col">CLIENTE</th>
                <th scope="col">HORÁRIO</th>
                <th scope="col">DIA</th>
                <th scope="col">TELEFONE</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agendamentos as $agendamento): ?>
                <tr>
                    <td><?= htmlspecialchars($agendamento['cliente']) ?></td>
                    <td><?= htmlspecialchars($agendamento['horario']) ?></td>
                    <td><?= date("d/m/Y", strtotime($agendamento['dia'])) ?></td>
                    <td><?= htmlspecialchars($agendamento['telefone']) ?></td>
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
                                        data-cliente="<?= htmlspecialchars($agendamento['cliente'], ENT_QUOTES) ?>"
                                        data-telefone="<?= htmlspecialchars($agendamento['telefone'], ENT_QUOTES) ?>"
                                        data-servico="<?= htmlspecialchars($agendamento['servico_id'], ENT_QUOTES) ?>"
                                        data-dia="<?= htmlspecialchars($agendamento['dia'], ENT_QUOTES) ?>"
                                        data-horario="<?= htmlspecialchars($agendamento['horario'], ENT_QUOTES) ?>"
                                        style="cursor: pointer">
                                        Mudar Horário</a>
                                    </li>
                                    <li id="dropdownAcoesAgendamento">
                                        <a data-bs-toggle="modal"
                                        data-bs-target="#modalRemoverAgendamento"
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
    <hr>
    <div class="row mt-5 m-auto">
        <h1 align="center">CLIENTES</h1>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                <th scope="col">CLIENTE</th>
                <th scope="col">TELEFONE</th>
                <th scope="col">AGENDAMENTOS</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?= htmlspecialchars($cliente['cliente']) ?></td>
                    <td><?= htmlspecialchars($cliente['telefone'] ?? 'N/A') ?></td>
                    <td>
                        <?php
                            // Conta quantos agendamentos esse cliente tem
                            $quantidade = array_reduce($agendamentos, function ($carry, $item) use ($cliente) {
                                return $carry + ($item['cliente'] === $cliente['cliente'] ? 1 : 0);
                            }, 0);
                            echo $quantidade;
                        ?>
                    </td>
                    <td>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="p-3 btn btn-warning btn-sm btnEditarAgendamento"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEditarAgendamento"
                            data-id="<?= $agendamento['id'] ?>"
                            data-cliente="<?= htmlspecialchars($agendamento['cliente'], ENT_QUOTES) ?>"
                            data-telefone="<?= htmlspecialchars($agendamento['telefone'], ENT_QUOTES) ?>"
                            data-servico="<?= htmlspecialchars($agendamento['servico_id'], ENT_QUOTES) ?>"
                            data-dia="<?= htmlspecialchars($agendamento['dia'], ENT_QUOTES) ?>"
                            data-horario="<?= htmlspecialchars($agendamento['horario'], ENT_QUOTES) ?>">
                            Editar</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal" tabindex="-1" id="modalEditarAgendamento">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar agendamento</h5>
            </div>
            <div class="modal-body">
                <form id="formEditarAgendamento">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Cliente</label>
                        <input type="text" class="form-control" id="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" required>
                    </div>
                    <div class="mb-3">
                        <label for="servico" class="form-label">Serviço</label>
                        <input type="text" class="form-control" id="servico" required>
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

<div class="modal fade" tabindex="-1" id="modalEditarHorarioAgendamento" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Selecione um horário</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <div class="container text-center">
            <label class="form-label">Horários disponíveis:</label>
            <div class="row row-cols-auto justify-content-center" id="containerHorarios">
                <!-- caixas serão geradas aqui -->
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="agendarClienteService()">Agendar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="modalRemoverAgendamento" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Remover agendamento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <div class="container text-center">
            <label class="form-label">Deseja realmente remover este agendamento?</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="btnConfirmarRemocao">Remover</button>
      </div>
    </div>
  </div>
</div>

<script>
    function exibirModal()
    {
    // Abrir modal Bootstrap
    const modalElement = document.getElementById('modalEditarAgendamento');
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
    }

    document.addEventListener('DOMContentLoaded', () => {
        editarAgendamento();
    });


    function editarAgendamento()
    {
        document.querySelectorAll('.btnEditarAgendamento').forEach(botao => {
            botao.addEventListener('click', function(event) {
                event.preventDefault(); // evita que o link faça scroll ou navegue

                const nome = this.getAttribute('data-cliente');
                const telefone = this.getAttribute('data-telefone');
                const servico = this.getAttribute('data-servico');
                const dia = this.getAttribute('data-dia');
                const horario = this.getAttribute('data-horario');

                // Preenche inputs do modal
                document.getElementById('nome').value = nome;
                document.getElementById('telefone').value = telefone;
                document.getElementById('servico').value = servico;
                document.getElementById('dia').value = dia;
                document.getElementById('horario').value = horario;
            });
        });
    }

    function verificarHorariosService() {
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.btnEditarAgendamento').forEach(botao => {
                botao.addEventListener('click', function(e) {
                    e.preventDefault(); // evita navegação do <a>

                    const dados = {
                        nome: this.getAttribute('data-cliente'),
                        telefone: this.getAttribute('data-telefone'),
                        servico_id: this.getAttribute('data-servico'),
                        dia: this.getAttribute('data-dia'),
                        horario: this.getAttribute('data-horario')
                    };

                    $.ajax({
                        method: 'POST',
                        url: '/Cortai/agendar/verificarHorariosDisponiveis',
                        data: dados,
                        success: function(resposta) {
                            let horariosDisponiveis = typeof resposta === 'string' ? JSON.parse(resposta) : resposta;

                            if (!Array.isArray(horariosDisponiveis) || horariosDisponiveis.length === 0) {
                                alert("Nenhum horário disponível para essa data/serviço.");
                                $('#containerHorarios').hide();
                                return;
                            }

                            mostrarHorariosComoCaixas(horariosDisponiveis);

                            const modalElement = document.getElementById('modalSelecionarHorario');
                            const modal = new bootstrap.Modal(modalElement);
                            modal.show();
                        },
                        error: function(erro) {
                            alert("Erro ao verificar horários.");
                            console.log(erro);
                        }
                    });
                });
            });
        });

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

    function RemocaoAgendamentoController(service, modalHelper) {
        let agendamentoSelecionadoId = null;

        this.init = function() {
            this.registrarEventos();
        };

        this.registrarEventos = function() {
            document.querySelectorAll('.btnRemoverAgendamento').forEach(botao => {
                botao.addEventListener('click', () => {
                    agendamentoSelecionadoId = botao.dataset.id;
                });
            });

            document.getElementById('btnConfirmarRemocao').addEventListener('click', () => {
                this.removerAgendamento();
            });
        };

        this.removerAgendamento = function() {
            if (!agendamentoSelecionadoId) {
                alert("Nenhum agendamento selecionado.");
                return;
            }

            service.remover(agendamentoSelecionadoId)
                .done(resposta => {
                    if (resposta.sucesso) {
                        alert("Agendamento cancelado com sucesso!");
                        modalHelper.fechar();
                        location.reload();
                    } else {
                        alert(resposta.erro || "Erro ao remover agendamento.");
                    }
                })
                .fail(err => {
                    alert("Erro ao remover agendamento.");
                    console.error(err);
                });
        };
    }

    document.addEventListener('DOMContentLoaded', function() {
        const service = new AgendamentoService('/Cortai/admin');
        const modalHelper = new ModalHelper('modalRemoverAgendamento');
        const controller = new RemocaoAgendamentoController(service, modalHelper);
        controller.init();
    });

    function mascaraTelefone() {
        Inputmask({
            mask: ["(99) 9999-9999","(99) 99999-9999"],
            keepStatic: true
        }).mask("#telefone");
    }

    function carregarGraficoAgendamentos() {
        fetch('/Cortai/agendar/obterDadosGrafico')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.servico);
                const valores = data.map(item => item.total);

                new Chart(document.getElementById('graficoAgendamentos'), {
                    type: 'pie', // <-- altere para 'doughnut' se quiser rosquinha
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Agendamentos',
                            data: valores,
                            backgroundColor: [
                                '#f37c1bff',
                                '#10b981',
                                '#3b82f6',
                                '#ef4444',
                                '#8b5cf6',
                                '#f5e50bff',
                                '#a5a5a5ff'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' },
                            title: { display: true, text: 'Agendamentos por Serviço' }
                        }
                    }
                });
            });
    }

    document.addEventListener("DOMContentLoaded", carregarGraficoAgendamentos);


    $(document).ready(function() {
        mascaraTelefone();
    });
</script>
