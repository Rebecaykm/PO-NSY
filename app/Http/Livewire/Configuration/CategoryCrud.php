<?php

namespace App\Http\Livewire\Configuration;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;


class CategoryCrud extends Component
{

    public $search, $selectedStatus, $selectedOrderBy = 'code', $selectedOrder = 'ASC', $cadena;
    public $selectedCategory, $mode, $code, $name, $description, $status, $perPage = 10, $page = 1;
    public $categoryId, $lengh_category=0;
    public $showSaveModal = true, $showConfirmSaveModal = true, $showConfirmDeleteModal = true;
    public $close = true, $open = false;
    public $confirmingItemAdd;


    public function render()
    {
        $query = Category::orderBy($this->selectedOrderBy,$this->selectedOrder);

        if ($this->search) {
            $query->where('code', 'like', '%' . $this->search . '%')
                ->orWhere('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        }
        if ($this->selectedStatus){
            $query->where('status', $this->selectedStatus);
        }
        $categories = $query->paginate($this->perPage, ['*'], 'page', $this->page);
        $this->lengh_category = $categories->total() ;
        return view('livewire.configuration.category-crud', compact('categories'));
    }

    public function subPage()
    {
        if($this->page>1){
            $this->page = $this->page-1;
        }
    }

    public function addPage()
    {
        if($this->page<($this->lengh_category/$this->perPage)){
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
        $this->selectedCategory = Category::find($departmentId);
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
        $this->selectedCategory = null;
        $this->showSaveModal = $this->open;
    }


    public function edit()
    {
        if ($this->selectedCategory) {
            $this->mode = 'edit';
            $this->showSaveModal = $this->open;
            $this->code = $this->selectedCategory->code;
            $this->name = $this->selectedCategory->name;
            $this->description = $this->selectedCategory->description;
            $this->status = $this->selectedCategory->status;
        }
    }

    public function save()
    {
        if ($this->mode === 'create') {
            $validatedData = $this->validate([
                'name' => 'required',
                'description' => 'nullable',
            ]);
            $countRows = Category::count();
            // Rellenar con ceros a la izquierda para obtener una cadena de 8 caracteres
            $code = 'CTG' . str_pad($countRows, 5, '0', STR_PAD_LEFT);
            Category::create([
                'code' => $code,
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'status' => true,
            ]);
            session()->flash('message', 'Registro añadido exitosamente');
        } elseif ($this->mode === 'edit') {
            $validatedData = $this->validate([
                'name' => 'required',
                'description' => 'nullable',
                'status' => 'required'
            ]);
            $this->selectedCategory->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'status' => $validatedData['status'],
            ]);
            session()->flash('message', 'Registro editado exitosamente');
        }
        $this->closeModal();
    }
    // public function confirmDelete()
    // {
    //     if ($this->selectedCategory) {
    //         $this->showConfirmDeleteModal = $this->open;
    //     }
    // }

    // public function delete()
    // {
    //     if ($this->selectedCategory) {
    //         $this->selectedCategory->delete();
    //         $this->selectedCategory = null;
    //         $this->resetInputFields();
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
    }
    public function clearFilters()
    {
        $this->selectedStatus = null;
        $this->search = null;
        $this->selectedCategory = null;
        $this->mode = "create";
        $this->closeModal();
    }
}
