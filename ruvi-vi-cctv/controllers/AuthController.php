<?php
class AuthController {
    private function render(string $view, array $data = []): string {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        include BASE_PATH . '/views/' . $view . '.php';
        return (string)ob_get_clean();
    }

    public function welcome(): string {
        return $this->render('auth/welcome', [
            'title' => 'Monitoring CCTV RU VI Balongan',
        ]);
    }

    public function login(): string {
        if (auth_user()) { return $this->redirectAfterLogin(); }
        return $this->render('auth/login', ['title' => 'Masuk']);
    }

    public function doLogin(): string {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Email dan password wajib diisi'];
            header('Location: ' . base_url('login')); exit;
        }

        $stmt = db()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Kredensial salah'];
            header('Location: ' . base_url('login')); exit;
        }

        $_SESSION['user'] = [
            'id' => (int)$user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'] ?? 'user',
            'theme' => $user['theme'] ?? 'system',
        ];

        // Insert login notification
        $ins = db()->prepare('INSERT INTO notifications (user_id, title, body, is_read, created_at) VALUES (?, ?, ?, 0, NOW())');
        $ins->execute([$user['id'], 'Login Berhasil', 'Anda berhasil login pada ' . date('Y-m-d H:i')]);

        return $this->redirectAfterLogin();
    }

    private function redirectAfterLogin(): string {
        $role = $_SESSION['user']['role'] ?? 'user';
        header('Location: ' . base_url($role === 'admin' ? 'admin' : 'user')); exit;
    }

    public function register(): string {
        if (auth_user()) { return $this->redirectAfterLogin(); }
        return $this->render('auth/register', ['title' => 'Daftar']);
    }

    public function doRegister(): string {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = ($_POST['role'] ?? 'user') === 'admin' ? 'admin' : 'user';

        if ($name === '' || $email === '' || $password === '') {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Semua field wajib diisi'];
            header('Location: ' . base_url('register')); exit;
        }

        $stmt = db()->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Email sudah terdaftar'];
            header('Location: ' . base_url('register')); exit;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $ins = db()->prepare('INSERT INTO users (name, email, password, role, verified, theme) VALUES (?, ?, ?, ?, 0, "system")');
        $ins->execute([$name, $email, $hash, $role]);
        $userId = (int)db()->lastInsertId();

        // Send verification email
        require_once BASE_PATH . '/config/mailer.php';
        $token = bin2hex(random_bytes(16));
        db()->prepare('INSERT INTO email_verifications (user_id, token, created_at) VALUES (?, ?, NOW())')->execute([$userId, $token]);
        $verifyUrl = base_url('verify-email?token=' . urlencode($token) . '&uid=' . $userId);
        send_email($email, 'Verifikasi Email', '<p>Halo ' . htmlspecialchars($name) . ',</p><p>Silakan verifikasi email Anda: <a href="' . $verifyUrl . '">Verifikasi</a></p>');

        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Registrasi berhasil, cek email untuk verifikasi'];
        header('Location: ' . base_url('login')); exit;
    }

    public function logout(): string {
        session_destroy();
        header('Location: ' . base_url('login')); exit;
    }

    public function verifyEmail(): string {
        $token = $_GET['token'] ?? '';
        $uid = (int)($_GET['uid'] ?? 0);
        if ($token && $uid) {
            $stmt = db()->prepare('SELECT 1 FROM email_verifications WHERE user_id=? AND token=?');
            $stmt->execute([$uid,$token]);
            if ($stmt->fetch()) {
                db()->prepare('UPDATE users SET verified=1 WHERE id=?')->execute([$uid]);
                db()->prepare('DELETE FROM email_verifications WHERE user_id=?')->execute([$uid]);
                $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Email terverifikasi, silakan login'];
                header('Location: ' . base_url('login')); exit;
            }
        }
        http_response_code(400);
        return 'Invalid token';
    }

    public function forgotPassword(): string {
        return $this->render('auth/forgot-password', ['title' => 'Lupa Password']);
    }

    public function doForgotPassword(): string {
        $email = trim($_POST['email'] ?? '');
        if ($email) {
            $stmt = db()->prepare('SELECT id,name FROM users WHERE email=? LIMIT 1');
            $stmt->execute([$email]);
            if ($u = $stmt->fetch()) {
                require_once BASE_PATH . '/config/mailer.php';
                $token = bin2hex(random_bytes(16));
                db()->prepare('INSERT INTO password_resets (user_id, token, created_at) VALUES (?, ?, NOW())')->execute([(int)$u['id'], $token]);
                $resetUrl = base_url('reset-password?token=' . urlencode($token) . '&uid=' . (int)$u['id']);
                send_email($email, 'Reset Password', '<p>Halo ' . htmlspecialchars($u['name']) . ',</p><p>Reset password: <a href="' . $resetUrl . '">Reset</a></p>');
            }
        }
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Jika email terdaftar, tautan reset telah dikirim'];
        header('Location: ' . base_url('login')); exit;
    }

    public function resetPassword(): string {
        return $this->render('auth/reset-password', ['title' => 'Reset Password']);
    }

    public function doResetPassword(): string {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['password_confirmation'] ?? '';
        if ($password !== '' && $password === $confirm) {
            $stmt = db()->prepare('SELECT user_id FROM password_resets WHERE token=? LIMIT 1');
            $stmt->execute([$token]);
            if ($row = $stmt->fetch()) {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                db()->prepare('UPDATE users SET password=? WHERE id=?')->execute([$hash, (int)$row['user_id']]);
                db()->prepare('DELETE FROM password_resets WHERE user_id=?')->execute([(int)$row['user_id']]);
                $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Password diperbarui'];
                header('Location: ' . base_url('login')); exit;
            }
        }
        $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Token invalid atau password tidak cocok'];
        header('Location: ' . base_url('reset-password?token=' . urlencode($token))); exit;
    }
}

