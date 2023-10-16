<?php

namespace Database\Seeders;

use App\Models\MetodePembayaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MetodePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metodePembayaranData = [
            [
                'nama_metode' => 'tunai',
            ],
            [
                'nama_metode' => 'non tunai',
            ],
        ];

        foreach ($metodePembayaranData as $key => $val) {
            MetodePembayaran::create($val);
        }
    }
}
