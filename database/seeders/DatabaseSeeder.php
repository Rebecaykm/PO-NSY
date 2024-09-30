<?php

namespace Database\Seeders;

use App\Models\ZRC;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(DepartmentSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(BuyerSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StatusListSeeder::class);
        $this->call(CostCenterSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(MeasurementUnitsSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ClassificationSeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(CommoditySeeder::class);
        $this->call(FolioSeeder::class);
        $this->call(AuthorizationSeeder::class);
        $this->call(TypeTaxCodeSeeder::class);
        $this->call(ZRCSeeder::class);
        $this->call(ZRTSeeder::class);
    }
}
