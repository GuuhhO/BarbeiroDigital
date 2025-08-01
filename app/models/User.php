<?php

class User extends Model {
    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function verifyPassword(string $input, string $hash): bool {
        return password_verify($input, $hash);
    }
}
