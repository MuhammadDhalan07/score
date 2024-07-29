<?php

namespace App\Livewire;

use App\Models\Grade\Athlete;
use App\Models\Grade\Value;
use Livewire\Component;

class RealValueInput extends Component
{
    public $criteriaId;
    public $realValue;
    public $personId;

    public function mount($criteriaId, $personId)
    {
        $this->criteriaId = $criteriaId;
        $this->personId = $personId;
        $this->loadRealValue();
    }

    public function updatedPersonId()
    {
        $this->loadRealValue();
    }

    public function loadRealValue()
    {
        $value = Value::where('person_id', $this->personId)
                        ->where('criteria_id', $this->criteriaId)
                        ->first();

        if ($value) {
            $this->realValue = $value->real_value;
        }
    }

    public function saveRealValue()
    {
        $this->validate([
            'realValue' => 'numeric',
        ]);

        $value = Value::firstOrNew(
            ['criteria_id' => $this->criteriaId, 'person_id' => $this->personId]
        );
        $value->real_value = $this->realValue;
        $value->save();
    }

    public function render()
    {
        return view('livewire.real-value-input');
    }
}



// <?php 

// namespace App\Livewire;

// use App\Models\Grade\Athlete;
// use App\Models\Grade\Value;
// use Livewire\Component;

// class RealValueInput extends Component
// {
//     public $criteriaId;
//     public $realValue;
//     public $personId;

//     public function mount($criteriaId, $personId)
//     {
//         $this->criteriaId = $criteriaId;
//         $this->personId = $personId;
//         $values = Value::where('person_id', $this->personId)->where('criteria_id', $this->criteriaId)->get();

//         $this->realValue;

//         foreach ($values as $value) {
//             $this->realValue = $value->real_value;
//         }
//     }

//     public function saveRealValue()
//     {
//         $this->validate([
//             'realValue' => 'numeric',
//         ]);

//         $value = Value::firstOrNew(
//             ['criteria_id' => $this->criteriaId, 'person_id' => $this->personId]
//         );
//         $value->real_value = $this->realValue;
//         $value->save();
//     }

//     public function render()
//     {
//         return view('livewire.real-value-input');
//     }
// }
