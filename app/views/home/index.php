<?php

$title = 'Página Inicial';

?>

<div id="carouselExampleIndicators" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="/../Cortai/public/assets/img/carousel_1.jpg" class="d-block w-100" alt="Imagem 1">
    </div>
    <div class="carousel-item">
      <img src="/../Cortai/public/assets/img/carousel_2.jpg" class="d-block w-100" alt="Imagem 2">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Anterior</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Próximo</span>
  </button>
</div>

<div id="boxEntrada">
    <div class="container">
        <div class="row pb-2">
            <h1 align="center">AGENDE SEU HORÁRIO</h1>
        </div>
        <div class="container overflow-hidden text-center">
            <div class="row gx-5">
                <div class="col">
                <a class="p-3 btn btn-warning" href="<?= BASE_URL ?>Agendar">AGENDAR HORÁRIO</a>
                </div>
                <div class="col">
                <a class="p-3 btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalVerificarAgendamento">MEUS AGENDAMENTOS</a>
                </div>
            </div>
        </div>
    </div>
</div>

<hr />

<div id="servicos">
    <div class="container">
        <div class="row pb-2">
            <h1 align="center">NOSSOS SERVIÇOS</h1>
        </div>
        <div class="row flex align-items-center justify-content-center">
            <div class="container overflow-hidden text-center">
               <div class="row gy-5">
                    <div class="col-6">
                        <div class="p-3 btn btn-light d-flex flex-column align-items-center">
                        <img src="/../Cortai/public/assets/img/penteado (1).png" alt="" width="32">
                        <div>CORTE</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 btn btn-light d-flex flex-column align-items-center">
                        <img src="/../Cortai/public/assets/img/barba.png" alt="" width="32">
                        <div>BARBA</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 btn btn-light d-flex flex-column align-items-center">
                        <img src="/../Cortai/public/assets/img/sobrancelha.png" alt="" width="32">
                        <div>SOBRANCELHA</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 btn btn-light d-flex flex-column align-items-center">
                        <img src="/../Cortai/public/assets/img/lamina-de-barbear.png" alt="" width="32">
                        <div>PÉZINHO</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr />

<div class="modal" tabindex="-1" id="modalVerificarAgendamento">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Verifique seus agendamentos</h5>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="telefone" class="form-label">Insira seu telefone</label>
            <input type="text" class="form-control" id="telefone" aria-describedby="telefone" required>
          </div>
          <button onclick="verificarAgendamentosService(event)" class="btn btn-primary">Consultar</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<script>
  function exibirModal()
  {
    // Abrir modal Bootstrap
    const modalElement = document.getElementById('modalVerificarAgendamento');
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
  }

  function verificarAgendamentosService(event) {
      const telefone = $('#telefone').val();

      if (!telefone) {
          alert("Informe o telefone.");
          return;
      }

      $.ajax({
          method: 'POST',
          url: '/Cortai/Cliente/verificarCliente',
          data: { telefone: telefone },
          dataType: 'json', // se a resposta for JSON
          success: function(resposta) {
              // Redirecionamento via POST
              const form = document.createElement('form');
              form.method = 'POST';
              form.action = '/Cortai/Cliente/';

              const inputTelefone = document.createElement('input');
              inputTelefone.type = 'hidden';
              inputTelefone.name = 'telefone';
              inputTelefone.value = telefone;

              form.appendChild(inputTelefone);
              document.body.appendChild(form);
              form.submit();
          },
          error: function(xhr, status, error) {
              alert("Erro ao verificar horários.");
              console.log("Erro:", error);
              console.log("Resposta do servidor:", xhr.responseText);
          }
      });
  }

</script>