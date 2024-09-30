<?php

namespace App\Http\Livewire\Configuration;

use App\Models\StatusList;
use Livewire\Component;
use Livewire\WithPagination;

class StatusShow extends Component
{
    use WithPagination;

    public $search;
    // public $selectedStatus;
    public $selectedOrderBy = 'name', $selectedOrder = 'ASC';
    public $selectedStatus;
    public $name, $description, $status;
    public $perPage = 10;
    public $status_id;
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
        return view('livewire.configuration.status-show', [
            'statusList' => $this->getStatus()
        ]);
    }

    public function getStatus()
    {
        $query = StatusList::query()
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

    public function selectStatus($status_id)
    {
        $this->selectedStatus = StatusList::find($status_id);
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
        $this->reset(['selectedStatus', 'name']);
    }

    public function uploadData()
    {
        $this->name = $this->selectedStatus->name;
    }

    public function create()
    {
        $this->mode = 'create';
        $this->resetInputFields();
        $this->openModalSave();
    }

    public function edit()
    {
        if ($this->selectedStatus) {
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
            $countRows = StatusList::count() + 1;
            // Rellenar con ceros a la izquierda para obtener una cadena de 8 caracteres
            $code = 'STL' . str_pad($countRows, 5, '0', STR_PAD_LEFT);
            $permission = StatusList::create([
                'code' => $code,
                'name' => $this->name,
                'guard_name' => 'web',
            ]);

            if ($permission) {
                session()->flash('success', 'Registro añadido exitosamente');
            } else {
                session()->flash('error', 'Error al crear registro, vuelva a intentar más tarde');
            }
        } elseif ($this->mode === 'edit') {
            $this->selectedStatus->update([
                'name' => $this->name,
            ]);

            if ($this->selectedStatus->wasChanged()) {
                session()->flash('success', 'Registro editado exitosamente');
            } else {
                session()->flash('error', 'Error al editar registro, vuelva a intentar más tarde');
            }
        }

        $this->closeAllModals();
    }

    public function delete()
    {
        if ($this->selectedStatus) {
            $this->selectedStatus->delete();
            $this->selectedStatus = null;
            $this->closeAllModals();

            if ($this->selectedStatus) {
                session()->flash('error', 'Error al eliminar el registro, por favor inténtelo más tarde');
            } else {
                session()->flash('success', 'Registro eliminado exitosamente');
            }
        }
    }
}
