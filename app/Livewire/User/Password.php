<?php

namespace App\Livewire\User;

use App\Livewire\BaseController;
use App\Models\User;
use Closure;
use App\Traits\ToastDispatchable;

class Password extends BaseController
{
    use ToastDispatchable;

    private User $user;

    protected $rules = [
        'current_password' => ['required'],
        'password' => 'required|min:8',
        'password_confirmation' => 'required_with:password|same:password|min:8',
    ];

    public bool $isLoading = false;
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function boot()
    {
        $user = auth()->user();

        $this->user = $user;

        $this->rules['current_password'][] = function (string $attribute, mixed $value, Closure $fail) use ($user) {
            if (!auth()->attempt(['email' => $user->email, 'password' => $value])) {
                $fail(__('validation.password.mismatch'));
            }
        };
    }

    public function submit()
    {
        $this->validate();

        $this->isLoading = true;

        $this->user->update([
            'password' => bcrypt($this->password),
        ]);

        $this->isLoading = false;

        $this->toastSuccess(__('validation.password.updated'));

        $this->reset();
    }

    public function render()
    {
        return view('livewire.user.password')->extends('layouts.home.base', ['activeTab' => 'account']);
    }
}
