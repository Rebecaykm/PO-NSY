<?php

namespace App\Http\Livewire\Configuration;

use App\Models\CostCenter;
use Livewire\Component;
use Livewire\WithPagination;

class CostCenterShow extends Component
{
    use WithPagination;
    public $search;
    public $selectedStatus;
    public $selectedOrderBy = 'name', $selectedOrder = 'ASC';
    public $selectedPermission;
    public $name;
    public $perPage = 10;
    public $permission_id;
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
        return view('livewire.configuration.cost-center-show');
    }
    public function getPermissions()
    {
        $query = CostCenter::query()
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

    public function selectPermission($permission_id)
    {
        $this->selectedPermission = CostCenter::find($permission_id);
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
        $this->reset(['selectedPermission', 'name']);
    }

    public function uploadData()
    {
        $this->name = $this->selectedPermission->name;
    }

    public function create()
    {
        $this->mode = 'create';
        $this->resetInputFields();
        $this->openModalSave();
    }

    public function edit()
    {
        if ($this->selectedPermission) {
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
            $permission = CostCenter::create([
                'name' => $this->name,
                'guard_name' => 'web',
            ]);

            if ($permission) {
                session()->flash('success', 'Registro añadido exitosamente');
            } else {
                session()->flash('error', 'Error al crear registro, vuelva a intentar más tarde');
            }
        } elseif ($this->mode === 'edit') {
            $this->selectedPermission->update([
                'name' => $this->name,
            ]);

            if ($this->selectedPermission->wasChanged()) {
                session()->flash('success', 'Registro editado exitosamente');
            } else {
                session()->flash('error', 'Error al editar registro, vuelva a intentar más tarde');
            }
        }

        $this->closeAllModals();
    }

    public function delete()
    {
        if ($this->selectedPermission) {
            $this->selectedPermission->delete();
            $this->selectedPermission = null;
            $this->closeAllModals();

            if ($this->selectedPermission) {
                session()->flash('error', 'Error al eliminar el registro, por favor inténtelo más tarde');
            } else {
                session()->flash('success', 'Registro eliminado exitosamente');
            }
        }
    }
}
