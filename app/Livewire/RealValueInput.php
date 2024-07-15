<?php

namespace App\Livewire;

use App\Models\Grade\Value;
use Livewire\Component;

class RealValueInput extends Component
{
    public $criteriaId;
    public $personId;
    public $realValue;

    public function mount($criteriaId, $personId)
    {
        $this->criteriaId = $criteriaId;
        $this->personId = $personId;
        $value = Value::where('criteria_id', $criteriaId)->where('person_id', $personId)->first();

        if ($value) {
            $this->realValue = $value->real_value;
        } else {
            $this->realValue = '';
        }
    }

    public function saveRealValue()
    {
        $this->validate([
            'realValue' => 'numeric',
        ]);

        $value = Value::firstOrNew(['criteria_id' => $this->criteriaId, 'person_id' => $this->personId]);
        $value->real_value = $this->realValue;
        $value->save();
    }

    public function render()
    {
        return view('livewire.real-value-input');
    }
}
