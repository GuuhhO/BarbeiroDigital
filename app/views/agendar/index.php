<?php

$title = 'Agendar Horário';

?>

<div class="container">
    <div class="row pt-5 pb-5">
        <H1 align="center">AGENDAR HORÁRIO</H1>
    </div>
    <div class="row flex align-items-center justify-content-center text-center">
        <form id="formAgendar" onsubmit="verificarHorariosService(event)">
            <div class="mb-3 col-8 m-auto">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" aria-describedby="nome">
            </div>
            <div class="mb-3 col-8 m-auto">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" aria-describedby="telefone">
            </div>
            <div class="mb-3 col-8 m-auto">
                <label for="servico" class="form-label">Serviço</label>
                <select class="form-select" aria-label="Serviço" id="servico_id">
                    <option selected>Selecione uma opção</option>
                    <option value="1">Corte e Barba</option>
                    <option value="2">Corte</option>
                    <option value="3">Barba</option>
                    <option value="3">Sobrancelha</option>
                    <option value="3">Pezinho</option>
                </select>
            </div>
            <div class="mb-3 col-8 m-auto">
                <label for="dia" class="form-label">Data</label>
                <input type="date" class="form-control" id="dia" aria-describedby="data">
            </div>
            <div class="mb-3 col-8 m-auto">
                <button class="btn btn-primary" onclick="verificarHorariosService(event)">VERIFICAR</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" id="modalSelecionarHorario" aria-hidden="true">
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
        <button type="button" class="btn btn-warning" onclick="agendarClienteService()">Agendar</button>
      </div>
    </div>
  </div>
</div>

<script>
    function verificarHorariosService(event) {
        event.preventDefault();

        const dados = {
            nome: $('#nome').val(),
            telefone: $('#telefone').val(),
            servico_id: $('#servico_id').val(),
            dia: $('#dia').val(),
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

    function agendarClienteService() {
        const cliente = $('#nome').val();
        const telefone = $('#telefone').val();
        const servico_id = $('#servico_id').val();
        const dia = $('#dia').val();
        const horario = $('.box-horario.selected').text();

        if (!cliente || !telefone || !servico_id || !dia || !horario) {
            alert("Preencha todos os campos e selecione um horário antes de agendar.");
            return;
        }

        const dados = {
            cliente: cliente,
            telefone: telefone,
            servico_id: servico_id,
            dia: dia,
            horario: horario
        };

        $.ajax({
            method: 'POST',
            url: '/Cortai/agendar/agendarCliente',
            data: dados,
            success: function(resposta) {
                alert("Agendamento realizado com sucesso!");
                const modalEl = document.getElementById('modalSelecionarHorario');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
                window.location.href = "<?= BASE_URL ?>";
            },
            error: function(erro) {
                alert("Erro ao agendar.");
                console.log(erro);
            }
        });
    }
</script>