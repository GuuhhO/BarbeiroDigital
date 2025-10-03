<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cortaí - <?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="/BarbeiroDigital/public/assets/css/style.css" />
    <script src="https://kit.fontawesome.com/6700413543.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"></script>
</head>
<body>
<header>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= BASE_URL ?>"><img src="/BarbeiroDigital/public/assets/img/logo-transparente.png" width="50" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?= BASE_URL ?>"><i class="fa-solid fa-house"></i> Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>Agendar"><i class="fa-solid fa-calendar-days"></i> Agendar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>Sobre"><i class="fa-solid fa-circle-info"></i> Sobre</a>
                    </li>
                    <?php if (Session::isAuthenticated()) {?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-gear"></i> Administrador
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>admin"><i class="fa-solid fa-sliders"></i> Painel</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/agendamentos"><i class="fa-solid fa-calendar"></i> Agendamentos</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/expedientes"><i class="fa-solid fa-table"></i> Expedientes</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/servicos"><i class="fa-solid fa-gears"></i> Serviços</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/barbeiros"><i class="fa-solid fa-users"></i> Barbeiros</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" onclick="deslogarService()"><i class="fa-solid fa-right-from-bracket"></i> Sair</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
  </head>
  <body>
    <main>
        <?= $content ?>
    </main>
    <footer>
        <p>© <?= date('Y') ?> BarbeiroDigital Barbearia - Todos os direitos reservados.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-datepicker/1.13.2/i18n/datepicker-pt-BR.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="<?= BASE_URL ?>/public/assets/js/api.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  </body>
</html>

<script>
    function deslogarService() {
        $.ajax({
            method: 'POST',
            url: '/BarbeiroDigital/auth/logout',
            dataType: 'json',
            timeout: 5000, // evita requisição travada
            success: function(resposta) {
                if (resposta && resposta.sucesso) {
                    window.location.href = "<?= BASE_URL ?>";
                } else {
                    console.warn("Logout falhou:", resposta?.mensagem || "Resposta inesperada.");
                    alert("Não foi possível sair. Tente novamente.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Erro no logout:", error);
                console.error("Resposta do servidor:", xhr.responseText || "Sem resposta");
                alert("Erro ao tentar sair. Verifique sua conexão.");
            }
        });
    }

</script>