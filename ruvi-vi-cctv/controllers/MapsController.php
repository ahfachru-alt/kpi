<?php
class MapsController {
    private function render(string $view, array $data = []): string {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        include BASE_PATH . '/views/' . $view . '.php';
        return (string)ob_get_clean();
    }
    public function admin(): string {
        require_admin();
        $buildings = db()->query('SELECT * FROM buildings ORDER BY name')->fetchAll();
        $rooms = db()->query('SELECT rooms.*, buildings.name AS building_name FROM rooms JOIN buildings ON buildings.id = rooms.building_id')->fetchAll();
        $cctvs = db()->query('SELECT cctvs.*, rooms.name AS room_name FROM cctvs JOIN rooms ON rooms.id = cctvs.room_id')->fetchAll();
        return $this->render('admin/maps', ['title' => 'Peta', 'buildings' => $buildings, 'rooms' => $rooms, 'cctvs' => $cctvs]);
    }
    public function user(): string {
        require_auth();
        $buildings = db()->query('SELECT * FROM buildings ORDER BY name')->fetchAll();
        $rooms = db()->query('SELECT rooms.*, buildings.name AS building_name FROM rooms JOIN buildings ON buildings.id = rooms.building_id')->fetchAll();
        $cctvs = db()->query('SELECT cctvs.*, rooms.name AS room_name FROM cctvs JOIN rooms ON rooms.id = cctvs.room_id')->fetchAll();
        return $this->render('user/maps', ['title' => 'Peta', 'buildings' => $buildings, 'rooms' => $rooms, 'cctvs' => $cctvs]);
    }
}

