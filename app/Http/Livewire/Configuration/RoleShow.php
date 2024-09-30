<?php

namespace App\Http\Livewire\Configuration;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleShow extends Component
{
    use WithPagination;

    public $search;
    public $selectedStatus;
    public $selectedOrderBy = 'name', $selectedOrder = 'ASC';
    public $choosePermission;
    public $selectedRole;
    public $selectedPermission;
    public $name;
    public $perPage = 10;
    public $role_id;
    public $mode = 'create';
    public $ShowSaveModal = true;
    public $ShowSavePermissionModal = true;
    public $ShowConfirmDeleteModal = true;
    public $ShowConfirmDeletePermissionModal = true;
    public $ShowPermissionsModal = true;
    public $close = true, $open = false;

    protected $queryString = ['search', 'page', 'selectedOrderBy', 'selectedOrder'];

    protected $rules = [
        'name' => 'required',
        'choosePermission' => 'required',
    ];
    public function render()
    {
        return view('livewire.configuration.role-show', [
            'roles' => $this->getRoles(),
            'permissions' => $this->getPermissions(),
            'availablePermissions' => $this->getAvailablePermissions(),
        ]);
    }
    

    public function getRoles()
    {
        $query = Role::query()
            ->orderBy($this->selectedOrderBy, $this->selectedOrder);

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        return $query->paginate($this->perPage);
    }
    public function getPermissions()
    {
        if($this->selectedRole){
            $query = $this->selectedRole->permissions()->get();
        } else {
            $query = collect();
        }
        return $query;
    }

    public function getAvailablePermissions()
    {
        if ($this->selectedRole) {
            return Permission::whereNotIn('id', $this->selectedRole->permissions->pluck('id'))->get();
        }
        return collect();
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

    public function selectRole($role_id)
    {
        $this->selectedRole = Role::find($role_id);
    }
    public function selectPermission($permission_id)
    {
        $this->selectedPermission = Permission::find($permission_id);
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
    public function OpenModalSavePermission()
    {
        $this->ShowSavePermissionModal = false;
    }
    
    public function CloseModalSavePermission()
    {
        $this->ShowSavePermissionModal = true;
    }

    public function OpenModalDelete()
    {
        $this->ShowConfirmDeleteModal = false;
    }
    public function CloseModalDelete()
    {
        $this->ShowConfirmDeleteModal = true;
    }
    public function OpenModalDeletePermission()
    {
        $this->ShowConfirmDeletePermissionModal = false;
    }

    public function CloseModalDeletePermission()
    {
        $this->ShowConfirmDeletePermissionModal = true;
    }
    public function OpenModalPermissions()
    {
        $this->ShowPermissionsModal = false;
    }
    public function CloseModalPermissions()
    {
        $this->ShowPermissionsModal = true;
    }
    public function closeAllModals()
    {
        $this->CloseModalSave();
        $this->CloseModalDelete();
        $this->CloseModalSavePermission();
        $this->CloseModalDeletePermission();
    }

    public function resetInputFields()
    {
        $this->reset(['selectedRole', 'selectedPermission' , 'name', 'choosePermission']);
    }

    public function uploadData()
    {
        $this->name = $this->selectedRole->name;
    }
    

    public function create()
    {
        $this->mode = 'create';
        $this->resetInputFields();
        $this->openModalSave();
    }

    public function edit()
    {
        if ($this->selectedRole) {
            $this->mode = 'edit';
            $this->uploadData();
            $this->openModalSave();
        }
    }
    public function givePermissions()
    {
        $this->OpenModalPermissions();
    }

    public function confirmDelete()
    {
        $this->openModalDelete();
    }

    public function save()
    {
        $this->validate();

        if ($this->mode === 'create') {
            $role = Role::create([
                'name' => $this->name,
                'guard_name' => 'web',
            ]);

            if ($role) {
                session()->flash('success', 'Registro añadido exitosamente');
            } else {
                session()->flash('error', 'Error al crear registro, vuelva a intentar más tarde');
            }
        } elseif ($this->mode === 'edit') {
            $this->selectedRole->update([
                'name' => $this->name,
            ]);

            if ($this->selectedRole->wasChanged()) {
                session()->flash('success', 'Registro editado exitosamente');
            } else {
                session()->flash('error', 'Error al editar registro, vuelva a intentar más tarde');
            }
        }

        $this->closeAllModals();
    }

    public function delete()
    {
        if ($this->selectedRole) {
            $this->selectedRole->delete();
            $this->selectedRole = null;
            $this->closeAllModals();

            if ($this->selectedRole) {
                session()->flash('error', 'Error al eliminar el registro, por favor inténtelo más tarde');
            } else {
                session()->flash('success', 'Registro eliminado exitosamente');
            }
        }
    }
    
    public function savePermission()
    {
        $this->validate([
            'choosePermission' => 'required',
        ]);

        if ($this->selectedRole) {
            $this->selectedRole->givePermissionTo($this->choosePermission);
            session()->flash('success', 'Permiso añadido exitosamente');
        } else {
            session()->flash('error', 'Error al añadir el permiso, vuelva a intentar más tarde');
        }

        $this->closeAllModals();
    }

    public function deletePermission()
    {
        if ($this->selectedRole && $this->selectedPermission) {
            $this->selectedRole->revokePermissionTo($this->selectedPermission);

            session()->flash('success', 'Permiso eliminado exitosamente');
        } else {
            session()->flash('error', 'Error al eliminar el permiso, vuelva a intentar más tarde');
        }

        $this->closeAllModals();
    }
}
