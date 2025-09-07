<?php

$title = 'Agendar Horário';

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"></script>

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
                <select class="form-select" aria-label="Serviço" id="servico_id" name="servico_id" required>
                    <option value="" selected disabled>Selecione uma opção</option>
                    <?php foreach ($servicos as $servico): ?>
                        <option value="<?= $servico['id'] ?>">
                            <?= htmlspecialchars($servico['servico']) ?> - <?= 'R$ ' . number_format($servico['preco'], 2, ',', '.') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3 col-8 m-auto">
                <label for="barbeiro" class="form-label">Barbeiro</label>
                <select class="form-select" aria-label="Barbeiro" id="barbeiro_id" name="barbeiro_id" required>
                    <option value="" selected disabled>Selecione uma opção</option>
                    <!-- O JS vai preencher aqui -->
                </select>
            </div>
            <div class="mb-3 col-8 m-auto">
                <label for="dia" class="form-label">Data</label>
                <input type="text" class="form-control" id="calendario" aria-describedby="dia">
                <!-- <input type="date" class="form-control" id="dia" aria-describedby="dia" onclick="gerarCalendarioAtivos()"> -->
            </div>
            <div class="mb-3 col-8 m-auto">
                <button class="btn btn-primary" onclick="verificarHorariosService(event)">VER HORÁRIOS</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" id="modalSelecionarHorario" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered m-auto d-flex justify-content-center">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Selecione um horário</h5>
      </div>
      <div class="modal-body">
        <div class="row text-center">
            <h5>DIA:</h5>
            <p id="modalBodyExibirDia"></p>
        </div>
        <div class="container text-center">
            <label class="form-label">Horários disponíveis:</label>
            <div class="row row-cols-auto justify-content-center" id="containerHorarios">
                <!-- caixas serão geradas aqui -->
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCancelarModalSelecionarHorario">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="agendarClienteService()">Agendar</button>
      </div>
    </div>
  </div>
</div>

