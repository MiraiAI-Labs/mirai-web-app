<?php

namespace App\Livewire\Home;

use Livewire\Component;

class Interview extends Component
{
    public $chats = [];

    public $cameras = [];
    public $cameraId = 0;
    public $microphones = [];
    public $microphoneId = 0;
    public $audioBlob = null;

    public function addChat($message, $name, $type)
    {
        $this->chats[] = [
            'name' => $name,
            'message' => $message,
            'type' => $type,
        ];

        $this->dispatch('new-chat');
    }

    public function setCamera($id)
    {
        $this->cameraId = $id;
    }

    public function setMicrophone($id)
    {
        $this->microphoneId = $id;
    }

    public function render()
    {
        return view('livewire.home.interview')->extends('layouts.home.base', ['activeTab' => 'interview']);
    }
}
