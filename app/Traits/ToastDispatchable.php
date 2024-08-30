<?php

namespace App\Traits;

trait ToastDispatchable
{
    public function toast(string $message, string $type = 'success', string $title = ''): void
    {
        $this->dispatch("toast", [
            'type' => $type,
            'title' => $title,
            'text' => $message,
        ]);
    }

    public function toastError(string $message, string $title = ''): void
    {
        $this->toast($message, 'error', $title);
    }

    public function toastSuccess(string $message, string $title = ''): void
    {
        $this->toast($message, 'success', $title);
    }

    public function toastInfo(string $message, string $title = ''): void
    {
        $this->toast($message, 'info', $title);
    }

    public function toastWarning(string $message, string $title = ''): void
    {
        $this->toast($message, 'warning', $title);
    }
}
