<?php

namespace App\Http\Livewire\Configuration;

use App\Models\Buyer;
use Livewire\Component;
use Livewire\WithPagination;

class BuyerShow extends Component
{
    use WithPagination;
    public $search;
    public $selectedStatus;
    public $selectedOrderBy = 'PBPBC', $selectedOrder = 'ASC';
    public $selectedBuyer;
    public $name;
    public $perPage = 10;
    public $buyer_id;
    public $mode = 'create';
    public $ShowSaveModal = true;
    public $ShowConfirmDeleteModal = true;
    public $close = true, $open = false;
    protected $queryString = ['search', 'page', 'selectedOrderBy', 'selectedOrder'];
    protected $rules = [
        'name' => 'required',
    ];
    public function render()
    {
        return view('livewire.configuration.buyer-show',[
            'buyers' => $this->getBuyers(),
        ]);
    }
    public function getBuyers()
    {
        $query = Buyer::query()
            ->orderBy($this->selectedOrderBy, $this->selectedOrder);

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        return $query->paginate($this->perPage);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedOrderBy()
    {
        $this->resetPage();
    }

    public function updatingSelectedOrder()
    {
        $this->resetPage();
    }

    public function resetPage()
    {
        $this->reset('page');
    }

    public function clearFilters()
    {
        $this->reset(['search', 'page']);
    }

    public function selectBuyer($buyer_id)
    {
        $this->selectedBuyer = Buyer::find($buyer_id);
    }

    public function selectOrderFlag($field)
    {
        if ($this->selectedOrderBy == $field) {
            $this->selectedOrder = $this->selectedOrder === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->selectedOrderBy = $field;
            $this->selectedOrder = 'ASC';
        }
    }

    public function OpenModalSave()
    {
        $this->ShowSaveModal = false;
    }

    public function CloseModalSave()
    {
        $this->ShowSaveModal = true;
    }

    public function OpenModalDelete()
    {
        $this->ShowConfirmDeleteModal = false;
    }

    public function CloseModalDelete()
    {
        $this->ShowConfirmDeleteModal = true;
    }

    public function closeAllModals()
    {
        $this->CloseModalSave();
        $this->CloseModalDelete();
    }

    public function resetInputFields()
    {
        $this->reset(['selectedBuyer', 'name']);
    }

    public function uploadData()
    {
        $this->name = $this->selectedBuyer->name;
    }

    public function create()
    {
        $this->mode = 'create';
        $this->resetInputFields();
        $this->openModalSave();
    }

    public function edit()
    {
        if ($this->selectedBuyer) {
            $this->mode = 'edit';
            $this->uploadData();
            $this->openModalSave();
        }
    }

    public function confirmDelete()
    {
        $this->openModalDelete();
    }

    public function save()
    {
        $this->validate();

        if ($this->mode === 'create') {
            $buyer = Buyer::create([
                'name' => $this->name,
                'guard_name' => 'web',
            ]);

            if ($buyer) {
                session()->flash('success', 'Registro añadido exitosamente');
            } else {
                session()->flash('error', 'Error al crear registro, vuelva a intentar más tarde');
            }
        } elseif ($this->mode === 'edit') {
            $this->selectedBuyer->update([
                'name' => $this->name,
            ]);

            if ($this->selectedBuyer->wasChanged()) {
                session()->flash('success', 'Registro editado exitosamente');
            } else {
                session()->flash('error', 'Error al editar registro, vuelva a intentar más tarde');
            }
        }

        $this->closeAllModals();
    }

    public function delete()
    {
        if ($this->selectedBuyer) {
            $this->selectedBuyer->delete();
            $this->selectedBuyer = null;
            $this->closeAllModals();

            if ($this->selectedBuyer) {
                session()->flash('error', 'Error al eliminar el registro, por favor inténtelo más tarde');
            } else {
                session()->flash('success', 'Registro eliminado exitosamente');
            }
        }
    }
}
