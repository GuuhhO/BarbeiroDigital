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
    <div class="container vh-100 d-flex flex-column align-items-center justify-content-center text-center">
        <div class="d-flex flex-column align-items-center justify-content-center">
            <img src="<?php BASE_PATH ?>public/assets/img/404.png" width="300" alt="Erro página não encontrada">
            <h4>ERRO!</h4>
            <p>Essa página não existe.</p>
            <br>
            <a href="<?php BASE_PATH ?>" class="btn btn-sm btn-primary">CLIQUE AQUI PARA VOLTAR</a>
        </div>
    </div>
</main>