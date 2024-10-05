@php
    $user = \App\Models\User::find($value);
    $email = $user->email;
@endphp

<button class="btn w-full btn-orange-gradient !text-black mt-4" onclick="location.href='mailto:{{ $email }}';">Hubungi</button>