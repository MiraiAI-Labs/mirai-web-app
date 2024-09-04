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
        <div x-show="started" class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-base-100 rounded-xl p-6"><span x-text="tegap ? 'Sudah' : 'Belum'"></span> Tegap</div>
            <div class="bg-base-100 rounded-xl p-6"><span x-text="facingCamera ? 'Sudah' : 'Belum'"></span> Hadap Kamera</div>
            <div class="bg-base-100 rounded-xl p-6">Bahu <span x-text="shoulderShown ? 'Sudah' : 'Belum'"></span> Terlihat</div>
        </div>
        <div class="bg-base-100 rounded-xl flex justify-center items-center min-h-80 relative" x-show="started">
            <video id="camera" class="aspect-video w-full flipped" autoplay></video>
            <canvas id="canvas" width="480px" height="480px" x-show="mediapipeDebug"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils@0.1/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils@0.1/control_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils@0.2/drawing_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/holistic@0.1/holistic.js" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('alpine:init', () => {      
            Alpine.data('interview', () => ({
                started: @entangle('started'),
                muted: @entangle('muted'),
                disabled: @entangle('disabled'),
                deviceId: @entangle('microphoneId'),
                loading: @entangle('loading'),
                mediapipeDebug: false,
                facingCamera: false,
                tegap: false,
                shoulderShown: false,
                mediaRecorder: null,
                tts_service: null,
                start() {
                    let t = this;
                    this.started = true;
                    this.loading = true;
                    this.disabled = true;

                    this.scroll();

                    const video = document.getElementById('camera');
                    const canvas = document.getElementById('canvas');
                    const canvasCtx = canvas.getContext('2d');

                    function removeElements(landmarks, elements) {
                        for (const element of elements) {
                            delete landmarks[element];
                        }
                    }

                    function removeLandmarks(results) {
                        if (results.poseLandmarks) {
                            removeElements(
                                results.poseLandmarks,
                                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 15, 16, 17, 18, 19, 20, 21, 22]);
                        }
                    }

                    function connect(ctx, connectors) {
                        const canvas = ctx.canvas;
                        for (const connector of connectors) {
                            const from = connector[0];
                            const to = connector[1];
                            if (from && to) {
                                if (from.visibility && to.visibility &&
                                    (from.visibility < 0.1 || to.visibility < 0.1)) {
                                    continue;
                                }
                                ctx.beginPath();
                                ctx.moveTo(from.x * canvas.width, from.y * canvas.height);
                                ctx.lineTo(to.x * canvas.width, to.y * canvas.height);
                                ctx.stroke();
                            }
                        }
                    }

                    function isTegap(leftShoulder, rightShoulder)
                    {
                        const deltaX = rightShoulder.x - leftShoulder.x;
                        const deltaY = rightShoulder.y - leftShoulder.y;
                        const shoulderAngle = Math.atan2(deltaY, deltaX) * (180 / Math.PI);

                        return shoulderAngle > 175 || shoulderAngle < -175;
                    }

                    function isShoulderShown(leftShoulder, rightShoulder)
                    {
                        return leftShoulder.visibility > 0.7 && rightShoulder.visibility > 0.7;
                    }

                    function isFacingCamera(nose, left_eye, right_eye, left_ear, right_ear)
                    {
                        const eyeMidpointX = (left_eye.x + right_eye.x) / 2;
                        const eyeMidpointY = (left_eye.y + right_eye.y) / 2;
                        const leftEarToNoseX = nose.x - left_ear.x;
                        const rightEarToNoseX = right_ear.x - nose.x;
                        const angle = Math.atan2(leftEarToNoseX - rightEarToNoseX, eyeMidpointY - nose.y) * (180 / Math.PI);

                        return angle > 130 && angle < 150;
                    }

                    function onResultsHolistic(results) {
                        removeLandmarks(results);

                        if(results.poseLandmarks)
                        {
                            t.tegap = isTegap(results.poseLandmarks[11], results.poseLandmarks[12]);
                            t.shoulderShown = isShoulderShown(results.poseLandmarks[11], results.poseLandmarks[12]);
                        }

                        if(results.faceLandmarks)
                            t.facingCamera = isFacingCamera(results.faceLandmarks[0], results.faceLandmarks[2], results.faceLandmarks[5], results.faceLandmarks[7], results.faceLandmarks[8]);

                        if(t.mediapipeDebug)
                        {
                            canvasCtx.save();
                            canvasCtx.clearRect(0, 0, canvas.width, canvas.height);
                            canvasCtx.drawImage(
                                results.image, 0, 0, canvas.width, canvas.height);
                            canvasCtx.lineWidth = 5;
                            if (results.poseLandmarks) {
                                if (results.rightHandLandmarks) {
                                canvasCtx.strokeStyle = '#00FF00';
                                connect(canvasCtx, [[
                                            results.poseLandmarks[POSE_LANDMARKS.RIGHT_ELBOW],
                                            results.rightHandLandmarks[0]
                                        ]]);
                                }
                                if (results.leftHandLandmarks) {
                                    canvasCtx.strokeStyle = '#FF0000';
                                    connect(canvasCtx, [[
                                            results.poseLandmarks[POSE_LANDMARKS.LEFT_ELBOW],
                                            results.leftHandLandmarks[0]
                                            ]]);
                                }
                            }
                            drawConnectors(
                                canvasCtx, results.poseLandmarks, POSE_CONNECTIONS,
                                {color: '#00FF00'});
                            drawLandmarks(
                                canvasCtx, results.poseLandmarks,
                                {color: '#00FF00', fillColor: '#FF0000'});
                            drawConnectors(
                                canvasCtx, results.rightHandLandmarks, HAND_CONNECTIONS,
                                {color: '#00CC00'});
                            drawLandmarks(
                                canvasCtx, results.rightHandLandmarks, {
                                    color: '#00FF00',
                                    fillColor: '#FF0000',
                                    lineWidth: 2,
                                    radius: (data) => {
                                    return lerp(data.from.z, -0.15, .1, 10, 1);
                                    }
                                });
                            drawConnectors(
                                canvasCtx, results.leftHandLandmarks, HAND_CONNECTIONS,
                                {color: '#CC0000'});
                            drawLandmarks(
                                canvasCtx, results.leftHandLandmarks, {
                                    color: '#FF0000',
                                    fillColor: '#00FF00',
                                    lineWidth: 2,
                                    radius: (data) => {
                                    return lerp(data.from.z, -0.15, .1, 10, 1);
                                    }
                                });
                            drawConnectors(
                                canvasCtx, results.faceLandmarks, FACEMESH_TESSELATION,
                                {color: '#C0C0C070', lineWidth: 1});
                            drawConnectors(
                                canvasCtx, results.faceLandmarks, FACEMESH_RIGHT_EYE,
                                {color: '#FF3030'});
                            drawConnectors(
                                canvasCtx, results.faceLandmarks, FACEMESH_RIGHT_EYEBROW,
                                {color: '#FF3030'});
                            drawConnectors(
                                canvasCtx, results.faceLandmarks, FACEMESH_LEFT_EYE,
                                {color: '#30FF30'});
                            drawConnectors(
                                canvasCtx, results.faceLandmarks, FACEMESH_LEFT_EYEBROW,
                                {color: '#30FF30'});
                            drawConnectors(
                                canvasCtx, results.faceLandmarks, FACEMESH_FACE_OVAL,
                                {color: '#E0E0E0'});
                            drawConnectors(
                                canvasCtx, results.faceLandmarks, FACEMESH_LIPS,
                                {color: '#E0E0E0'});
    
                            canvasCtx.restore();
                        }
                    }

                    const options = {
                        selfieMode: true,
                        modelComplexity: 1,
                        smoothLandmarks: true,
                        minDetectionConfidence: 0.5,
                        minTrackingConfidence: 0.5
                    };

                    const holistic = new Holistic({locateFile: (file) => {
                        return `https://cdn.jsdelivr.net/npm/@mediapipe/holistic@0.1/${file}`;
                    }});
                    holistic.onResults(onResultsHolistic);
                    // holistic.setOptions(options);

                    const camera = new Camera(video, {
                        onFrame: async () => {
                            await holistic.send({image: video});
                        },
                        width: 480,
                        height: 480
                    });
                    camera.start();

                    @this.start();
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
                        this.disabled = true;
                        
                        @this.dispatch('new-chat');

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
                send(blob) {
                    @this.$upload('audioBlob', blob);
                }
            }))
        })

        document.addEventListener('DOMContentLoaded', function () {

            function scrollChat()
            {
                const chat = document.getElementById('chat');
                chat.scroll({
                    top: chat.scrollHeight,
                    behavior: 'smooth'
                });
            }
                
            @this.on('play-audio', (params) => {
                @this.set('disabled', true);
                @this.set('loading', true);
                const { audioUrl, transcription } = params[0];

                const audioElement = new Audio(audioUrl);

                audioElement.onended = () => {
                    @this.addChat(transcription, 'Interviewer', 'received');
                    @this.set('disabled', false);
                    @this.set('loading', false);
                    @this.dispatch('new-chat');
                };

                audioElement.play();
            })

            window.addEventListener('new-chat', event => {
                setTimeout(scrollChat, 50);
            });

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
        });
    </script>
    @vite('resources/js/hero-swiper.js')
@endsection
