<?php

namespace App\Livewire\Home;

use App\Livewire\BaseController;
use App\Models\JobsAnalysis;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;

class Interview extends BaseController
{
    use WithFileUploads;

    protected $listeners = [
        'refresh' => 'checkFetched',
        'refreshComponent' => '$refresh',
    ];

    public $chats = [];

    public $cameras = [];
    public $cameraId = 0;
    public $microphones = [];
    public $microphoneId = 0;
    public $audioBlob = null;

    public $started = false;
    public $muted = true;
    public $disabled = false;
    public $loading = false;

    public $api_url = "";

    public $sessionIdentifier = null;
    public $positionName = "";

    public function mount()
    {
        $this->api_url = env("INTERVIEW_API_URL", "http://localhost:8000");

        $user = User::find(auth()->id());

        $this->sessionIdentifier = uniqid($user->id . '_');
        $this->positionName = $user->position->name;

        $this->checkFetched();
    }

    public function checkFetched()
    {
        $user = User::find(auth()->user()->id);
        $position_id = $user->position_id;

        $fetched = JobsAnalysis::fetched($position_id);

        if (!$fetched) {
            redirect()->route('home')->with('toast', ['type' => 'error', 'message' => 'Please generate job analysis first']);
        }

        $this->dispatch('refreshComponent');
    }

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

    public function start()
    {
        $response = Http::withOptions(['verify' => false])->get("$this->api_url/config");

        $welcomeAudioUrl = $response->json()['tts_service'] === 'openai' ?
            "$this->api_url/static/welcoming/welcoming-alloy.wav" :
            "$this->api_url/static/welcoming/welcoming-zephlyn.wav";

        $dispatchMessage = [
            "audioUrl" => $welcomeAudioUrl,
            "transcription" => "Terima kasih karena telah mempunyai ketertarikan pada perusahaan kami, Nama saya Mirai dari tim rekrutmen. Terima kasih sudah meluangkan waktu untuk mengikuti sesi wawancara ini. Kami sangat senang bisa mengenal Anda lebih dekat hari ini. Semoga kita bisa melalui sesi ini dengan lancar dan nyaman. Jika ada hal yang ingin ditanyakan selama wawancara, jangan ragu untuk mengatakannya. Mari kita mulai dengan perkenalan diri anda secara kreatif."
        ];

        $this->dispatch('play-audio', $dispatchMessage);
    }

    public function updatedAudioBlob()
    {
        $this->disabled = true;
        $this->loading = true;

        $this->dispatch('new-chat');

        $queries = [
            'user_id' => $this->sessionIdentifier,
            'position' => $this->positionName,
        ];

        $stringifiedQueries = http_build_query($queries);

        $context = ['http' => ['method' => 'GET'], 'ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]];
        $context = stream_context_create($context);

        $response = Http::withOptions(['verify' => false])->attach('audio', file_get_contents($this->audioBlob->getRealPath(), false, $context), 'audio.wav')
            ->post("$this->api_url/speak?$stringifiedQueries");

        unlink($this->audioBlob->getRealPath());

        $response = $response->json();

        $this->addChat($response['transcription'], auth()->user()->name, 'sent');

        $this->dispatch('new-chat');

        $dispatchMessage = [
            "audioUrl" => $this->api_url . $response['audio_url'],
            "transcription" => $response['ai_response']
        ];

        $this->dispatch('play-audio', $dispatchMessage);
    }

    public function render()
    {
        return view('livewire.home.interview')->extends('layouts.home.base', ['activeTab' => 'interview']);
    }
}
