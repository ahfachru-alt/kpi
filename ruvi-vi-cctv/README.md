Monitoring CCTV RU VI Balongan (Native PHP MVC)

- PHP Native, Manual MVC, Routing basic
- FFmpeg to HLS (.m3u8) starter via public/api/ffmpeg.php
- Leaflet OSM + Satellite, status filters
- Auth (login/register), roles admin/user, CSV export

Quick Start

1. Create database and import schema from `scripts/schema.sql` (to be added)
2. Configure DB via env vars: DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_PORT
3. Serve `public/` as web root (Apache with the provided .htaccess)
4. Open `/` for welcome page. Register or login.

Streaming

GET `public/api/ffmpeg.php?rtsp=rtsp://...` will spawn FFmpeg writing HLS into `public/live/*.m3u8`.

