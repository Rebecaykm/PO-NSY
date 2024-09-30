<?php

namespace App\Http\Livewire\Requisition;

use App\Models\QuoteLine;
use Livewire\Component;
use Carbon\Carbon;

class GeneratePurchaseOrder extends Component
{
    public $HRRQNO = null, $HRORD = null, $HRLINE = null, $HRVEND = null, $HRWHSE = null, $HRSHIP = null, $HRBUYC = null, $HRCCOD = null, $HRCDES = null;
    public $HRQORD = null, $HRDDTE = null, $HRECST = null, $HRUM = null, $HRITXC = null, $HROPRF = null, $HRCDT = null, $HRCTM = null, $HRCBY = null;
    public $RQ;

    public function getRQ($RQ_id){
        $this->RQ = QuoteLine::where('id',$RQ_id)->find();
    }
    public function render()
    {
        return view('livewire.requisition.generate-purchase-order');
    }

    public function createYH100(){
        $DueDate = Carbon::createFromFormat('Y-m-d', $RQ->dateRequired)->format('Ymd');
        $fechaActual = Carbon::now();
        $date = $fechaActual->format('Ymd');
        $time = $fechaActual->format('His');


        if($this->RQ->selectedQuote ==  1){
            $supplier = $this->RQ->Supplier1;
        }

        $this->RQ->update([
            'HRRQNO' => '',
            'HRORD' => '',
            'HRLINE' => '',
            'HRVEND' => $supplier,
            'HRWHSE' => $this->RQ->costCenter->name,
            'HRSHIP' => '',
            'HRBUYC' => '',
            'HRCCOD' => $this->RQ->quoteRequest->commodity->PCCOM,
            'HRCDES' => $this->RQ->name,
            'HRQORD' => $this->RQ->quantity,
            'HRDDTE' => $DueDate,
            'HRECST' => '',
            'HRUM'   => 'EA',
            'HRITXC' => '',
            'HROPRF' => '',
            'HRCDT'  => $date,
            'HRCTM'  => $time,
            'HRCBY'  => $this->RQ->quoteRequest->buyer->PBPBC,
        ]);
    }

    public function editYH100(){

    }

    public function deleteYH100(){

    }
}
