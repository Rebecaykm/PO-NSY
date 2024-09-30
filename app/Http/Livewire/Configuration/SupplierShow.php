<?php

namespace App\Http\Livewire\Configuration;

use App\Models\AVM;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

use function PHPUnit\Framework\isEmpty;

class SupplierShow extends Component
{
    use WithPagination;

    public $search = null;
    public $selectedStatus;
    public $selectedOrderBy = 'VENDOR', $selectedOrder = 'ASC';
    public $selectedSupplier;
    public $name;
    public $perPage = 10;
    public $permission_id;
    public $mode = 'create';
    public $ShowSaveModal = true;
    public $ShowConfirmUpdateModal = true;
    public $ShowConfirmViewInfoModal = true;
    public $close = true, $open = false;
    protected $queryString = ['search', 'page', 'selectedOrderBy', 'selectedOrder'];

    protected $rules = [
        'name' => 'required',
    ];

    public function render()
    {
        return view('livewire.configuration.supplier-show', [
            'suppliers' => $this->getSuppliers()
        ]);
    }

    public function getSuppliers()
    {
        $query = Supplier::query()
            ->orderBy($this->selectedOrderBy, $this->selectedOrder);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('VENDOR', 'like', '%' . $this->search . '%')
                    ->orWhere('VNDNAM', 'like', '%' . $this->search . '%')
                    ->orWhere('VMDATN', 'like', '%' . $this->search . '%');
            });
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

    public function selectSupplier($supplier_id)
    {
        $this->selectedSupplier = Supplier::find($supplier_id);
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


    public function resetInputFields()
    {
        $this->reset(['selectedSupplier', 'name']);
    }

    public function uploadData()
    {
        $this->name = $this->selectedSupplier->name;
    }

    public function OpenModalConfirmUpdate()
    {
        $this->ShowConfirmUpdateModal = false;
    }
    public function CloseModalConfirmUpdate()
    {
        $this->ShowConfirmUpdateModal = true;
    }

    public function update()
    {
        // Obtener todos los proveedores y avm en colecciones
        $suppliers = Supplier::all();
        $vendors = AVM::all();

        // Crear un mapa de AVM para búsqueda rápida
        $avmMap = $vendors->keyBy(function($item) {
            return $item->VENDOR;
        });

        // Validar y actualizar los registros de Supplier
        foreach ($suppliers as $supplier) {
            $key = $supplier->VENDOR;
            if ($avmMap->has($key)) {
                $avm = $avmMap->get($key);
                $supplier->update([
                    'VNSTAT' => $avm->VNSTAT,
                    'VMID' => $avm->VMID,
                    'VENDOR' => $avm->VENDOR,
                    'VNDNAM' => $avm->VNDNAM,
                    'VNDAD1' => $avm->VNDAD1,
                    'VNDAD2' => $avm->VNDAD2,
                    // 'VSTATE' => $avm->VSTATE,
                    // 'VPOST' => $avm->VPOST,
                    'VTERMS' => $avm->VTERMS,
                    'VTYPE' => $avm->VTYPE,
                    // 'VPAYTO' => $avm->VPAYTO,
                    // 'VDTLPD' => $avm->VDTLPD,
                    // 'VDAYCL' => $avm->VDAYCL,
                    // 'V1099' => $avm->V1099,
                    'VPHONE' => $avm->VPHONE,
                    // 'VCMPNY' => $avm->VCMPNY,
                    'VCURR' => $avm->VCURR,
                    'VPAYTY' => $avm->VPAYTY,
                    // 'V1TIME' => $avm->V1TIME,
                    // 'VCORPV' => $avm->VCORPV,
                    // 'VHOLD' => $avm->VHOLD,
                    // 'VHOLDT' => $avm->VHOLDT,
                    // 'VPYTYR' => $avm->VPYTYR,
                    // 'VDSCAV' => $avm->VDSCAV,
                    // 'VDSCTK' => $avm->VDSCTK,
                    // 'VDPURS' => $avm->VDPURS,
                    // 'VNNEXT' => $avm->VNNEXT,
                    // 'VNGEN' => $avm->VNGEN,
                    // 'VNALPH' => $avm->VNALPH,
                    // 'VNUNAL' => $avm->VNUNAL,
                    // 'VCON' => $avm->VCON,
                    // 'VCOUN' => $avm->VCOUN,
                    // 'V1099S' => $avm->V1099S,
                    'VPAD1' => $avm->VPAD1,
                    // 'VPAD2' => $avm->VPAD2,
                    // 'VPSTE' => $avm->VPSTE,
                    // 'VPPST' => $avm->VPPST,
                    // 'VPCON' => $avm->VPCON,
                    // 'VPCOU' => $avm->VPCOU,
                    // 'VMFRM' => $avm->VMFRM,
                    // 'VMMAT' => $avm->VMMAT,
                    // 'VTAX' => $avm->VTAX,
                    // 'VPPHN' => $avm->VPPHN,
                    'VMFSCD' => $avm->VMFSCD,
                    // 'VMIDNM' => $avm->VMIDNM,
                    'VTAXCD' => $avm->VTAXCD,
                    // 'VMXCRT' => $avm->VMXCRT,
                    // 'VMXDTE' => $avm->VMXDTE,
                    // 'VMXMAX' => $avm->VMXMAX,
                    // 'VMSRNO' => $avm->VMSRNO,
                    // 'VMPREQ' => $avm->VMPREQ,
                    // 'VMRELP' => $avm->VMRELP,
                    // 'VMVFAX' => $avm->VMVFAX,
                    // 'VMPFAX' => $avm->VMPFAX,
                    // 'VMRELM' => $avm->VMRELM,
                    // 'VMPART' => $avm->VMPART,
                    // 'VMTRBR' => $avm->VMTRBR,
                    'VMDATN' => $avm->VMDATN,
                    // 'VNDAD3' => $avm->VNDAD3,
                    // 'VPAD3' => $avm->VPAD3,
                    'VMPDAT' => $avm->VMPDAT,
                    // 'VMBANK' => $avm->VMBANK,
                    // 'VMAD5' => $avm->VMAD5,
                    // 'VMAD6' => $avm->VMAD6,
                    // 'VMLANG' => $avm->VMLANG,
                    // 'VMPAD4' => $avm->VMPAD4,
                    // 'VMPAD5' => $avm->VMPAD5,
                    // 'VMPAD6' => $avm->VMPAD6,
                    // 'VMSHFM' => $avm->VMSHFM,
                    // 'VMCCEX' => $avm->VMCCEX,
                    // 'VMAYTD' => $avm->VMAYTD,
                    // 'VMBNKC' => $avm->VMBNKC,
                    // 'VMBRNO' => $avm->VMBRNO,
                    // 'VMBNKA' => $avm->VMBNKA,
                    // 'VMUF01' => $avm->VMUF01,
                    // 'VMUF02' => $avm->VMUF02,
                    // 'VMUF03' => $avm->VMUF03,
                    // 'VMUF04' => $avm->VMUF04,
                    // 'VMUF05' => $avm->VMUF05,
                    // 'VMUF06' => $avm->VMUF06,
                    // 'VMUF07' => $avm->VMUF07,
                    // 'VMUF08' => $avm->VMUF08,
                    // 'VMUF09' => $avm->VMUF09,
                    // 'VMUF10' => $avm->VMUF10,
                    // 'VM3WMF' => $avm->VM3WMF,
                    // 'VMPKRA' => $avm->VMPKRA,
                    // 'VMSFBF' => $avm->VMSFBF,
                    // 'VMPPHZ' => $avm->VMPPHZ,
                    // 'VMFPHZ' => $avm->VMFPHZ,
                    // 'VMDIHZ' => $avm->VMDIHZ,
                    // 'VMDILT' => $avm->VMDILT,
                    // 'VMPPO' => $avm->VMPPO,
                    // 'VMAQPO' => $avm->VMAQPO,
                    // 'VMCRAL' => $avm->VMCRAL,
                    // 'VMCREC' => $avm->VMCREC,
                    // 'VMRGCD' => $avm->VMRGCD,
                ]);
            } else {
                $supplier->update(['VMID' => 'VZ']);
            }
        }

        // Crear un mapa de Supplier para búsqueda rápida
        $supplierMap = $suppliers->keyBy(function($item) {
            return $item->VENDOR;
        });

        // Validar y crear registros en Supplier que no existen
        foreach ($vendors as $vendor) {
            $key = $vendor->VENDOR;
            if (!$supplierMap->has($key)) {
                // dd($vendor,$supplierMap,$key);
                Supplier::create([
                    'VNSTAT' => $vendor->VNSTAT,
                    'VMID' => $vendor->VMID,
                    'VENDOR' => $vendor->VENDOR,
                    'VNDNAM' => $vendor->VNDNAM,
                    'VNDAD1' => $vendor->VNDAD1,
                    'VNDAD2' => $vendor->VNDAD2,
                    // 'VSTATE' => $vendor->VSTATE,
                    // 'VPOST' => $vendor->VPOST,
                    'VTERMS' => $vendor->VTERMS,
                    'VTYPE' => $vendor->VTYPE,
                    // 'VPAYTO' => $vendor->VPAYTO,
                    // 'VDTLPD' => $vendor->VDTLPD,
                    // 'VDAYCL' => $vendor->VDAYCL,
                    // 'V1099' => $vendor->V1099,
                    'VPHONE' => $vendor->VPHONE,
                    // 'VCMPNY' => $vendor->VCMPNY,
                    'VCURR' => $vendor->VCURR,
                    'VPAYTY' => $vendor->VPAYTY,
                    // 'V1TIME' => $vendor->V1TIME,
                    // 'VCORPV' => $vendor->VCORPV,
                    // 'VHOLD' => $vendor->VHOLD,
                    // 'VHOLDT' => $vendor->VHOLDT,
                    // 'VPYTYR' => $vendor->VPYTYR,
                    // 'VDSCAV' => $vendor->VDSCAV,
                    // 'VDSCTK' => $vendor->VDSCTK,
                    // 'VDPURS' => $vendor->VDPURS,
                    // 'VNNEXT' => $vendor->VNNEXT,
                    // 'VNGEN' => $vendor->VNGEN,
                    // 'VNALPH' => $vendor->VNALPH,
                    // 'VNUNAL' => $vendor->VNUNAL,
                    // 'VCON' => $vendor->VCON,
                    // 'VCOUN' => $vendor->VCOUN,
                    // 'V1099S' => $vendor->V1099S,
                    'VPAD1' => $vendor->VPAD1,
                    // 'VPAD2' => $vendor->VPAD2,
                    // 'VPSTE' => $vendor->VPSTE,
                    // 'VPPST' => $vendor->VPPST,
                    // 'VPCON' => $vendor->VPCON,
                    // 'VPCOU' => $vendor->VPCOU,
                    // 'VMFRM' => $vendor->VMFRM,
                    // 'VMMAT' => $vendor->VMMAT,
                    // 'VTAX' => $vendor->VTAX,
                    // 'VPPHN' => $vendor->VPPHN,
                    'VMFSCD' => $vendor->VMFSCD,
                    // 'VMIDNM' => $vendor->VMIDNM,
                    'VTAXCD' => $vendor->VTAXCD,
                    // 'VMXCRT' => $vendor->VMXCRT,
                    // 'VMXDTE' => $vendor->VMXDTE,
                    // 'VMXMAX' => $vendor->VMXMAX,
                    // 'VMSRNO' => $vendor->VMSRNO,
                    // 'VMPREQ' => $vendor->VMPREQ,
                    // 'VMRELP' => $vendor->VMRELP,
                    // 'VMVFAX' => $vendor->VMVFAX,
                    // 'VMPFAX' => $vendor->VMPFAX,
                    // 'VMRELM' => $vendor->VMRELM,
                    // 'VMPART' => $vendor->VMPART,
                    // 'VMTRBR' => $vendor->VMTRBR,
                    'VMDATN' => $vendor->VMDATN,
                    // 'VNDAD3' => $vendor->VNDAD3,
                    // 'VPAD3' => $vendor->VPAD3,
                    'VMPDAT' => $vendor->VMPDAT,
                    // 'VMBANK' => $vendor->VMBANK,
                    // 'VMAD5' => $vendor->VMAD5,
                    // 'VMAD6' => $vendor->VMAD6,
                    // 'VMLANG' => $vendor->VMLANG,
                    // 'VMPAD4' => $vendor->VMPAD4,
                    // 'VMPAD5' => $vendor->VMPAD5,
                    // 'VMPAD6' => $vendor->VMPAD6,
                    // 'VMSHFM' => $vendor->VMSHFM,
                    // 'VMCCEX' => $vendor->VMCCEX,
                    // 'VMAYTD' => $vendor->VMAYTD,
                    // 'VMBNKC' => $vendor->VMBNKC,
                    // 'VMBRNO' => $vendor->VMBRNO,
                    // 'VMBNKA' => $vendor->VMBNKA,
                    // 'VMUF01' => $vendor->VMUF01,
                    // 'VMUF02' => $vendor->VMUF02,
                    // 'VMUF03' => $vendor->VMUF03,
                    // 'VMUF04' => $vendor->VMUF04,
                    // 'VMUF05' => $vendor->VMUF05,
                    // 'VMUF06' => $vendor->VMUF06,
                    // 'VMUF07' => $vendor->VMUF07,
                    // 'VMUF08' => $vendor->VMUF08,
                    // 'VMUF09' => $vendor->VMUF09,
                    // 'VMUF10' => $vendor->VMUF10,
                    // 'VM3WMF' => $vendor->VM3WMF,
                    // 'VMPKRA' => $vendor->VMPKRA,
                    // 'VMSFBF' => $vendor->VMSFBF,
                    // 'VMPPHZ' => $vendor->VMPPHZ,
                    // 'VMFPHZ' => $vendor->VMFPHZ,
                    // 'VMDIHZ' => $vendor->VMDIHZ,
                    // 'VMDILT' => $vendor->VMDILT,
                    // 'VMPPO' => $vendor->VMPPO,
                    // 'VMAQPO' => $vendor->VMAQPO,
                    // 'VMCRAL' => $vendor->VMCRAL,
                    // 'VMCREC' => $vendor->VMCREC,
                    // 'VMRGCD' => $vendor->VMRGCD,
                ]);
            }
        }
        
        $this->CloseModalConfirmUpdate();
    }



}
