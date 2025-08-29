<?php
class UserController {
    private function render(string $view, array $data = []): string {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        include BASE_PATH . '/views/' . $view . '.php';
        return (string)ob_get_clean();
    }

    public function dashboard(): string {
        require_auth();
        $userId = (int)$_SESSION['user']['id'];
        $stats = [
            'buildings_total' => (int)db()->query('SELECT COUNT(*) AS c FROM buildings')->fetch()['c'],
            'rooms_total' => (int)db()->query('SELECT COUNT(*) AS c FROM rooms')->fetch()['c'],
            'cctv_online' => (int)db()->query("SELECT COUNT(*) AS c FROM cctvs WHERE status='online'")->fetch()['c'],
            'cctv_offline' => (int)db()->query("SELECT COUNT(*) AS c FROM cctvs WHERE status='offline'")->fetch()['c'],
            'cctv_maintenance' => (int)db()->query("SELECT COUNT(*) AS c FROM cctvs WHERE status='maintenance'")->fetch()['c'],
        ];
        $notifications = db()->prepare('SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 10');
        $notifications->execute([$userId]);
        return $this->render('user/dashboard', ['title' => 'Dashboard', 'stats' => $stats, 'notifications' => $notifications->fetchAll()]);
    }

    public function location(): string {
        require_auth();
        $buildings = db()->query('SELECT * FROM buildings ORDER BY name')->fetchAll();
        return $this->render('user/location', ['title' => 'Lokasi', 'buildings' => $buildings]);
    }

    public function cctvs(): string {
        require_auth();
        $cctvs = db()->query('SELECT cctvs.*, rooms.name AS room_name FROM cctvs JOIN rooms ON rooms.id = cctvs.room_id ORDER BY cctvs.id DESC')->fetchAll();
        return $this->render('user/cctv', ['title' => 'CCTV', 'cctvs' => $cctvs]);
    }
}

