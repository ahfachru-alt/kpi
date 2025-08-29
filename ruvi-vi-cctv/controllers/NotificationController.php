<?php
class NotificationController {
    private function render(string $view, array $data = []): string {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        include BASE_PATH . '/views/' . $view . '.php';
        return (string)ob_get_clean();
    }
    public function admin(): string {
        require_admin();
        $rows = db()->query('SELECT n.*, u.name AS user_name FROM notifications n JOIN users u ON u.id = n.user_id ORDER BY n.created_at DESC')->fetchAll();
        return $this->render('admin/notification', ['title' => 'Notifikasi', 'rows' => $rows]);
    }
    public function user(): string {
        require_auth();
        $uid = (int)$_SESSION['user']['id'];
        $stmt = db()->prepare('SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$uid]);
        return $this->render('user/notification', ['title' => 'Notifikasi', 'rows' => $stmt->fetchAll()]);
    }
}

