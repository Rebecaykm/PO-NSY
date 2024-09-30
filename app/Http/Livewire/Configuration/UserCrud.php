<?php

namespace App\Http\Livewire\Configuration;

use App\Exports\Configuration\UserExport;
use App\Models\Authorization;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
class UserCrud extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $search, $selectedStatus, $selectedOrderBy = 'name', $selectedOrder = 'ASC', $field;
    public $selectedRow, $mode, $name, $phone, $email, $email_notification, $password, $Department_id, $role_id, $Buyer, $perPage = 10, $page = 1;
    public $rowID, $length_dataset=0;
    public $showSaveModal = true, $showConfirmSaveModal = true, $showConfirmDeleteModal = true;
    public $showSaveAuthorizationModal = true;
    public $showViewAuthorizationsModal = true;
    public $selectedAuth = null;
    public $Status = 0;
    public $signature = null;
    public $close = true, $open = false;

    public function render()
    {
        $query = User::orderBy($this->selectedOrderBy,$this->selectedOrder);

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('phone', 'like', '%' . $this->search . '%');
        }
        if ($this->selectedStatus){
            $query->where('status', $this->selectedStatus);
        }
        $dataset = $query->paginate($this->perPage, ['*'], 'page', $this->page);
        $this->length_dataset = $dataset->total() ;

        $departments = Department::where('Status',true)
            ->orderBy('Name','ASC')->GET();
        $roles = Role::all();
        $authorizations = null;
        if($this->selectedRow){
            $authorizations = Authorization::where('User_id',$this->selectedRow->id)->get();
        }
        return view('livewire.configuration.user-crud', compact('dataset','departments','roles','authorizations'));
    }

    public function subPage(){if($this->page>1) $this->page = $this->page-1;
        
    }

    public function addPage(){if($this->page<($this->length_dataset/$this->perPage)) $this->page = $this->page+1;}
    public function resetPage(){
        $this->page = 1;
        $this->render();
    }

    public function selectRow($rowID){$this->selectedRow = User::find($rowID);}
    public function selectAuth($Auth_id){$this->selectedAuth = Authorization::find($Auth_id);}

    public function selectOrderFlag($field){
        $this->selectedOrderBy = $field;
        $this->selectedOrder = ($this->selectedOrder === 'ASC') ? 'ASC' : 'DESC';
    }

    public function create(){
        $this->resetInputFields();
        $this->mode = 'create';
        $this->selectedRow = null;
        $this->showSaveModal = $this->open;
    }

    public function edit(){
        if ($this->selectedRow) {
            $this->mode = 'edit';
            $this->showSaveModal = $this->open;
            $this->name = $this->selectedRow->name;
            $this->phone = $this->selectedRow->phone;
            $this->email = $this->selectedRow->email;
            $this->password = "";
            $this->Department_id = $this->selectedRow->Department_id;
            $this->role_id = $this->selectedRow->roles[0]->id;
        }
    }

    public function save(){
        if ($this->mode === 'create') {
            $validatedData = $this->validate([
                'name' => 'required',
                'email' => 'required|email|max:50|unique:users,email',
                'email_notification' => 'required|email|max:50|unique:users,email',
                'phone' => 'nullable',
                'password' => 'nullable|string|min:8',
                'Department_id' => 'required|exists:departments,id',
                'role_id' => 'required|numeric',
            ]);
            
            
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'email_notification' => $validatedData['email_notification'],
                'phone' => $validatedData['phone'],
                'password' => bcrypt($validatedData['password']),
                'Department_id' => $validatedData['Department_id'],
                // 'role_id' => 'required|numeric',
            ]);
            $user->roles()->sync($validatedData['role_id']);
            
                session()->flash('message', 'Registro añadido exitosamente');
        }
        elseif ($this->mode === 'edit') {
            $validatedData = $this->validate([
                'name' => 'required',
                'email' => 'required|email|max:50|unique:users,email,' . $this->selectedRow->id,
                'email_notification' => 'required|email|max:50',
                'signature' => 'nullable|image|mimes:jpeg,png,jpg|max:15360', // 15 MB = 15360 KB
                'phone' => 'nullable',
                'password' => 'nullable|string|min:8',
                'Department_id' => 'required|exists:departments,id',
                'role_id' => 'required|numeric',
            ]);

            $imageName = null;
            if ($this->signature) {
                $imageExtension = $this->signature->extension();
                $imageName = 'Signature' . '_' . $this->selectedRow->id . '.' . $imageExtension;

                // Store the image
                $this->signature->storeAs('public/signs', $imageName);
            }
            
            if(empty($validatedData['password'])){
                $this->selectedRow->update([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'email_notification' => $validatedData['email_notification'],
                    'phone' => $validatedData['phone'],
                    'signature' => $imageName,
                    'Department_id' => $validatedData['Department_id'],
                ]);
            }
            else
                $this->selectedRow->update([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'email_notification' => $validatedData['email_notification'],
                    'phone' => $validatedData['phone'],
                    'signature' => $imageName,
                    'password' => bcrypt($validatedData['password']),
                    'Department_id' => $validatedData['Department_id'],
                ]);
            $this->selectedRow->roles()->sync($validatedData['role_id']);
            // $this->selectedRow->roles()->sync($validatedData['role_id']);
            session()->flash('success', 'Registro editado exitosamente');
        }
        
        $this->closeModal();
    }

    public function SaveAuth(){
        $validatedData = $this->validate([
            'Department_id' => 'required|exists:departments,id',
            'Status' => 'required|boolean',
        ]);
        $auth = null;
        if($this->selectedRow){
            $auth = Authorization::create([
                'TypeAuthorization' => 'RQ',
                'User_id' => $this->selectedRow->id,
                'Department_id' => $validatedData['Department_id'],
                'Status' => $validatedData['Status'],
            ]);
        }
        // dd($auth);
        if($auth)
            session()->flash('success', 'Registro añadido exitosamente');
        else
            session()->flash('error', 'Error al generar autorización');
        $this->showSaveAuthorizationModal = $this->close;
    }

    public function confirmDelete(){ if ($this->selectedRow)  $this->showConfirmDeleteModal = $this->open; }
    public function OpenShowModalAuthorizations(){ $this->showViewAuthorizationsModal = $this->open; }
    public function CloseShowModalAuthorizations(){ $this->showViewAuthorizationsModal = $this->close; }

    public function OpenShowModalSaveAuthorizations(){ $this->showSaveAuthorizationModal = $this->open; }
    public function CloseShowModalSaveAuthorizations(){ $this->showSaveAuthorizationModal = $this->close; }

    public function delete(){
        if ($this->selectedRow) {
            $this->selectedRow->delete();
            $this->selectedRow = null;
            $this->closeModal();
            session()->flash('message', 'Registro eliminado exitosamente');
        }
    }
    public function closeModal(){
        $this->showConfirmSaveModal = $this->close;
        $this->showSaveModal = $this->close;
        $this->showConfirmDeleteModal = $this->close;
    }
    private function resetInputFields(){
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->password = '';
    }
    public function clearFilters(){
        $this->selectedStatus = null;
        $this->search = null;
        $this->selectedRow = null;
        $this->mode = "create";
        $this->closeModal();
    }

    // public function generatePDF(){
    //     $query = User::orderBy($this->selectedOrderBy,$this->selectedOrder);

    //     if ($this->search) {
    //         $query->where('name', 'like', '%' . $this->search . '%')
    //             ->orWhere('email', 'like', '%' . $this->search . '%')
    //             ->orWhere('phone', 'like', '%' . $this->search . '%');
    //     }
    //     if ($this->selectedStatus)
    //         $query->where('status', $this->selectedStatus);
    //     $dataset = $query->get();

    //     try {
    //         $pdf = PDF::loadView('Configuration.User.pdf', ['dataset' => $dataset]);

    //         // Nombre del PDF basado en el nombre del almacén y la fecha actual
    //         $pdfName = 'TablaUSER_' . now()->format('_Y-m-d_H:i:s') . '.pdf';

    //         // Usar "stream" para ver el PDF en el navegador o "download" para forzar la descarga
    //         return $pdf->stream($pdfName);
    //     } catch (\Exception $e) {
    //         // Manejar errores en la generación del PDF
    //         return response()->json(['error' => 'Error generando el PDF. Detalles: ' . $e->getMessage()], 500);
    //     }
    // }

    // public function exportReport(){
    //     $query = User::orderBy($this->selectedOrderBy,$this->selectedOrder);

    //     if ($this->search) {
    //         $query->where('CODE', 'like', '%' . $this->search . '%')
    //             ->orWhere('Name', 'like', '%' . $this->search . '%')
    //             ->orWhere('Description', 'like', '%' . $this->search . '%');
    //     }
    //     if ($this->selectedStatus){
    //         $query->where('Status', $this->selectedStatus);
    //     }
    //     $departments = $query->get();

    //     $name = 'ListaDepartamentos_' . now()->format('_Y-m-d_H:i:s') . '.xlsx';
    //     // Llamar al exportador y generar el archivo Excel
    //     return Excel::download(new UserExport($dataset), $name);
    // }
}
