<?php

namespace App\Livewire\Components;

use App\Livewire\BaseController;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use App\Traits\ToastDispatchable;

class ChoosePosition extends BaseController
{
    use ToastDispatchable;

    public Collection $positions;
    public Collection $choosablePositions;
    public SupportCollection $recommendations;

    public string $textPosition = '';
    public int $selectedPosition = 0;

    public bool $showRecommendations = false;
    public bool $showResetPosition = false;
    public bool $home = false;
    public string $class = '';

    public $currentRouteName;
    public $middlewares;

    public $landingPage = false;

    public function mount()
    {
        $this->positions = Position::all();

        $this->choosablePositions = $this->positions;

        $this->recommendations = $this->positions->random(5);

        if (!$this->landingPage) {
            $user = User::find(auth()->id());
            $this->selectedPosition = $user->position_id ?? 0;
            $this->textPosition = ($this->selectedPosition !== 0) ? $user->position->name : '';
        }

        $this->currentRouteName = request()->route()->getName();
        $this->middlewares = request()->route()->middleware();
    }

    public function search($search)
    {
        $this->choosablePositions = $this->positions->filter(function ($position) use ($search) {
            return strpos(strtolower($position->name), strtolower($search)) !== false;
        });
    }

    public function updatedSelectedPosition()
    {
        if ($this->landingPage)
            return;

        $user = User::find(auth()->id());

        if ($this->selectedPosition !== 0 && Position::find($this->selectedPosition) === null) {
            $this->selectedPosition = 0;
            $this->textPosition = '';

            $this->toastError("Invalid position selected");
            return;
        }

        $user->position_id = ($this->selectedPosition !== 0) ? $this->selectedPosition : null;
        $user->save();

        $this->toastSuccess("Position updated successfully");
        $this->dispatch('refresh');

        if ($user->position_id === null && in_array('App\Http\Middleware\PositionChosen', $this->middlewares)) {
            return redirect()->route('home');
        }
    }

    public function render()
    {
        return view('livewire.components.choose-position');
    }
}
