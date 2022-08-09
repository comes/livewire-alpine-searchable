<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class SelectComponent extends Component
{
    public $values = [0,2,4];

    public function getOptions()
    {
        return Cache::rememberForever('options', function () {
            return User::factory()
                ->count(20000)
                ->make()
                ->map(function ($user, $i) {
                    return [
                        'value' => $i,
                        'label' => "{$user->name}",
                    ];
                })->values();
        });
    }

    public function render()
    {
        return view('livewire.select-component', ['options' => $this->getOptions()]);
    }
}
