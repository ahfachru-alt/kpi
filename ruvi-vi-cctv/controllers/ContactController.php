<?php
class ContactController {
    private function render(string $view, array $data = []): string {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        include BASE_PATH . '/views/' . $view . '.php';
        return (string)ob_get_clean();
    }
    public function admin(): string {
        require_admin();
        $rows = db()->query('SELECT * FROM contacts ORDER BY id DESC')->fetchAll();
        return $this->render('admin/contact', ['title' => 'Kontak', 'rows' => $rows]);
    }
    public function create(): string {
        require_admin();
        $stmt = db()->prepare('INSERT INTO contacts (name,email,phone,whatsapp,address) VALUES (?,?,?,?,?)');
        $stmt->execute([
            trim($_POST['name'] ?? ''),
            trim($_POST['email'] ?? ''),
            trim($_POST['phone'] ?? ''),
            trim($_POST['whatsapp'] ?? ''),
            trim($_POST['address'] ?? ''),
        ]);
        header('Location: ' . base_url('admin/contacts')); exit;
    }
    public function update(): string {
        require_admin();
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $stmt = db()->prepare('UPDATE contacts SET name=?, email=?, phone=?, whatsapp=?, address=? WHERE id=?');
            $stmt->execute([
                trim($_POST['name'] ?? ''),
                trim($_POST['email'] ?? ''),
                trim($_POST['phone'] ?? ''),
                trim($_POST['whatsapp'] ?? ''),
                trim($_POST['address'] ?? ''),
                $id,
            ]);
        }
        header('Location: ' . base_url('admin/contacts')); exit;
    }
    public function delete(): string {
        require_admin();
        $id = (int)($_POST['id'] ?? 0);
        if ($id) { db()->prepare('DELETE FROM contacts WHERE id=?')->execute([$id]); }
        header('Location: ' . base_url('admin/contacts')); exit;
    }
    public function export(): void {
        require_admin();
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="contacts.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID','Name','Email','Phone','Whatsapp','Address']);
        $stmt = db()->query('SELECT id,name,email,phone,whatsapp,address FROM contacts');
        while ($row = $stmt->fetch()) { fputcsv($out, $row); }
        fclose($out);
        exit;
    }
    public function user(): string {
        require_auth();
        $rows = db()->query('SELECT * FROM contacts ORDER BY id DESC')->fetchAll();
        return $this->render('user/contact', ['title' => 'Kontak', 'rows' => $rows]);
    }
}

