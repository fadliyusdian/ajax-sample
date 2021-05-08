<?php

use App\Hari;
use Illuminate\Database\Seeder;

class HariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $haris = [
            [
                'nama' => "Senin",
            ],
            [
                'nama' => "Selasa",
            ],
            [
                'nama' => "Rabu",
            ],
            [
                'nama' => "Kamis",
            ],
            [
                'nama' => "Jumat",
            ],
            [
                'nama' => "Sabtu",
            ],
            [
                'nama' => "Minggu",
            ],
        ];

        foreach ($haris as $item ) {
            Hari::firstOrCreate($item);
        }

        return true;
    }
}
