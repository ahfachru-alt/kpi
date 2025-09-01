<?php

namespace App\Livewire\User\Cctv;

use App\Models\Cctv;
use Livewire\Component;

class ShowStream extends Component
{
    public Cctv $cctv;
    public $streamUrl;
    public $isStreaming = false;
    public $streamError = null;

    public function mount($cctv)
    {
        $this->cctv = $cctv;
        $this->streamUrl = $this->cctv->hls_url;
        $this->checkStreamStatus();
    }

    public function checkStreamStatus()
    {
        // Check if the CCTV is online and streaming
        $this->isStreaming = $this->cctv->isOnline();
        
        if (!$this->isStreaming) {
            $this->streamError = 'CCTV is currently offline or in maintenance mode.';
        }
    }

    public function refreshStream()
    {
        $this->checkStreamStatus();
        $this->streamError = null;
    }

    public function render()
    {
        return view('livewire.user.cctv.show-stream')->layout('components.layouts.app');
    }
}