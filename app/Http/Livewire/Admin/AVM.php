<?php

namespace App\Http\Livewire\Admin;

use App\Models\AVM as ModelsAVM;
use Livewire\Component;

class AVM extends Component
{
    public $departments, $department_id, $code, $name, $description, $status, $mode;

    public function render()
    {
        $AVM = ModelsAVM::query()
        ->SELECT([
            'VNSTAT','VMID','VENDOR','VNDNAM'
        ])
        ->orderBy('VENDOR','DESC')
        ->get();
        return view('livewire.admin.a-v-m',['AVM' => $AVM]);
    }
} 
