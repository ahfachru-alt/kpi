# KILANG PERTAMINA INTERNASIONAL - CCTV Monitoring Platform

Sistem web aplikasi Fullstack Laravel 12 Monitoring CCTV untuk "Kilang Pertamina Internasional RU VI Balongan" dengan fitur lengkap monitoring, streaming, dan manajemen CCTV.

## 🚀 Fitur Utama

- **Laravel 12 + Livewire 3.x** - Framework modern dengan real-time components
- **Role-based Access Control** - Admin dan User dengan hak akses berbeda
- **Real-time CCTV Streaming** - Menggunakan FFmpeg untuk konversi RTSP ke HLS
- **Interactive Maps** - Leaflet Maps dengan OpenStreetMap dan satelit
- **Real-time Notifications** - Sistem notifikasi dan pesan real-time
- **Modern UI/UX** - Desain 3D dengan sidebar modular
- **Theme Support** - Light, Dark, dan System theme
- **Export Data** - Export ke Excel untuk semua data
- **Responsive Design** - Mobile-friendly interface

## 🏗️ Struktur Aplikasi

### Admin Features
- Dashboard dengan analytics lengkap
- Manajemen User (CRUD)
- Manajemen Building, Room, dan CCTV
- Manajemen Maps dan Location
- Manajemen Contact
- Sistem Notifikasi dan Pesan
- Export data ke Excel

### User Features
- Dashboard dengan overview CCTV
- Interactive Maps dengan marker CCTV
- View CCTV streams real-time
- Akses ke informasi lokasi
- Sistem notifikasi dan pesan
- Contact information

## 📋 Requirements

- PHP 8.2+
- MySQL 8.0+
- FFmpeg
- Composer
- Node.js & NPM

## 🛠️ Installation

### 1. Clone Repository
```bash
git clone <repository-url>
cd pertamina-cctv-monitoring
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
```

Edit file `.env` dengan konfigurasi database dan email:
```env
APP_NAME="KILANG PERTAMINA INTERNASIONAL"
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pertamina_cctv
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="KILANG PERTAMINA INTERNASIONAL"
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### 6. Build Assets
```bash
npm run build
```

### 7. Start Application
```bash
php artisan serve
```

## 🔐 Default Login

**Admin:**
- Email: `admin@pertamina.com`
- Password: `admin123`

## 📱 URL Routes

### Admin Routes
- Dashboard: `/admin/dashboard`
- User Management: `/admin/user-list`, `/admin/create-user`
- Maps Management: `/admin/maps-list`, `/admin/create-maps`
- Location Management: `/admin/location-list`, `/admin/create-location`
- Contact Management: `/admin/contact-list`, `/admin/create-contact`
- Notifications: `/admin/notification`
- Messages: `/admin/message`

### User Routes
- Dashboard: `/user/dashboard`
- Maps: `/user/maps`
- Location: `/user/location`
- Rooms: `/user/location/room`
- CCTV: `/user/location/room/cctv`
- Contact: `/user/contact`
- Notifications: `/user/notification`
- Messages: `/user/message`

## 🎥 CCTV Streaming

### Manual Start
```bash
php artisan cctv:stream
```

### Auto Start (Cron Job)
Tambahkan ke crontab:
```bash
* * * * * cd /path/to/project && php artisan cctv:stream
```

## 🗄️ Database Structure

### Tables
- `users` - User dan admin accounts
- `buildings` - Data gedung dengan koordinat
- `rooms` - Ruangan dalam gedung
- `cctvs` - Data CCTV dengan IP dan status
- `notifications` - Sistem notifikasi
- `messages` - Sistem pesan antar user
- `contacts` - Informasi kontak

### CCTV IP Format
```
rtsp://admin:password.123@10.56.236.001/streaming/channels/
rtsp://admin:password.123@10.56.236.002/streaming/channels/
...
rtsp://admin:password.123@10.56.236.700/streaming/channels/
```

## 🎨 Customization

### Logo dan Branding
- Ganti `public/images/pertamina.png` dengan logo custom
- Ganti `public/images/kilang.png` dengan background custom
- Update nama aplikasi di `.env` dan views

### Theme Colors
- Edit CSS variables di `resources/css/app.css`
- Customize Tailwind config di `tailwind.config.js`

## 📊 Monitoring & Maintenance

### Log Files
- Application logs: `storage/logs/laravel.log`
- CCTV streaming logs: `storage/logs/cctv-streaming.log`

### Performance
- Cache: `php artisan cache:clear`
- Config: `php artisan config:clear`
- Route: `php artisan route:clear`
- View: `php artisan view:clear`

## 🚨 Troubleshooting

### CCTV Stream Issues
1. Check FFmpeg installation: `ffmpeg -version`
2. Verify RTSP URLs are accessible
3. Check storage permissions for `public/live/` directory
4. Monitor system resources during streaming

### Database Issues
1. Verify MySQL connection in `.env`
2. Check database permissions
3. Run migrations: `php artisan migrate:fresh --seed`

### Permission Issues
```bash
chmod -R 755 storage/
chmod -R 755 public/
chown -R www-data:www-data storage/
chown -R www-data:www-data public/
```

## 📞 Support

Untuk dukungan teknis atau pertanyaan:
- Email: support@pertamina.com
- Phone: +62-21-XXXX-XXXX
- Documentation: [Link ke dokumentasi]

## 📄 License

Proyek ini dikembangkan untuk internal use oleh Kilang Pertamina Internasional RU VI Balongan.

---

**© 2024 Kilang Pertamina Internasional RU VI Balongan. All rights reserved.**