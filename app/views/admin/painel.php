<?php

$title = 'Painel do Administrador';

?>

<div class="container">
    <div class="row mt-5">
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
                    <td><?= htmlspecialchars($agendamento['dia']) ?></td>
                    <td><?= htmlspecialchars($agendamento['telefone']) ?></td>
                    <td><button class="btn btn-warning">Editar</button></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <hr>
    <div class="row mt-5">
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
                    <td><button class="btn btn-warning">Editar</button></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>