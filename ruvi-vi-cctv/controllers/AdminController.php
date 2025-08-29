<?php
class AdminController {
    private function render(string $view, array $data = []): string {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        include BASE_PATH . '/views/' . $view . '.php';
        return (string)ob_get_clean();
    }

    public function dashboard(): string {
        require_admin();
        $stats = [
            'users_total' => (int)db()->query('SELECT COUNT(*) AS c FROM users')->fetch()['c'],
            'buildings_total' => (int)db()->query('SELECT COUNT(*) AS c FROM buildings')->fetch()['c'],
            'rooms_total' => (int)db()->query('SELECT COUNT(*) AS c FROM rooms')->fetch()['c'],
            'cctvs_total' => (int)db()->query('SELECT COUNT(*) AS c FROM cctvs')->fetch()['c'],
            'cctv_online' => (int)db()->query("SELECT COUNT(*) AS c FROM cctvs WHERE status='online'")->fetch()['c'],
            'cctv_offline' => (int)db()->query("SELECT COUNT(*) AS c FROM cctvs WHERE status='offline'")->fetch()['c'],
            'cctv_maintenance' => (int)db()->query("SELECT COUNT(*) AS c FROM cctvs WHERE status='maintenance'")->fetch()['c'],
        ];
        return $this->render('admin/dashboard', ['title' => 'Admin Dashboard', 'stats' => $stats]);
    }

    public function users(): string {
        require_admin();
        $users = db()->query('SELECT id, name, email, role, verified, theme FROM users ORDER BY id DESC')->fetchAll();
        return $this->render('admin/user', ['title' => 'Kelola User', 'users' => $users]);
    }

    public function createUser(): string {
        require_admin();
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = ($_POST['role'] ?? 'user') === 'admin' ? 'admin' : 'user';
        if ($name && $email && $password) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = db()->prepare('INSERT INTO users (name,email,password,role,verified,theme) VALUES (?,?,?,?,0, "system")');
            $stmt->execute([$name,$email,$hash,$role]);
        }
        header('Location: ' . base_url('admin/users')); exit;
    }

    public function updateUser(): string {
        require_admin();
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = ($_POST['role'] ?? 'user') === 'admin' ? 'admin' : 'user';
        if ($id && $name && $email) {
            $stmt = db()->prepare('UPDATE users SET name=?, email=?, role=? WHERE id=?');
            $stmt->execute([$name,$email,$role,$id]);
        }
        header('Location: ' . base_url('admin/users')); exit;
    }

    public function deleteUser(): string {
        require_admin();
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $stmt = db()->prepare('DELETE FROM users WHERE id=?');
            $stmt->execute([$id]);
        }
        header('Location: ' . base_url('admin/users')); exit;
    }

    public function exportUsers(): void {
        require_admin();
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="users.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID','Name','Email','Role','Verified','Theme']);
        $stmt = db()->query('SELECT id,name,email,role,verified,theme FROM users');
        while ($row = $stmt->fetch()) { fputcsv($out, $row); }
        fclose($out);
        exit;
    }
}

