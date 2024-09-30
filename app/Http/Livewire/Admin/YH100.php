<?php

namespace App\Http\Livewire\Admin;

use App\Models\YH100 as YH100md;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class YH100 extends Component
{
    public $search; //Variable filtra por palabra
    public $selectedObject, $Qty_Objects = 0; //Se almacena informacion de un registro
    public $selectedOrderBy = 'HRRQNO', $selectedOrder = 'ASC'; //Modo de ordenamiento de los datos
    public $close = true, $open = false, $mode = null; //Control para abrir modales
    public $showSaveModal = true, $showConfirmDeleteModal = true; //Control para abrir uno u otro modal
    public $HRRQNO = null, $HRORD = null, $HRLINE = null, $HRVEND = null, $HRWHSE = null, $HRSHIP = null, $HRBUYC = null, $HRCCOD = null, $HRCDES = null;
    public $HRQORD = null, $HRDDTE = null, $HRECST = null, $HRUM = null, $HRITXC = null, $HROPRF = null, $HRCDT = null, $HRCTM = null, $HRCBY = null;//Variables que almacenan valores temporales
    public function render()
    {
        $query = YH100md::query()
        //->where('PBTYP','B')
        ->orderBy($this->selectedOrderBy,$this->selectedOrder);

        if ($this->search) {
            $query->where('HRRQNO', 'like', '%' . $this->search . '%')//Numero de requisición
                ->orWhere('HRDDTE', 'like', '%' . $this->search . '%')//Numero de Purechase Order
                ->orWhere('HRCDES', 'like', '%' . $this->search . '%'); //Item Description
        }

        $YH100 = $query->get();

        return view('livewire.admin.y-h100',compact('YH100'));
    }
    public function selectObject($objHRRQID,$objHRRLIN,$objHRCDT,$objHRCTM)
    {
        $this->selectedObject = YH100md::where('HRRQID', $objHRRQID)
        ->where('HRRLIN', $objHRRLIN)
        ->where('HRCDT', $objHRCDT)
        ->where('HRCTM', $objHRCTM)
        ->first();

        $this->HRRQNO = $this->selectedObject->HRRQNO;
        $this->HRORD = $this->selectedObject->HRORD;
        $this->HRLINE = $this->selectedObject->HRLINE;
        $this->HRVEND = $this->selectedObject->HRVEND;
        $this->HRWHSE = $this->selectedObject->HRWHSE;
        $this->HRSHIP = $this->selectedObject->HRSHIP;
        $this->HRBUYC = $this->selectedObject->HRBUYC;
        $this->HRCCOD = $this->selectedObject->HRCCOD;
        $this->HRCDES = $this->selectedObject->HRCDES;
        $this->HRQORD = $this->selectedObject->HRQORD;
        $this->HRDDTE = $this->selectedObject->HRDDTE;
        $this->HRECST = $this->selectedObject->HRECST;
        $this->HRUM = $this->selectedObject->HRUM;
        $this->HRITXC = $this->selectedObject->HRITXC;
        $this->HROPRF = $this->selectedObject->HROPRF;
        $this->HRCDT = $this->selectedObject->HRCDT;
        $this->HRCTM = $this->selectedObject->HRCTM;
        $this->HRCBY = $this->selectedObject->HRCBY;
    }
    // This funciton define the order of fields
    public function selectOrderFlag($field)
    {
        $this->selectedOrderBy = $field;
        if($this->selectedOrder === 'ASC')
            $this->selectedOrder = 'DESC';
        else
            $this->selectedOrder = 'ASC';
    }
    //Funciton open modal create
    public function create()
    {
        $this->resetInputFields();
        $this->mode = 'create';
        $this->selectedObject = null;
        $this->showSaveModal = $this->open;
    }
    //Funciton edit() define mode = 'edit', open modal SaveModal
    public function edit()
    {
        $this->selectedObject = YH100md::where('HRRQNO', $this->HRRQNO)
        ->where('HRLINE', $this->HRLINE)
        ->where('HRCDT', $this->HRCDT)
        ->where('HRCTM', $this->HRCTM)
        ->first();
        if ($this->selectedObject) {
            $this->mode = 'edit';
            $this->showSaveModal = $this->open;
        }
    }
    //Funcition save(), this functino create or update
    public function save()
    {
        if ($this->mode === 'create') {
            YH100md::create([
                'HRRQNO' => $this->HRRQNO,
                'HRORD' => $this->HRORD,
                'HRLINE' => $this->HRLINE,
                'HRVEND' => $this->HRVEND,
                'HRWHSE' => $this->HRWHSE,
                'HRSHIP' => $this->HRSHIP,
                'HRBUYC' => $this->HRBUYC,
                'HRCCOD' => $this->HRCCOD,
                'HRCDES' => $this->HRCDES,
                'HRQORD' => $this->HRQORD,
                'HRDDTE' => $this->HRDDTE,
                'HRECST' => $this->HRECST,
                'HRUM' => $this->HRUM,
                'HRITXC' => $this->HRITXC,
                'HROPRF' => $this->HROPRF,
                'HRCDT' => date("Ymd"),
                'HRCTM' => date("His"),
                'HRCBY' => 'LXSECOFR',
    ]);

        session()->flash('message', 'Registro añadido exitosamente');
        } elseif ($this->mode === 'edit') {

            $this->selectedObject = YH100::where('HRRQNO', $this->HRRQNO)
            ->where('HRLINE', $this->HRLINE)
            ->first();

            if ($this->selectedObject) {
                DB::connection('odbc-connection-lx834fu01')
                ->table('LX834FU01.YH100')
                ->where('HRRQNO', $this->selectedObject->HRRQNO)
                ->where('HRLINE', $this->selectedObject->HRLINE)
                ->where('HRCDT', $this->selectedObject->HRCDT)
                ->where('HRCTM', $this->selectedObject->HRCTM)
                ->update([
                    'HRRQNO' => $this->HRRQNO,
                    'HRORD' => $this->HRORD,
                    'HRLINE' => $this->HRLINE,
                    'HRVEND' => $this->HRVEND,
                    'HRWHSE' => $this->HRWHSE,
                    'HRSHIP' => $this->HRSHIP,
                    'HRBUYC' => $this->HRBUYC,
                    'HRCCOD' => $this->HRCCOD,
                    'HRCDES' => $this->HRCDES,
                    'HRQORD' => $this->HRQORD,
                    'HRDDTE' => $this->HRDDTE,
                    'HRECST' => $this->HRECST,
                    'HRUM' => $this->HRUM,
                    'HRITXC' => $this->HRITXC,
                    'HROPRF' => $this->HROPRF,
                    'HRCDT' => date("Ymd"),
                    'HRCTM' => date("His"),
                    'HRCBY' => 'LXSECOFR',
                ]);
                session()->flash('message', 'Registro editado exitosamente');
            }
            else
            session()->flash('message', 'Edición de registro fallido.');
        }
        $this->closeModal();
    }
    // Function confirmDelete(), this function display confirmDeleteModal modal
    public function confirmDelete()
    {
        if ($this->selectedObject) {
            $this->showConfirmDeleteModal = $this->open;
        }
    }
    // Funciton delete(), delete dataset
    public function delete()
    {
        if ($this->selectedObject) {
            $this->selectedObject = YH100md::where('HRRQNO', $this->HRRQNO)
            ->where('HRLINE', $this->HRLINE)
            ->where('HRCDT', $this->HRCDT)
            ->where('HRCTM', $this->HRCTM)
            ->first();

            if ($this->selectedObject) {
                DB::connection('odbc-connection-lx834f01')
                ->table('LX834FU01.YH100')
                ->where('HRRQNO', $this->HRRQNO)
                ->where('HRLINE', $this->HRLINE)
                ->where('HRCDT', $this->HRCDT)
                ->where('HRCTM', $this->HRCTM)
                ->delete();

                session()->flash('message', 'Registro eliminado exitosamente');
            }
            else
            {
                session()->flash('message', 'Fallo al eliminar el registro, vuelva a intentar. :C ');
            }
            $this->selectedObject = null;
            $this->closeModal();
        }
    }
    //Function closeModal(), close all modals
    public function closeModal(){
        $this->showSaveModal = $this->close;
        $this->showConfirmDeleteModal = $this->close;
    }
    private function resetInputFields(){
        $this->HRRQNO = '';
        $this->HRORD = '';
        $this->HRLINE = '';
        $this->HRVEND = '';
        $this->HRWHSE = '';
        $this->HRSHIP = '';
        $this->HRBUYC = '';
        $this->HRCCOD = '';
        $this->HRCDES = '';
        $this->HRQORD = '';
        $this->HRDDTE = '';
        $this->HRECST = '';
        $this->HRUM = '';
        $this->HRITXC = '';
        $this->HROPRF = '';
        $this->HRCDT = '';
        $this->HRCTM = '';
        $this->HRCBY = '';
    }

    public function clearFilters()
    {
        $this->search = null;
        $this->selectedObject = null;
        $this->mode = "create";
        $this->closeModal();
    }
}
