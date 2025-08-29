<?php
class MessageController {
    private function render(string $view, array $data = []): string {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        include BASE_PATH . '/views/' . $view . '.php';
        return (string)ob_get_clean();
    }
    public function admin(): string {
        require_admin();
        $rows = db()->query('SELECT m.*, ufrom.name AS from_name, uto.name AS to_name FROM messages m JOIN users ufrom ON ufrom.id=m.from_id JOIN users uto ON uto.id=m.to_id ORDER BY m.created_at DESC')->fetchAll();
        return $this->render('admin/message', ['title' => 'Pesan', 'rows' => $rows]);
    }
    public function user(): string {
        require_auth();
        $uid = (int)$_SESSION['user']['id'];
        $stmt = db()->prepare('SELECT m.*, ufrom.name AS from_name, uto.name AS to_name FROM messages m JOIN users ufrom ON ufrom.id=m.from_id JOIN users uto ON uto.id=m.to_id WHERE m.from_id=? OR m.to_id=? ORDER BY m.created_at DESC');
        $stmt->execute([$uid, $uid]);
        return $this->render('user/message', ['title' => 'Pesan', 'rows' => $stmt->fetchAll()]);
    }
}

