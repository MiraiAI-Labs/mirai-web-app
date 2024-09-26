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

    // 0 = HR, 1 = Tech
    public $interviewType;

    public function mount()
    {
        $this->api_url = env("INTERVIEW_API_URL", "http://localhost:8000");

        $user = User::find(auth()->id());

        $this->sessionIdentifier = uniqid($user->id . '_');
        $this->positionName = $user->position->name;
        $this->checkFetched();

        $this->interviewType = 0;
    }

    public function getCurrentType()
    {
        switch ($this->interviewType) {
            case 0:
                return 'hr';
            case 1:
                return 'tech';
            default:
                return 'hr';
        }
    }

    public function getInterviewName()
    {
        return $this->getCurrentType() === 'hr' ? 'HR' : 'Technical';
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

    public function addEvaluation($message, $name, $labels, $data)
    {
        $id = uniqid();
        $this->chats[] = [
            'name' => $name,
            'message' => $message,
            'type' => 'evaluated',
            'labels' => $labels,
            'data' => $data,
            'id' => $id,
        ];

        $this->dispatch('new-chat');

        $dispatchMessage = [
            "labels" => $labels,
            "data" => $data,
            "id" => $id,
        ];

        $this->dispatch('render-evaluasi', $dispatchMessage);
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
        $type = $this->getCurrentType();

        $response = Http::withOptions(['verify' => false])->get("$this->api_url/config");

        $welcomeAudioUrl = $response->json()['tts_service'] === 'openai' ?
            "$this->api_url/static/welcoming/welcoming" . ($type === 'tech' ? "-tech" : "") . "-alloy.wav" :
            "$this->api_url/static/welcoming/welcoming" . ($type === 'tech' ? "-tech" : "") . "-zephlyn.wav";

        $message = ($type === 'tech') ?
            "Terima kasih karena telah mempunyai ketertarikan pada perusahaan kami, Nama saya Mirai dari tim rekrutmen. Terima kasih sudah meluangkan waktu untuk mengikuti sesi wawancara ini. Kami sangat senang bisa mengenal Anda lebih dekat hari ini. Semoga kita bisa melalui sesi ini dengan lancar dan nyaman. Jika ada hal yang ingin ditanyakan selama wawancara, jangan ragu untuk mengatakannya. Mari kita mulai dengan perkenalan diri anda secara kreatif." :
            "Selamat datang di wawancara fase teknikal. Nama saya Mirai. Terima kasih sudah meluangkan waktu untuk mengikuti sesi wawancara ini. Semoga kita bisa melalui sesi ini dengan lancar dan nyaman. Jika ada hal yang ingin ditanyakan selama wawancara, jangan ragu untuk mengatakannya. Mari kita mulai dengan perkenalan.";

        $dispatchMessage = [
            "audioUrl" => $welcomeAudioUrl,
            "transcription" => $message,
            "isEvaluated" => false,
            "name" => $this->getInterviewName(),
        ];

        $this->dispatch('play-audio', $dispatchMessage);
    }

    public function updatedAudioBlob()
    {
        $type = $this->getCurrentType();

        $this->disabled = true;
        $this->loading = true;

        $this->dispatch('new-chat');

        $queries = [
            'user_id' => $this->sessionIdentifier,
            'position' => $this->positionName,
            'interview_type' => $type,
        ];

        $stringifiedQueries = http_build_query($queries);

        $context = ['http' => ['method' => 'GET'], 'ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]];
        $context = stream_context_create($context);

        $response = Http::withOptions(['verify' => false])->attach('audio', file_get_contents($this->audioBlob->getRealPath(), false, $context), 'audio.wav')
            ->post("$this->api_url/speak?$stringifiedQueries");

        unlink($this->audioBlob->getRealPath());

        $response = $response->json();

        if (isset($response['transcription'])) {
            $this->addChat($response['transcription'], auth()->user()->name, 'sent');
            $this->dispatch('new-chat');
        }


        if (isset($response['ai_response'])) {
            $isEvaluated = is_array($response['ai_response']) || is_object($response['ai_response']);

            $dispatchMessage = [
                "audioUrl" => $this->api_url . $response['audio_url'],
                "transcription" => ($isEvaluated) ? json_encode($response['ai_response']) : $response['ai_response'],
                "isEvaluated" => $isEvaluated,
                "name" => $this->getInterviewName(),
            ];

            $this->dispatch('play-audio', $dispatchMessage);

            if ($isEvaluated) {
                $this->interviewType++;

                if ($this->interviewType < 1) {
                    $this->start();
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.home.interview')->extends('layouts.home.base', ['activeTab' => 'interview']);
    }
}
