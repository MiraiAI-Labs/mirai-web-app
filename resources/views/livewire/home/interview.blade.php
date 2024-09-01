@section('title')
    Practice Interview
@endsection

<div class="drawer-content-container">
    <section class="w-full flex justify-center mb-4">
        <livewire:components.choose-position :showResetPosition="true" />
    </section>
    <h2 class="text-2xl font-bold">Mockup Interview</h2>
    <section class="grid grid-cols-1 md:grid-cols-2 gap-4 h-4/5 mt-4 relative" x-data="interview">
        <div class="bg-base-100 rounded-xl flex justify-center items-center min-h-80 col-span-2" x-show="!started">
            <button class="btn btn-lg btn-neutral" x-on:click="start()">Mulai Interview</button>
        </div>
        <div class="bg-base-100 rounded-xl flex justify-center items-center min-h-80 relative" x-show="started">
            <video id="camera" class="aspect-video w-full flipped" autoplay></video>
            <footer class="flex text-justify items-center absolute bottom-3">

                <select id="chooseCamera" class="ml-4 select select-bordered w-full max-w-64 md:max-w-36 lg:max-w-56 text-ellipsis" wire:model="cameraId">
                    @foreach($cameras as $camera)
                        <option wire:click="setCamera('{{ $camera['deviceId'] }}')" {{ $camera['deviceId'] === $cameraId ? "selected" : "" }} value="{{ $camera['deviceId'] }}">{{ $camera['label'] }}</option>
                    @endforeach
                </select>

                <button x-on:click="toggle()" class="mx-4 btn rounded-full text-white text-2xl w-14 h-14" :class="muted === true ? 'btn-error' : 'btn-success'" x-bind:disabled="disabled">
                    <i class="fa-solid" :class="muted === true ? 'fa-microphone-lines-slash' : 'fa-microphone-lines'"></i>
                </button>

                <select id="chooseMicrophone" class="mr-4 select select-bordered w-full max-w-64 md:max-w-36 lg:max-w-64 text-ellipsis" wire:model="microphoneId">
                    @foreach($microphones as $microphone)
                        <option wire:click="setMicrophone('{{ $microphone['deviceId'] }}')" {{ $microphone['deviceId'] === $microphoneId ? "selected" : "" }} value="{{ $microphone['deviceId'] }}">{{ $microphone['label'] }}</option>
                    @endforeach
                </select>
            </footer>
        </div>
        <div class="bg-base-100 rounded-xl min-h-80" x-show="started">
            <header class="p-4 text-xl font-semibold text-center">Chat</header>
            <main id="chat" class="px-4 pb-4 text-justify overflow-y-scroll max-h-[300px]">
                @foreach($chats as $chat)
                    @if($chat['type'] === 'received')
                        <x-chat.left name="{{ $chat['name'] }}" message="{{ $chat['message'] }}" />
                    @else
                        <x-chat.right name="{{ $chat['name'] }}" message="{{ $chat['message'] }}" />
                    @endif
                    <br />
                @endforeach
                <div class="animate-pulse flex items-start gap-2.5 justify-start" x-show="loading">
                    <div class="bg-gray-100 flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                       <div class="flex items-center space-x-2 rtl:space-x-reverse">
                          <span class="bg-gray-300 w-24 h-4 rounded-xl"></span>
                       </div>
                       <p class="bg-gray-300 py-2.5 mt-2 rounded-xl"></p>
                    </div>
                </div>
            </main>
        </div>
    </section>
</div>

