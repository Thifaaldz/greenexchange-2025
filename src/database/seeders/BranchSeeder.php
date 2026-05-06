<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Cabang Cempaka Putih',
                'address' => 'Jl. Cempaka Putih Raya No.12, Jakarta Pusat',
                'latitude' => -6.1766554,
                'longitude' => 106.8651602,
            ],
            [
                'name' => 'Cabang Tebet',
                'address' => 'Jl. Tebet Timur Dalam No.45, Jakarta Selatan',
                'latitude' => -6.2261537,
                'longitude' => 106.8499401,
            ],
            [
                'name' => 'Cabang Bekasi',
                'address' => 'Jl. Ahmad Yani No.23, Bekasi',
                'latitude' => -6.2384987,
                'longitude' => 106.9922883,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
