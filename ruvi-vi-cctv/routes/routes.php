<?php
return [
    // Welcome & Auth
    'GET /' => 'AuthController@welcome',
    'GET /login' => 'AuthController@login',
    'POST /login' => 'AuthController@doLogin',
    'GET /register' => 'AuthController@register',
    'POST /register' => 'AuthController@doRegister',
    'GET /logout' => 'AuthController@logout',
    'GET /verify-email' => 'AuthController@verifyEmail',
    'GET /forgot-password' => 'AuthController@forgotPassword',
    'POST /forgot-password' => 'AuthController@doForgotPassword',
    'GET /reset-password' => 'AuthController@resetPassword',
    'POST /reset-password' => 'AuthController@doResetPassword',
    'POST /toggle-theme' => function () {
        require_auth();
        $theme = in_array($_POST['theme'] ?? 'system', ['system','light','dark'], true) ? $_POST['theme'] : 'system';
        $_SESSION['user']['theme'] = $theme;
        $stmt = db()->prepare('UPDATE users SET theme=? WHERE id=?');
        $stmt->execute([$theme, (int)$_SESSION['user']['id']]);
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? base_url())); exit;
    },

    // Admin
    'GET /admin' => 'AdminController@dashboard',
    'GET /admin/users' => 'AdminController@users',
    'POST /admin/users/create' => 'AdminController@createUser',
    'POST /admin/users/update' => 'AdminController@updateUser',
    'POST /admin/users/delete' => 'AdminController@deleteUser',

    'GET /admin/buildings' => 'BuildingController@index',
    'POST /admin/buildings/create' => 'BuildingController@create',
    'POST /admin/buildings/update' => 'BuildingController@update',
    'POST /admin/buildings/delete' => 'BuildingController@delete',

    'GET /admin/rooms' => 'RoomController@index',
    'POST /admin/rooms/create' => 'RoomController@create',
    'POST /admin/rooms/update' => 'RoomController@update',
    'POST /admin/rooms/delete' => 'RoomController@delete',

    'GET /admin/cctvs' => 'CctvController@index',
    'POST /admin/cctvs/create' => 'CctvController@create',
    'POST /admin/cctvs/update' => 'CctvController@update',
    'POST /admin/cctvs/delete' => 'CctvController@delete',
    'POST /admin/cctvs/start' => function () {
        require_admin();
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $stmt = db()->prepare('SELECT ip_address FROM cctvs WHERE id=?');
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if ($row) {
                $ip = $row['ip_address'];
                header('Location: ' . base_url('api/ffmpeg.php?rtsp=' . urlencode($ip))); exit;
            }
        }
        header('Location: ' . base_url('admin/cctvs')); exit;
    },

    'GET /admin/maps' => 'MapsController@admin',
    'GET /admin/notifications' => 'NotificationController@admin',
    'GET /admin/messages' => 'MessageController@admin',
    'GET /admin/profile' => 'ProfileController@admin',
    'GET /admin/contacts' => 'ContactController@admin',
    'POST /admin/contacts/create' => 'ContactController@create',
    'POST /admin/contacts/update' => 'ContactController@update',
    'POST /admin/contacts/delete' => 'ContactController@delete',
    'GET /admin/export/contacts' => 'ContactController@export',

    'GET /admin/export/users' => 'AdminController@exportUsers',
    'GET /admin/export/analytics' => 'AdminController@exportAnalytics',
    'GET /admin/export/buildings' => 'BuildingController@export',
    'GET /admin/export/rooms' => 'RoomController@export',
    'GET /admin/export/cctvs' => 'CctvController@export',

    // User
    'GET /user' => 'UserController@dashboard',
    'GET /user/maps' => 'MapsController@user',
    'GET /user/location' => 'UserController@location',
    'GET /user/cctvs' => 'UserController@cctvs',
    'GET /user/notifications' => 'NotificationController@user',
    'GET /user/messages' => 'MessageController@user',
    'GET /user/profile' => 'ProfileController@user',
    'GET /user/contact' => 'ContactController@user',
    'POST /messages/send' => function () {
        require_auth();
        $from = (int)($_POST['from_id'] ?? 0);
        $to = (int)($_POST['to_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');
        if ($from && $to && $content !== '') {
            $stmt = db()->prepare('INSERT INTO messages (from_id,to_id,content,created_at) VALUES (?,?,?,NOW())');
            $stmt->execute([$from,$to,$content]);
            // also create a notification to receiver
            $n = db()->prepare('INSERT INTO notifications (user_id,title,body,is_read,created_at) VALUES (?,?,?,0,NOW())');
            $n->execute([$to,'Pesan baru', $content]);
        }
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? base_url())); exit;
    },
    // Profile update endpoints
    'POST /profile/update' => 'ProfileController@update',
    'POST /profile/password' => 'ProfileController@password',
];

