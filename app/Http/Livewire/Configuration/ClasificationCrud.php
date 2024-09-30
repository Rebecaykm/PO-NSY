<?php

namespace App\Http\Livewire\Configuration;

use App\Models\Category;
use App\Models\Classification;
use Livewire\Component;
use Illuminate\Support\Str;

class ClassificationCrud extends Component
{
    public $search, $selectedStatus, $selectedOrderBy = 'code', $selectedOrder = 'ASC', $cadena;
    public $selectedClassification, $selectedCategory_id, $mode, $code, $name, $description, $Category_id,  $status, $perPage = 10, $page = 1;
    public $ClassificationId, $lengh_classification=0;
    public $showSaveModal = true, $showConfirmSaveModal = true, $showConfirmDeleteModal = true;
    public $close = true, $open = false;
    public $confirmingItemAdd;


    public function render()
    {
        $categories = Category::where('status',true)->orderBy('name','asc')->get();
        $query = Classification::orderBy($this->selectedOrderBy,$this->selectedOrder);

        if ($this->search) {
            $query->where('code', 'like', '%' . $this->search . '%')
                ->orWhere('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        }
        if ($this->selectedStatus){
            $query->where('status', $this->selectedStatus);
        }
        if ($this->selectedCategory_id){
            $query->where('Category_id', $this->selectedCategory_id);
        }
        $classifications = $query->paginate($this->perPage, ['*'], 'page', $this->page);
        $this->lengh_classification = $classifications->total() ;
        return view('livewire.configuration.clasification-crud', compact('categories','classifications'));
    }

    public function subPage()
    {
        if($this->page>1){
            $this->page = $this->page-1;
        }
    }

    public function addPage()
    {
        if($this->page<($this->lengh_classification/$this->perPage)){
            $this->page = $this->page+1;
        }
    }
    public function resertPage()
    {
        $this->page = 1;
        $this->render();
    }

    public function selectClasification($ClassificationId)
    {
        $this->selectedClassification = Classification::find($ClassificationId);
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
        $this->selectedClassification = null;
        $this->showSaveModal = $this->open;
    }


    public function edit()
    {
        if ($this->selectedClassification) {
            $this->mode = 'edit';
            $this->showSaveModal = $this->open;
            $this->code = $this->selectedClassification->code;
            $this->name = $this->selectedClassification->name;
            $this->description = $this->selectedClassification->description;
            $this->status = $this->selectedClassification->status;
            $this->Category_id = $this->selectedClassification->Category_id;
        }
    }

    public function save()
    {
        if ($this->mode === 'create') {
            $validatedData = $this->validate([
                'name' => 'required',
                'description' => 'nullable',
                'Category_id' => 'required'
            ]);
            $countRows = Classification::count();
            // Rellenar con ceros a la izquierda para obtener una cadena de 8 caracteres
            $code = 'CLS' . str_pad($countRows, 5, '0', STR_PAD_LEFT);
            Classification::create([
                'code' => $code,
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'status' => true,
                'Category_id' => $validatedData['Category_id'],

            ]);
            session()->flash('message', 'Registro añadido exitosamente');
        } elseif ($this->mode === 'edit') {
            $validatedData = $this->validate([
                'name' => 'required',
                'description' => 'nullable',
                'status' => 'required',
                'Category_id' => 'required'
            ]);
            $this->selectedClassification->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'status' => $validatedData['status'],
                'Category_id' => $validatedData['Category_id']
            ]);
            session()->flash('message', 'Registro editado exitosamente');
        }
        $this->closeModal();
    }
    // public function confirmDelete()
    // {
    //     if ($this->selectedClassification) {
    //         $this->showConfirmDeleteModal = $this->open;
    //     }
    // }

    // public function delete()
    // {
    //     if ($this->selectedClassification) {
    //         $this->selectedClassification->delete();
    //         $this->selectedClassification = null;
    //         $this->closeModal();
    //         session()->flash('message', 'Registro eliminado exitosamente');
    //     }
    // }
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
        $this->Category_id = '';
        $this->selectedCategory_id = '';
    }
    public function clearFilters()
    {
        $this->selectedStatus = null;
        $this->search = null;
        $this->selectedClassification = null;
        $this->mode = "create";
        $this->closeModal();
    }
}
