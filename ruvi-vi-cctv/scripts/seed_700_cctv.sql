-- Seed 700 CCTV entries (room_id must exist; adjust to your room id)
SET @room_id = 1; -- TODO: change to valid room id
INSERT INTO cctvs (room_id, ip_address, status, stream_url, lat, lng)
VALUES
-- Generated IPs rtsp://admin:password.123@10.56.236.001..700
-- Default status offline, stream_url empty
-- Rough Balongan area center lat/lng offsets
-- Note: For large insert, consider batching
('1','rtsp://admin:password.123@10.56.236.001/streaming/channels/','offline','',-6.3640,108.4370);

-- For automation, prefer using PHP script to generate SQL according to existing rooms

