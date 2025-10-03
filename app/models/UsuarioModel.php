<?php

class UsuarioModel {
    public function buscarPorLogin(string $login): ?array {
        global $db;

        $verificarUsuarioSql = $db->prepare("SELECT * FROM seg.usuarios WHERE usuario = ? OR email = ?");
        $verificarUsuarioSql->execute([$login, $login]);

        $usuario = $verificarUsuarioSql->fetch(PDO::FETCH_ASSOC);
        
        return $usuario ?: null;
    }

    public function verificarSenha(string $input, string $hash): bool {
        return password_verify($input, $hash);
    }
}