<script>
    function gerarCalendarioAtivos() {
        $(function() {
            $.ajax({
                method: 'POST',
                url: '/Cortai/agendar/obterDiasAtivosAjax',
                success: function(resposta) {
                    let diasAtivos = typeof resposta === 'string' ? JSON.parse(resposta) : resposta;

                    if (!diasAtivos || diasAtivos.length === 0) {
                        alert("Nenhum dia ativo encontrado para agendar.");
                        return;
                    }

                    let hoje = new Date();
                    let doisMesesDepois = new Date();
                    doisMesesDepois.setMonth(doisMesesDepois.getMonth() + 2);

                    $.datepicker.regional['pt-BR'] = {
                        closeText: 'Fechar',
                        prevText: '&#x3C;Anterior',
                        nextText: 'Próximo&#x3E;',
                        currentText: 'Hoje',
                        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho',
                                    'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
                                        'Jul','Ago','Set','Out','Nov','Dez'],
                        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
                        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'],
                        dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'],
                        weekHeader: 'Sm',
                        dateFormat: 'dd/mm/yy',
                        firstDay: 0,
                        isRTL: false,
                        showMonthAfterYear: false,
                        yearSuffix: ''
                    };
                    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

                    // Destrói qualquer Datepicker anterior
                    $("#calendario").datepicker("destroy");

                    $("#calendario").datepicker({
                        beforeShowDay: function(date) {
                            return [diasAtivos.includes(date.getDay())];
                        },
                        dateFormat: 'dd/mm/yy',
                        minDate: 0, // bloqueia datas passadas
                        maxDate: doisMesesDepois,
                        onSelect: function(dateText) {
                            // Quando o usuário escolher a data, já chama a função
                            verificarHorariosService(new Event('submit'));
                        }
                    });
                },
                error: function(erro) {
                    console.log(erro);
                    alert("Erro ao buscar dias ativos.");
                }
            });
        });
    }

    gerarCalendarioAtivos();

    function verificarHorariosService(event = null) {
        event.preventDefault();

        const dados = {
            nome: $('#nome').val(),
            telefone: $('#telefone').val(),
            servico_id: $('#servico_id').val(),
            dia: $('#calendario').val(),
        };

        const [day, month, year] = dados.dia.split('/');
        const diaFormatado = `${day}/${month}/${year}`;

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
        const modalEl = document.getElementById('modalSelecionarHorario');
        const modal = bootstrap.Modal.getInstance(modalEl);

        const modalBody = modalEl.querySelector('.modal-body'); 
        const modalTitle = modalEl.querySelector('.modal-title'); 
        const btnCancelar = document.getElementById('btnCancelarModalSelecionarHorario'); 
        const btnAgendar = modalEl.querySelector('.btn-primary');

        const cliente = $('#nome').val();
        const telefone = $('#telefone').val();
        const servico_id = $('#servico_id').val();
        const dia = $('#calendario').val();
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

        modalBody.innerHTML = "<center><img src='/Cortai/public/assets/img/loading.gif' width='50'></img></center>";
        btnCancelar.style.display = 'none';
        btnAgendar.style.display = 'none';

        $.ajax({
            method: 'POST',
            url: '/Cortai/agendar/agendarCliente',
            data: dados,
            success: function(resposta) {
                try {
                    const resultado = JSON.parse(resposta);

                    if (resultado.erro) {
                        modalBody.innerHTML = `<p style="color:red">${resultado.erro}</p>`;
                        btnCancelar.style.display = 'inline';
                        return;
                    }

                    setTimeout(() => {
                        // Caso o agendamento dê certo mas o lembrete falhe
                        if (resultado.sucesso && resultado.lembrete === false) {
                            modalTitle.innerHTML = 'Agendamento realizado';
                            modalBody.innerHTML = `
                                <p>Agendamento realizado com sucesso, mas não foi possível enviar mensagem no WhatsApp do número ${telefone}.</p>
                            `;
                        } else {
                            modalTitle.innerHTML = 'Agendamento realizado';
                            modalBody.innerHTML = "<p>Agendamento realizado com sucesso. Uma mensagem de confirmação foi enviada no WhatsApp.</p>";
                        }

                        btnCancelar.style.display = 'inline';
                        btnCancelar.innerHTML = 'Fechar';

                        // Reload ao fechar
                        btnCancelar.addEventListener('click', function() {
                            location.reload();
                        });

                    }, 1000);

                } catch(e) {
                    modalTitle.innerHTML = 'Ocorreu um erro';
                    modalBody.innerHTML = "<p style='color:red'>Erro ao interpretar resposta do servidor.</p>";
                    btnCancelar.style.display = 'inline';
                    btnCancelar.innerHTML = 'Fechar';
                    console.log(e);
                }
            },
            error: function(erro) {
                modalTitle.innerHTML = 'Ocorreu um erro';
                modalBody.innerHTML = "<p style='color:red'>Erro ao agendar.</p>";
                btnCancelar.style.display = 'inline';
                btnCancelar.innerHTML = 'Fechar';
                console.log(erro);
            }
        });
    }

    function mascaraTelefone() {
        Inputmask({
            mask: ["(99) 9999-9999","(99) 99999-9999"],
            keepStatic: true
        }).mask("#telefone");
    }

    function obterBarbeiroPorServico() {
        $('#servico_id').on('change', function() {
            let servico_id = $(this).val();

            $.ajax({
                method: 'POST',
                url: '/Cortai/agendar/obterBarbeiroPorServicoService',
                data: { servico_id: servico_id },
                success: function(resposta) {
                    try {
                        const barbeiros = JSON.parse(resposta);

                        if (barbeiros.error) {
                            alert('Serviço inválido. Tente novamente.');
                            return;
                        }

                        let $select = $('#barbeiro_id');
                        $select.empty();
                        $select.append('<option value="" selected disabled>Selecione uma opção</option>');

                        barbeiros.forEach(b => {
                            $select.append(`<option value="${b.id}">${b.nome}</option>`);
                        });

                        // Tratamento: se houver apenas 1 barbeiro, seleciona ele automaticamente
                        if (barbeiros.length === 1) {
                            $select.val(barbeiros[0].id);
                        }

                    } catch (e) {
                        console.log('Erro ao processar JSON:', e);
                    }
                },
                error: function(erro) {
                    console.log('Erro na requisição:', erro);
                }
            });
        });
    }

    $(document).ready(function() {
        mascaraTelefone();
    });

    $(document).ready(function() {
        obterBarbeiroPorServico();
    });

</script>