@section('scripts')
    <script>
        document.addEventListener('alpine:init', () => {      
            Alpine.data('interview', () => ({
                started: false,
                muted: true,
                disabled: false,
                deviceId: @entangle('microphoneId'),
                loading: false,
                mediaRecorder: null,
                start() {
                    this.started = true;

                    let t = this;

                    const stream = navigator.mediaDevices.getUserMedia({
                        audio: { deviceId: { exact: this.deviceId } }
                    }).then((stream) => {
                        t.handle(stream, (blob) => {
                            t.send(blob, true);
                        });

                        setTimeout(() => {
                            if(t.mediaRecorder)
                                t.mediaRecorder.stop();
                        }, 500);
                    }).catch((error) => {
                        console.log(error);
                        toastr.error('Please allow microphone access');
                    });
                },
                toggle() {
                    this.muted = !this.muted;

                    if(!this.muted)
                        this.record();
                    else
                        this.stop();
                },
                scroll() {
                    const chat = document.getElementById('chat');
                    chat.scroll({
                        top: chat.scrollHeight,
                        behavior: 'smooth'
                    });
                },
                record() {
                    let t = this;

                    const stream = navigator.mediaDevices.getUserMedia({
                        audio: { deviceId: { exact: this.deviceId } }
                    }).then((stream) => {
                        t.handle(stream);
                    }).catch((error) => {
                        toastr.error('Please allow microphone access');
                    });
                },
                handle(stream, callback = null) {
                    this.mediaRecorder = new MediaRecorder(stream);

                    const audioChunks = [];

                    this.mediaRecorder.ondataavailable = (e) => {
                        if (e.data.size > 0) {
                            audioChunks.push(e.data);
                        }
                    };

                    this.mediaRecorder.onstop = () => {
                        this.loading = true;
                        this.scroll();

                        const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });

                        if(callback)
                            callback(audioBlob);
                        else
                            this.send(audioBlob);
                    };

                    this.mediaRecorder.start();
                },
                stop() {
                    if(this.mediaRecorder)
                    {
                        this.mediaRecorder.stop();
                        this.mediaRecorder = null;
                    }
                },
                send(blob, skipSender = false) {
                    // play audio
                    // const audioUrl = URL.createObjectURL(audioBlob);
                    // const audio = new Audio(audioUrl);
                    // audio.play();
                    
                    let t = this;
                    t.disabled = true;

                    const formData = new FormData();
                    formData.append('audio', blob);

                    fetch('{{ env("INTERVIEW_API_URL", "http://localhost:8000") }}/speak', {
                        method: 'POST',
                        body: formData
                    }).then(response => response.json()).then(data => {
                        if(skipSender === false)
                        {
                            @this.addChat(data.transcription, '{{ auth()->user()->name }}', 'sent');
                            t.scroll();
                        }

                        const audio = `{{ env("INTERVIEW_API_URL", "http://localhost:8000") }}${data.audio_url}`;
                        const audioElement = new Audio(audio);
                        audioElement.play();

                        audioElement.onended = () => {
                            @this.addChat(data.ai_response, 'Interviewer', 'received');
                            t.scroll();
                            t.disabled = false;
                            t.loading = false;
                        };
                    });
                }
            }))
        })

        document.addEventListener('DOMContentLoaded', function () {
            navigator.mediaDevices.getUserMedia({audio:true,video:true}).then( () => {
                navigator.mediaDevices.enumerateDevices().then(function (devices) {
                    for(var i = 0; i < devices.length; i ++){
                        var device = devices[i];
                        if (device.kind === 'videoinput') {
                            @this.set('cameras', [...@this.cameras, { deviceId: device.deviceId, label: device.label || 'Camera ' + @this.cameras.length }]);
                        } else if (device.kind === 'audioinput') {
                            @this.set('microphones', [...@this.microphones, { deviceId: device.deviceId, label: device.label || 'Microphone ' + @this.microphones.length }]);
                        }
                    };

                    if (navigator.getUserMedia) {
                        navigator.mediaDevices.getUserMedia({ video: true })
                            .then((stream) => {
                                document.getElementById('camera').srcObject = stream;
                                @this.set('cameraId', stream.getVideoTracks()[0].getSettings().deviceId);
                            }).catch((error) => {
                                toastr.error('Please allow camera access');
                            });
                    
                        navigator.mediaDevices.getUserMedia({ audio: true })
                            .then((stream) => {
                                @this.set('microphoneId', stream.getAudioTracks()[0].getSettings().deviceId);
                            }).catch((error) => {
                                toastr.error('Please allow microphone access');
                            });       
                    }
                });

                document.getElementById('chooseCamera').addEventListener('change', function (event) {
                    if (navigator.getUserMedia) {
                        navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: event.target.value } } })
                            .then((stream) => {
                                document.getElementById('camera').srcObject = stream;
                            });
                    }
                });
            });

            const chat = document.getElementById('chat');
            chat.scroll({
                top: chat.scrollHeight,
                behavior: 'smooth'
            });

            window.addEventListener('new-chat', event => {
                setTimeout(() => {
                    chat.scroll({
                        top: chat.scrollHeight,
                        behavior: 'smooth'
                    });
                }, 50);
            });
        });
    </script>
    @vite('resources/js/hero-swiper.js')
@endsection
