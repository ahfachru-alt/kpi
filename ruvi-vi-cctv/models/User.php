<?php
class UserModel {
    public static function findByEmail(string $email): ?array {
        $stmt = db()->prepare('SELECT * FROM users WHERE email=? LIMIT 1');
        $stmt->execute([$email]);
        $u = $stmt->fetch();
        return $u ?: null;
    }
}

