<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('departments')->insert([
            ['name' => 'Secretaria De Finanzas', 'description' => 'Description 1' , 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Facultad de Sistemas Biologicos E Inovacion Tegnologica', 'description' => 'Description 2' , 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Secretaria General', 'description' => 'Description 3' , 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Direccion de Control Presupuestal E Inventarios ', 'description' => 'Description 4' , 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
