<?php
class CctvController {
    private function render(string $view, array $data = []): string {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        include BASE_PATH . '/views/' . $view . '.php';
        return (string)ob_get_clean();
    }
    public function index(): string {
        require_admin();
        $rows = db()->query('SELECT cctvs.*, rooms.name AS room_name FROM cctvs JOIN rooms ON rooms.id = cctvs.room_id ORDER BY cctvs.id DESC')->fetchAll();
        $rooms = db()->query('SELECT id,name FROM rooms ORDER BY id DESC')->fetchAll();
        return $this->render('admin/cctv', ['title' => 'CCTV', 'rows' => $rows, 'rooms' => $rooms]);
    }
    public function create(): string {
        require_admin();
        $roomId = (int)($_POST['room_id'] ?? 0);
        $ip = trim($_POST['ip_address'] ?? '');
        $status = in_array($_POST['status'] ?? 'offline', ['online','offline','maintenance'], true) ? $_POST['status'] : 'offline';
        $streamUrl = trim($_POST['stream_url'] ?? '');
        $lat = isset($_POST['lat']) ? (float)$_POST['lat'] : null;
        $lng = isset($_POST['lng']) ? (float)$_POST['lng'] : null;
        if ($roomId && $ip !== '') {
            $stmt = db()->prepare('INSERT INTO cctvs (room_id, ip_address, status, stream_url, lat, lng) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$roomId, $ip, $status, $streamUrl, $lat, $lng]);
        }
        header('Location: ' . base_url('admin/cctvs')); exit;
    }
    public function update(): string {
        require_admin();
        $id = (int)($_POST['id'] ?? 0);
        $roomId = (int)($_POST['room_id'] ?? 0);
        $ip = trim($_POST['ip_address'] ?? '');
        $status = in_array($_POST['status'] ?? 'offline', ['online','offline','maintenance'], true) ? $_POST['status'] : 'offline';
        $streamUrl = trim($_POST['stream_url'] ?? '');
        $lat = isset($_POST['lat']) ? (float)$_POST['lat'] : null;
        $lng = isset($_POST['lng']) ? (float)$_POST['lng'] : null;
        if ($id && $roomId && $ip !== '') {
            $stmt = db()->prepare('UPDATE cctvs SET room_id=?, ip_address=?, status=?, stream_url=?, lat=?, lng=? WHERE id=?');
            $stmt->execute([$roomId, $ip, $status, $streamUrl, $lat, $lng, $id]);
        }
        header('Location: ' . base_url('admin/cctvs')); exit;
    }
    public function delete(): string {
        require_admin();
        $id = (int)($_POST['id'] ?? 0);
        if ($id) { db()->prepare('DELETE FROM cctvs WHERE id=?')->execute([$id]); }
        header('Location: ' . base_url('admin/cctvs')); exit;
    }
    public function export(): void {
        require_admin();
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="cctvs.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID','Room ID','IP Address','Status','Stream URL']);
        $stmt = db()->query('SELECT id,room_id,ip_address,status,stream_url FROM cctvs');
        while ($row = $stmt->fetch()) { fputcsv($out, $row); }
        fclose($out);
        exit;
    }
}

