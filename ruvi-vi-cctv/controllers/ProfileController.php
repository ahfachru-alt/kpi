<?php
class ProfileController {
    private function render(string $view, array $data = []): string {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        include BASE_PATH . '/views/' . $view . '.php';
        return (string)ob_get_clean();
    }
    public function admin(): string {
        require_admin();
        $u = auth_user();
        return $this->render('admin/profile', ['title' => 'Profil', 'user' => $u]);
    }
    public function user(): string {
        require_auth();
        $u = auth_user();
        return $this->render('user/profile', ['title' => 'Profil', 'user' => $u]);
    }
    public function update(): string {
        require_auth();
        $id = (int)$_SESSION['user']['id'];
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        if ($name && $email) {
            $stmt = db()->prepare('UPDATE users SET name=?, email=? WHERE id=?');
            $stmt->execute([$name,$email,$id]);
            $_SESSION['user']['name'] = $name; $_SESSION['user']['email'] = $email;
        }
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? base_url())); exit;
    }
    public function password(): string {
        require_auth();
        $id = (int)$_SESSION['user']['id'];
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        if ($new && $new === $confirm) {
            $stmt = db()->prepare('SELECT password FROM users WHERE id=?');
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if ($row && password_verify($current, $row['password'])) {
                $hash = password_hash($new, PASSWORD_BCRYPT);
                db()->prepare('UPDATE users SET password=? WHERE id=?')->execute([$hash,$id]);
            }
        }
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? base_url())); exit;
    }
}

