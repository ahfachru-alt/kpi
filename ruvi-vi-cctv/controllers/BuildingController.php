<?php
class BuildingController {
    private function render(string $view, array $data = []): string {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        include BASE_PATH . '/views/' . $view . '.php';
        return (string)ob_get_clean();
    }
    public function index(): string {
        require_admin();
        $rows = db()->query('SELECT * FROM buildings ORDER BY id DESC')->fetchAll();
        return $this->render('admin/building', ['title' => 'Gedung', 'rows' => $rows]);
    }
    public function create(): string {
        require_admin();
        $name = trim($_POST['name'] ?? '');
        $lat = (float)($_POST['lat'] ?? 0);
        $lng = (float)($_POST['lng'] ?? 0);
        if ($name !== '') {
            $stmt = db()->prepare('INSERT INTO buildings (name, lat, lng) VALUES (?, ?, ?)');
            $stmt->execute([$name, $lat, $lng]);
        }
        header('Location: ' . base_url('admin/buildings')); exit;
    }
    public function update(): string {
        require_admin();
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $lat = (float)($_POST['lat'] ?? 0);
        $lng = (float)($_POST['lng'] ?? 0);
        if ($id && $name !== '') {
            $stmt = db()->prepare('UPDATE buildings SET name=?, lat=?, lng=? WHERE id=?');
            $stmt->execute([$name, $lat, $lng, $id]);
        }
        header('Location: ' . base_url('admin/buildings')); exit;
    }
    public function delete(): string {
        require_admin();
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $stmt = db()->prepare('DELETE FROM buildings WHERE id=?');
            $stmt->execute([$id]);
        }
        header('Location: ' . base_url('admin/buildings')); exit;
    }
    public function export(): void {
        require_admin();
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="buildings.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID','Name','Lat','Lng']);
        $stmt = db()->query('SELECT id,name,lat,lng FROM buildings');
        while ($row = $stmt->fetch()) { fputcsv($out, $row); }
        fclose($out);
        exit;
    }
}

