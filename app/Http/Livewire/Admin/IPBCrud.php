<?php

namespace App\Http\Livewire\Admin;

use App\Models\IPB;
use Livewire\Component;
use Illuminate\Support\Facades\DB;


class IPBCrud extends Component
{
    public $search; //Variable filtra por palabra
    public $selectedObject, $objectPBDTE, $objectPBTIM, $Qty_Objects = 0; //Se almacena informacion de un registro
    public $selectedOrderBy = 'PBPBC', $selectedOrder = 'ASC'; //Modo de ordenamiento de los datos
    public $close = true, $open = false, $mode = null; //Control para abrir modales
    public $showSaveModal = true, $showConfirmDeleteModal = true; //Control para abrir uno u otro modal
    public $PBPBC, $PBTYP, $PBDTE, $PBNAM, $PBTIM; //Variables que almacenan valores temporales
    public function render()
    {
        $query = IPB::query()
        //->where('PBTYP','B')
        ->orderBy($this->selectedOrderBy,$this->selectedOrder);

        if ($this->search) {
            $query->where('PBPBC', 'like', '%' . $this->search . '%')
                ->orWhere('PBFAC', 'like', '%' . $this->search . '%')
                ->orWhere('PBNAM', 'like', '%' . $this->search . '%')
                ->orWhere('PBAD1', 'like', '%' . $this->search . '%');
        }

        $IPB = $query->get();

        return view('livewire.admin.i-p-b-crud',['IPB' => $IPB]);
    }
    public function selectObject($objectPBTIM,$objectPBDTE)
    {
        $this->selectedObject = IPB::where('PBTIM', $objectPBTIM)
        ->where('PBDTE', $objectPBDTE)
        ->first();

        $this->PBTIM = $this->selectedObject->PBTIM;
        $this->PBDTE = $this->selectedObject->PBDTE;
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
        $this->selectedObject = IPB::where('PBTIM', $this->PBTIM)
        ->where('PBDTE', $this->PBDTE)
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
            IPB::create([
                'PBID' => 'PB',
                'PBPBC' => $this->PBPBC,
                'PBTYP' => 'B',
                'PBFAC' => '',
                'PBNAM' => $this->PBNAM,
                'PBAD1' => '',
                'PBAD2' => '',
                'PBAD3' => '',
                'PBSTE' => '',
                'PBCUN' => '',
                'PBPOST' => '',
                'PBPHON' => '',
                'PBEMAL' => '',
                'PBCSTC' => '',
                'PBUSR' => 'LXSECOFR',
                'PBDTE' => date("Ymd"),
                'PBTIM' => date("His"),
                'PBAD4' => '',
                'PBAD5' => '',
                'PBAD6' => '',
                'PBRGCD' => '',
            ]);

        session()->flash('message', 'Registro añadido exitosamente');
        } elseif ($this->mode === 'edit') {
            //$conn = odbc_connect("Driver={Client Access ODBC Driver (32-bit)};System=192.168.200.7;Database=LX834F02;", "LXSECOFR;", "LXSECOFR;");
            // $query = "INSERT INTO LX834F02.IPB (PBID, PBPBC, PBTYP, PBFAC, PBNAM, PBAD1, PBUSR) VALUES ('PB', '$this->PBPBC', '$this->PBTYP', '$this->PBFAC', '$this->PBNAM', '$this->PBAD1', '20240301', '103600')";
            // $result = odbc_exec($conn, $query);

            // $object = IPB::where('PBDTE', $this->PBDTE)
            // ->where('PBTIM', $this->PBTIM)
            // ->first();
            $this->selectedObject = IPB::where('PBTIM', $this->PBTIM)
            ->where('PBDTE', $this->PBDTE)
            ->first();

            if ($this->selectedObject) {
                DB::connection('odbc-connection-lx834f01')
                ->table('LX834F01.IPB')
                ->where('PBDTE', $this->selectedObject->PBDTE)
                ->where('PBTIM', $this->selectedObject->PBTIM)
                ->update([
                    'PBPBC' => $this->PBPBC,
                    'PBNAM' => $this->PBNAM,
                    'PBTYP' => 'B',
                    'PBUSR' => 'LXSECOFR',
                    'PBDTE' => date("Ymd"),
                    'PBTIM' => date("His"),
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
            $this->selectedObject = IPB::where('PBTIM', $this->PBTIM)
            ->where('PBDTE', $this->PBDTE)
            ->first();

            if ($this->selectedObject) {
                DB::connection('odbc-connection-lx834f1')
                ->table('LX834F01.IPB')
                ->where('PBDTE', $this->selectedObject->PBDTE)
                ->where('PBTIM', $this->selectedObject->PBTIM)
                ->update([
                    'PBID' => 'PZ',
                ]);

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
    //function resetInputFields(), reset variable values
    private function resetInputFields()
    {
        $this->PBPBC = '';
        $this->PBTYP = '';
        $this->PBNAM = '';
        $this->PBDTE = '';
        $this->PBTIM = '';
    }
    public function clearFilters()
    {
        $this->search = null;
        $this->selectedObject = null;
        $this->mode = "create";
        $this->closeModal();
    }
}
