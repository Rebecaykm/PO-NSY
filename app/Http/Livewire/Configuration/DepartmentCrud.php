<?php

namespace App\Http\Livewire\Configuration;

use App\Models\Departament;
use App\Models\Department;
use Livewire\Component;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentCrud extends Component
{

    public $search, $selectedStatus, $selectedOrderBy = 'CODE', $selectedOrder = 'ASC', $cadena;
    public $selectedDepartment, $mode, $code, $name, $description, $status, $perPage = 10, $page = 1;
    public $departmentId, $lengh_departaments=0;
    public $showSaveModal = true, $showConfirmSaveModal = true, $showConfirmDeleteModal = true;
    public $close = true, $open = false;
    public $confirmingItemAdd;


    public function render()
    {
        $query = Department::orderBy($this->selectedOrderBy,$this->selectedOrder);

        if ($this->search) {
            $query->where('CODE', 'like', '%' . $this->search . '%')
                ->orWhere('Name', 'like', '%' . $this->search . '%')
                ->orWhere('Description', 'like', '%' . $this->search . '%');
        }
        if ($this->selectedStatus){
            $query->where('Status', $this->selectedStatus);
        }
        $departaments = $query->paginate($this->perPage, ['*'], 'page', $this->page);
        $this->lengh_departaments = $departaments->total() ;
        return view('livewire.configuration.department-crud', compact('departaments'));
    }

    public function subPage()
    {
        if($this->page>1){
            $this->page = $this->page-1;
        }
    }

    public function addPage()
    {
        if($this->page<($this->lengh_departaments/$this->perPage)){
            $this->page = $this->page+1;
        }
    }
    public function resertPage()
    {
        $this->page = 1;
        $this->render();
    }

    public function selectDepartment($departmentId)
    {
        $this->selectedDepartment = Department::find($departmentId);
    }

    public function selectOrderFlag($cadena)
    {
        $this->selectedOrderBy = $cadena;
        if($this->selectedOrder === 'ASC')
            $this->selectedOrder = 'DESC';
        else
            $this->selectedOrder = 'ASC';
    }

    public function create()
    {
        $this->resetInputFields();
        $this->mode = 'create';
        $this->selectedDepartment = null;
        $this->showSaveModal = $this->open;
    }


    public function edit()
    {
        if ($this->selectedDepartment) {
            $this->mode = 'edit';
            $this->showSaveModal = $this->open;
            $this->code = $this->selectedDepartment->CODE;
            $this->name = $this->selectedDepartment->Name;
            $this->description = $this->selectedDepartment->Description;
            $this->status = $this->selectedDepartment->Status;
        }
    }

    public function save()
    {
        if ($this->mode === 'create') {
            $validatedData = $this->validate([
                'name' => 'required',
                'description' => 'nullable',
            ]);
            $countRows = Department::count();
            // Rellenar con ceros a la izquierda para obtener una cadena de 8 caracteres
            $code = 'DE' . str_pad($countRows, 4, '0', STR_PAD_LEFT);
            Department::create([
                'CODE' => $code,
                'Name' => $validatedData['name'],
                'Description' => $validatedData['description'],
                'Status' => true,
            ]);
            session()->flash('message', 'Registro añadido exitosamente');
        } elseif ($this->mode === 'edit') {
            $validatedData = $this->validate([
                'name' => 'required',
                'description' => 'nullable',
                'status' => 'required'
            ]);
            $this->selectedDepartment->update([
                'Name' => $validatedData['name'],
                'Description' => $validatedData['description'],
                'Status' => $validatedData['status'],
            ]);
            session()->flash('message', 'Registro editado exitosamente');
        }
        $this->closeModal();
    }
    public function confirmDelete()
    {
        if ($this->selectedDepartment) {
            $this->showConfirmDeleteModal = $this->open;
        }
    }

    public function delete()
    {
        if ($this->selectedDepartment) {
            $this->selectedDepartment->delete();
            $this->selectedDepartment = null;
            $this->closeModal();
            session()->flash('message', 'Registro eliminado exitosamente');
        }
    }
    public function closeModal(){
        $this->showConfirmSaveModal = $this->close;
        $this->showSaveModal = $this->close;
        $this->showConfirmDeleteModal = $this->close;
    }
    private function resetInputFields()
    {
        $this->code = '';
        $this->name = '';
        $this->description = '';
        $this->status = '';
    }
    public function clearFilters()
    {
        $this->selectedStatus = null;
        $this->search = null;
        $this->selectedDepartment = null;
        $this->mode = "create";
        $this->closeModal();
    }

    // public function generatePDF()
    // {
    //     try {
    //         $pdf = PDF::loadView('Process.Inventory.pdf', ['itemsDetails' => $itemsDetails]);

    //         // Nombre del PDF basado en el nombre del almacén y la fecha actual
    //         $pdfName = 'Inventario_' . $warehouse->Name . now()->format('_Y-m-d_H:i:s') . '.pdf';

    //         // Usar "stream" para ver el PDF en el navegador o "download" para forzar la descarga
    //         return $pdf->stream($pdfName);
    //     } catch (\Exception $e) {
    //         // Manejar errores en la generación del PDF
    //         return response()->json(['error' => 'Error generando el PDF. Detalles: ' . $e->getMessage()], 500);
    //     }
    // }

    // public function exportReport()
    // {
    //     $query = Departament::orderBy($this->selectedOrderBy,$this->selectedOrder);

    //     if ($this->search) {
    //         $query->where('CODE', 'like', '%' . $this->search . '%')
    //             ->orWhere('Name', 'like', '%' . $this->search . '%')
    //             ->orWhere('Description', 'like', '%' . $this->search . '%');
    //     }
    //     if ($this->selectedStatus){
    //         $query->where('Status', $this->selectedStatus);
    //     }
    //     $departaments = $query->get();

    //     $name = 'ListaDepartamentos_' . now()->format('_Y-m-d_H:i:s') . '.xlsx';
    //     // Llamar al exportador y generar el archivo Excel
    //     return Excel::download(new DepartmentExport($departaments), $name);
    // }

}
