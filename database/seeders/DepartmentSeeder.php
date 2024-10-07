<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //DEP. 1
        Department::create([
            'CODE' => 'DE0001',
            'name' => 'Press',
            'description' => 'Prensas',
            'status' => 1,
        ]);
        //DEP. 2
        Department::create([
            'CODE' => 'DE0002',
            'name' => 'Body',
            'description' => 'Carrocerias',
            'status' => 1,
        ]);
        //DEP. 3
        Department::create([
            'CODE' => 'DE0003',
            'name' => 'Chasis',
            'description' => '',
            'status' => 1,
        ]);
        //DEP. 4
        Department::create([
            'CODE' => 'DE0004',
            'name' => 'Paint',
            'description' => 'Pintura',
            'status' => 1,
        ]);
        //DEP. 5
        Department::create([
            'CODE' => 'DE0005',
            'name' => 'MFG ADM',
            'description' => 'Manufactura Administrativa',
            'status' => 1,
        ]);
        //DEP. 6
        Department::create([
            'CODE' => 'DE0006',
            'name' => 'Purchasing',
            'description' => 'Compras',
            'status' => 1,
        ]);
        //DEP. 7
        Department::create([
            'CODE' => 'DE0007',
            'name' => 'Control Production',
            'description' => 'Control de Producción',
            'status' => 1,
        ]);
        //DEP. 8
        Department::create([
            'CODE' => 'DE0008',
            'name' => 'Quality',
            'description' => 'Calidad',
            'status' => 1,
        ]);
        //DEP. 9
        Department::create([
            'CODE' => 'DE0009',
            'name' => 'Engineering',
            'description' => 'Ingenieria',
            'status' => 1,
        ]);
        //DEP. 10
        Department::create([
            'CODE' => 'DE0010',
            'name' => 'Maintenance',
            'description' => 'Mantenimiento',
            'status' => 1,
        ]);
        //DEP. 11
        Department::create([
            'CODE' => 'DE0011',
            'name' => 'General',
            'description' => 'General',
            'status' => 1,
        ]);
        //DEP. 12
        Department::create([
            'CODE' => 'DE0012',
            'name' => 'Direction',
            'description' => 'Dirección',
            'status' => 1,
        ]);
        //DEP. 13
        Department::create([
            'CODE' => 'DE0013',
            'name' => 'Sales',
            'description' => 'Ventas',
            'status' => 1,
        ]);
        //DEP. 14
        Department::create([
            'CODE' => 'DE0014',
            'name' => 'Finance',
            'description' => 'Finanzas',
            'status' => 1,
        ]);
        //DEP. 15
        Department::create([
            'CODE' => 'DE0015',
            'name' => 'HR',
            'description' => 'Recursos Humanos',
            'status' => 1,
        ]);
        //DEP. 16
        Department::create([
            'CODE' => 'DE0016',
            'name' => 'IT',
            'description' => 'Tecnologías de la información',
            'status' => 1,
        ]);
        //DEP. 17
        Department::create([
            'CODE' => 'DE0017',
            'name' => 'Kaizen',
            'description' => 'Kaizen',
            'status' => 1,
        ]);
        //DEP. 18
        Department::create([
            'CODE' => 'DE0018',
            'name' => 'Import & Export',
            'description' => 'Import & Export',
            'status' => 1,
        ]);
        //DEP. 19
        Department::create([
            'CODE' => 'DE9999',
            'name' => 'Otro',
            'description' => 'OTRO Para los CostCenters sin Dep. definido',
            'status' => 1,
        ]);
    }
}
