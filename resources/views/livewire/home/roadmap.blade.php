@section('title')
    Roadmap
@endsection

<div class="drawer-content-container">
    <section class="w-full flex justify-center mb-4">
        <livewire:components.choose-position :showResetPosition="true" />
    </section>

    <h2 class="col-span-1 md:col-span-2 text-2xl font-bold">Roadmap</h2>

    <section class="flex gap-4 mt-4 flex-col sm:flex-row">
        @if(!$useJson)
            <div class="shadow bg-base-100 rounded-xl flex justify-center items-center w-full">            
                <div class="flex items-center justify-center w-full h-full pop-anim">
                    <object class="w-full min-h-screen rounded-xl" data="{{ $roadmap }}#toolbar=0&navpanes=0"></object>
                </div> 
            </div>
        @endif

        @if($useJson)
            <ul role="list" class="m-8 w-full">
                @foreach($json as $id => $item)
                    <li class="group relative flex flex-col pb-8 pl-7 last:pb-0">
                        <div class="absolute bottom-0 left-[calc(0.25rem-0.5px)] top-0 w-px bg-white/10 group-first:top-3"></div>
                        <div class="absolute left-0 top-2 h-2 w-2 rounded-full border border-sky-300 bg-zinc-950"></div>
                        <label class="collapse collapse-arrow bg-base-200">
                            <input type="radio" name="roadmap" {{ $loop->first ? 'checked="checked"' : '' }}>
                            <div class="collapse-title text-xl font-medium text-sky-500">{{ $item['title'] ?? '' }}</div>
                            <div class="collapse-content flex flex-col">
                                <h3 class="mt-2 text-sm/6">{{ Illuminate\Mail\Markdown::parse($item['description'] ?? '') }}</h3>
                                @if($item['links'] !== [])
                                    <p class="mt-2 text-sm/6 text-zinc-400">Resources</p>
                                    <div class="flex flex-col gap-1">
                                        @foreach($item['links'] as $resource)
                                            <span class="flex flex-row items-center gap-2">
                                                <i class="fa-solid fa-angle-right"></i>
                                                <a href="{{ $resource['url'] }}" class="flex flex-row items-center text-sky-500 hover:text-sky-300">{{ $resource['title'] }} <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-external-link w-4 h-4 ml-1 flex-shrink-0"><path d="M15 3h6v6"></path><path d="M10 14 21 3"></path><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path></svg></a>
                                                <span class="ml-2 text-xs text-gray-500 bg-gray-200 px-2 py-1 rounded">{{ $resource['type'] }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                                <button class="btn btn-orange-gradient normal-case text-black m-4" wire:click="generateQuiz('{{$id}}')">
                                    <span wire:loading.remove wire:target="generateQuiz">
                                        Test your knowledge on this topic!
                                    </span>
                    
                                    <span class="loading loading-spinner" wire:loading wire:target="generateQuiz"></span>
                                </button>
                            </div>
                        </label>
                        
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <!-- The button to open modal -->
    <label id="roadmap_quiz_label" for="roadmap_quiz" class="btn hidden">open modal</label>

    <!-- Put this part before </body> tag -->
    <input type="checkbox" id="roadmap_quiz" class="modal-toggle" />
    <div class="modal" role="dialog">
        <div class="modal-box !w-[75svw] !max-w-full">
            <h3 class="text-lg font-bold">{{ $quiz['title'] ?? '' }}</h3>
            <p class="py-4">{{ $quiz['question'] ?? '' }}</p>
            <div class="grid grid-rows-4 gap-4">
                @foreach($quiz['choices'] ?? [] as $no => $option)
                    @php
                        $isRightAnswer = $quiz['answer'] == md5($quiz['choices'][$no] . base64_decode(substr(env('APP_KEY'), 7)));
                    @endphp
                    <label class="label w-full !h-auto cursor-pointer p-4 rounded-xl input input-bordered input-checkbox gap-2">
                        <span class="label-text p-2 text-sm font-light">{{ $option ?? '' }}{{ $isRightAnswer ? '.' : '' }}</span>
                        <input type="radio" name="answer-{{ $quiz['id'] }}" class="radio" wire:click="choseAnswer('{{ $loop->index }}')" value="{{ $no }}" />
                    </label>
                @endforeach
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('openQuiz', () => {
                document.getElementById('roadmap_quiz_label').click();
            });

            Livewire.on('rightAnswer', () => {
                document.getElementById('roadmap_quiz_label').click();
                Swal.fire({
                    title: 'Correct!',
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    html: `<h1 class="text-2xl font-bold text-orange-gradient">+5 Exp</h1>`,
                });
            });

            Livewire.on('wrongAnswer', () => {
                document.getElementById('roadmap_quiz_label').click();
                Swal.fire({
                    title: 'Incorrect!',
                    icon: 'error',
                    timer: 2000,
                    timerProgressBar: true,
                    html: `<h1 class="text-2xl font-bold text-sky-300">Don't Give Up!</h1>`,
                });
            });
        });
    </script>
@endsection
