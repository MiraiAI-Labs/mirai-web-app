@section('title')
Ganti Password
@endsection

<div class="drawer-content-container">
    <form class="w-full h-full grid grid-cols-2 gap-4" wire:submit.prevent="submit">
        <h3 class="col-span-2 text-2xl font-bold">Ganti Kata Sandi</h3>
        <div class="container shadow bg-base-100 grid grid-cols-1 gap-4 md:col-span-1 col-span-2 rounded-xl p-6">
            <label class="col-span-1 md:col-span-1 form-control w-full">
                <div class="label">
                    <span class="label-text">Kata Sandi Saat Ini</span>
                </div>
                <input type="password" placeholder="Kata Sandi Saat Ini" class="input input-bordered border-2 w-full @error('current_password') input-error @enderror" wire:model.live="current_password" />
                @error('current_password')
                <div class="text-error mt-1">{{ $message }}</div>
                @enderror
            </label>
            <label class="col-span-1 md:col-span-1 form-control w-full">
                <div class="label">
                    <span class="label-text">Kata Sandi Baru</span>
                </div>
                <input type="password" placeholder="Kata Sandi Baru" class="input input-bordered border-2 w-full @error('password') input-error @enderror" wire:model.live="password" />
                @error('password')
                <div class="text-error mt-1">{{ $message }}</div>
                @enderror
            </label>
            <label class="col-span-1 md:col-span-1 form-control w-full">
                <input type="password" placeholder="Konfirmasi Kata Sandi Baru" class="input input-bordered border-2 w-full @error('password_confirmation') input-error @enderror" wire:model.live="password_confirmation" />
                @error('password_confirmation')
                <div class="text-error mt-1">{{ $message }}</div>
                @enderror
            </label>
            <button class="col-span-1 btn btn-block btn-neutral">
                @if($isLoading ?? false)
                <span class="loading loading-spinner"></span>
                @else
                Ganti Password
                @endif
            </button>
        </div>
    </form>
</div>