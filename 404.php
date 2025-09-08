<?php
http_response_code(404);
?>

<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cortaí - Página não encontrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="/Cortai/public/assets/css/style.css" />
    <script src="https://kit.fontawesome.com/6700413543.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"></script>
</head>
<body>

<main>
    <div class="container vh-100 d-flex flex-column justify-content-center text-center">
    <div class="row align-items-center justify-content-center w-100">
        <div class="col-12 col-md-6 mb-4 mb-md-0">
            <h3 class="mb-3">Página não encontrada!</h3>
            <p class="mb-3">Ops! A página que você procura não existe.</p>
            <a href="<?= BASE_URL ?>" class="btn btn-primary btn-sm">VOLTAR</a>
        </div>
        <div class="col-12 col-md-6 text-center">
            <img src="public/assets/img/404.png" alt="Erro página não encontrada" class="img-fluid" style="max-width: 300px;">
        </div>
    </div>
</div>


</main>