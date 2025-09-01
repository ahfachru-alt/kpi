<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cctv;

class StreamCctvCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cctv:stream';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start streaming all CCTV cameras using FFmpeg';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting CCTV streaming...');

        $cctvs = Cctv::all();
        $this->info("Found {$cctvs->count()} CCTV cameras");

        foreach ($cctvs as $cctv) {
            $this->startStream($cctv);
        }

        $this->info('CCTV streaming started successfully!');
        $this->info('Streams are available at: ' . asset('live/'));
    }

    /**
     * Start streaming for a specific CCTV
     */
    private function startStream(Cctv $cctv)
    {
        $ip = $cctv->ip_address;
        $output = public_path('live/' . str_replace(['.', ':', '@'], '_', parse_url($ip, PHP_URL_HOST)) . '.m3u8');

        // Create live directory if it doesn't exist
        if (!file_exists(dirname($output))) {
            mkdir(dirname($output), 0755, true);
        }

        // Check if stream is already running
        $pidFile = storage_path('app/cctv_streams/' . $cctv->id . '.pid');
        if (file_exists($pidFile)) {
            $pid = file_get_contents($pidFile);
            if (posix_kill($pid, 0)) {
                $this->line("Stream for CCTV {$cctv->name} is already running (PID: {$pid})");
                return;
            }
        }

        // Start FFmpeg stream
        $cmd = "ffmpeg -rtsp_transport tcp -i \"{$ip}\" " .
               "-c:v libx264 -preset ultrafast -tune zerolatency " .
               "-f hls -hls_time 1 -hls_list_size 3 -hls_flags delete_segments " .
               "\"{$output}\" > /dev/null 2>&1 & echo \$!";

        $pid = exec($cmd);

        if ($pid) {
            // Save PID for later management
            if (!file_exists(dirname($pidFile))) {
                mkdir(dirname($pidFile), 0755, true);
            }
            file_put_contents($pidFile, $pid);
            
            $this->line("Started streaming for CCTV {$cctv->name} (PID: {$pid})");
        } else {
            $this->error("Failed to start streaming for CCTV {$cctv->name}");
        }
    }

    /**
     * Stop all CCTV streams
     */
    public function stopAllStreams()
    {
        $pidDir = storage_path('app/cctv_streams');
        
        if (!file_exists($pidDir)) {
            return;
        }

        $pidFiles = glob($pidDir . '/*.pid');
        
        foreach ($pidFiles as $pidFile) {
            $pid = file_get_contents($pidFile);
            if (posix_kill($pid, 0)) {
                posix_kill($pid, SIGTERM);
                unlink($pidFile);
                $this->line("Stopped stream (PID: {$pid})");
            }
        }
    }
}