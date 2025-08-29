<?php
class RoomController {
    private function render(string $view, array $data = []): string {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        include BASE_PATH . '/views/' . $view . '.php';
        return (string)ob_get_clean();
    }
    public function index(): string {
        require_admin();
        $rows = db()->query('SELECT rooms.*, buildings.name AS building_name FROM rooms JOIN buildings ON buildings.id = rooms.building_id ORDER BY rooms.id DESC')->fetchAll();
        $buildings = db()->query('SELECT id,name FROM buildings ORDER BY name')->fetchAll();
        return $this->render('admin/room', ['title' => 'Ruangan', 'rows' => $rows, 'buildings' => $buildings]);
    }
    public function create(): string {
        require_admin();
        $buildingId = (int)($_POST['building_id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        if ($buildingId && $name !== '') {
            $stmt = db()->prepare('INSERT INTO rooms (building_id, name) VALUES (?, ?)');
            $stmt->execute([$buildingId, $name]);
        }
        header('Location: ' . base_url('admin/rooms')); exit;
    }
    public function update(): string {
        require_admin();
        $id = (int)($_POST['id'] ?? 0);
        $buildingId = (int)($_POST['building_id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        if ($id && $buildingId && $name !== '') {
            $stmt = db()->prepare('UPDATE rooms SET building_id=?, name=? WHERE id=?');
            $stmt->execute([$buildingId, $name, $id]);
        }
        header('Location: ' . base_url('admin/rooms')); exit;
    }
    public function delete(): string {
        require_admin();
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $stmt = db()->prepare('DELETE FROM rooms WHERE id=?');
            $stmt->execute([$id]);
        }
        header('Location: ' . base_url('admin/rooms')); exit;
    }
    public function export(): void {
        require_admin();
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="rooms.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID','Building ID','Name']);
        $stmt = db()->query('SELECT id,building_id,name FROM rooms');
        while ($row = $stmt->fetch()) { fputcsv($out, $row); }
        fclose($out);
        exit;
    }
}

