@section('title')
    Roadmap
@endsection

<div class="drawer-content-container">
    <section class="w-full flex justify-center mb-4">
        <livewire:components.choose-position :showResetPosition="true" />
    </section>

    <h2 class="col-span-1 md:col-span-2 text-2xl font-bold">Roadmap</h2>

    <section class="flex gap-4 mt-4 flex-col sm:flex-row">
        <div class="shadow bg-base-100 rounded-xl flex justify-center items-center w-full">            
            <div class="flex items-center justify-center w-full h-full pop-anim">
                <object class="w-full min-h-screen rounded-xl" data="{{ $roadmap }}#toolbar=0&navpanes=0"></object>
            </div> 
        </div>
    </section>
</div>

@section('scripts')
    <script></script>
@endsection
