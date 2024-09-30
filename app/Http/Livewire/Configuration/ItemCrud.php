<?php

namespace App\Http\Livewire\Configuration;

use App\Models\Category;
use App\Models\Classification;
use App\Models\Item;
use App\Models\MeasurementUnits;
use Livewire\Component;
use Livewire\WithFileUploads;

class ItemCrud extends Component
{
    use WithFileUploads;
    public $search, $selectedStatus, $selectedOrderBy = 'code', $selectedOrder = 'ASC', $cadena;
    public $selectedItem = null, $selectedClassification_id = null, $selectedCategory_id = null;
    public $mode, $code, $name, $description, $imgPATH, $Category_id, $Classification_id, $MeasurementUnit_id,  $status, $perPage = 10, $page = 1;
    public $ItemId, $lengh_item=0;
    public $showSaveModal = true, $showConfirmSaveModal = true, $showConfirmDeleteModal = true;
    public $close = true, $open = false;
    public $confirmingItemAdd;
    public function render()
    {
        $categories = Category::orderBy('name','asc')->get();
        $classifications = Classification::orderBy('name','asc')->get();
        $measurementUnits = MeasurementUnits::orderBy('name','asc')->get();


        $query = Item::orderBy($this->selectedOrderBy,$this->selectedOrder);

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
            $classifications = $classifications->where('Category_id',$this->selectedCategory_id);
        }
        if ($this->selectedClassification_id){
            $query->where('Classification_id', $this->selectedCategory_id);
        }
        $items = $query->paginate($this->perPage, ['*'], 'page', $this->page);
        $this->lengh_item = $items->total() ;
        return view('livewire.configuration.item-crud',compact('items','categories','classifications','measurementUnits'));
    }
    
    public function create()
    {
        $this->resetInputFields();
        $this->mode = 'create';
        $this->selectedCategory_id = null;
        $this->selectedClassification_id = null;
        $this->showSaveModal = $this->open;
    }


    public function edit()
    {
        if ($this->selectedItem) {
            $this->mode = 'edit';
            $this->showSaveModal = $this->open;
            $this->code = $this->selectedItem->code;
            $this->name = $this->selectedItem->name;
            $this->description = $this->selectedItem->description;
            $this->Category_id = $this->selectedItem->Category_id;
            $this->Classification_id = $this->selectedItem->Classification_id;
            $this->MeasurementUnit_id = $this->selectedItem->MeasurementUnit_id;
            $this->status = $this->selectedItem->status;
        }
    }

    public function save(){
        if ($this->mode === 'create') {
            $validatedData = $this->validate([
                'name' => 'required',
                'description' => 'nullable',
                'Category_id' => 'required',
                'Classification_id' => 'required',
                'MeasurementUnit_id' => 'required',
                'imgPATH' => 'image|max:1024', // 1MB Max
            ]);

            $countRows = Item::count();
            // Rellenar con ceros a la izquierda para obtener una cadena de 8 caracteres
            $code = 'CLS' . str_pad($countRows, 5, '0', STR_PAD_LEFT);

            if ($this->imgPATH) {
                $imageName = $this->imgPATH->store('items', 'public');
            } else {
                $imageName = null;
            }

            Item::create([
                'code' => $code,
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'status' => true,
                'Category_id' => $validatedData['Category_id'],
                'Classification_id' => $validatedData['Classification_id'],
                'MeasurementUnit_id' => $validatedData['MeasurementUnit_id'],
                'imgPATH' => $imageName,
            ]);

            session()->flash('message', 'Registro añadido exitosamente');
        } elseif ($this->mode === 'edit') {
            $validatedData = $this->validate([
                'name' => 'required',
                'description' => 'nullable',-
                'status' => 'required',
                'Category_id' => 'required',
                'Classification_id' => 'required',
                'MeasurementUnit_id' => 'required',
                'imgPATH' => 'image|max:1024', // 1MB Max
            ]);

            if ($this->imgPATH) {
                $imageName = $this->imgPATH->store('items', 'public');
                $this->selectedItem->update([
                    'imgPATH' => $imageName,
                ]);
            }

            $this->selectedItem->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'status' => $validatedData['status'],
                'Category_id' => $validatedData['Category_id'],
                'Classification_id' => $validatedData['Classification_id'],
                'MeasurementUnit_id' => $validatedData['MeasurementUnit_id'],
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
        $this->Classification_id = '';
        $this->selectedCategory_id = '';
        $this->selectedClassification_id = '';
    }
    public function clearFilters()
    {
        $this->selectedStatus = null;
        $this->search = null;
        $this->selectedClassification_id = null;
        $this->selectedCategory_id = null;
        $this->mode = "create";
        $this->closeModal();
    }
    public function subPage()
    {
        if($this->page>1){
            $this->page = $this->page-1;
        }
    }

    public function addPage()
    {
        if($this->page<($this->lengh_clasification/$this->perPage)){
            $this->page = $this->page+1;
        }
    }
    public function resertPage()
    {
        $this->page = 1;
        $this->render();
    }

    public function selectItem($ItemId){
        $this->selectedItem= Item::find($ItemId);
    }

    public function selectOrderFlag($cadena){
        $this->selectedOrderBy = $cadena;
        if($this->selectedOrder === 'ASC')
            $this->selectedOrder = 'DESC';
        else
            $this->selectedOrder = 'ASC';
    }

}
