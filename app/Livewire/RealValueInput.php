<?php
namespace App\Livewire;

use App\Models\Grade\Value;
use Livewire\Component;

class RealValueInput extends Component
{
    public $criteriaId;
    public $realValue;

    public function mount($criteriaId)
    {
        $this->criteriaId = $criteriaId;
        $value = Value::where('criteria_id', $criteriaId)->first();

        if ($value) {
            $this->realValue = $value->real_value;
        } else {
            $this->realValue = '';
        }
    }

    public function updatedRealValue()
    {
        $value = Value::firstOrNew(['criteria_id' => $this->criteriaId]);
        $value->real_value = $this->realValue;
        $value->save();
    }

    public function render()
    {
        return view('livewire.real-value-input');
    }
}
