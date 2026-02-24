<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Treatment;

class TreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $treatments = [
            // Preventiva
            ['name' => 'Consulta General', 'price' => 50.00, 'duration' => 30],
            ['name' => 'Profilaxis (Limpieza)', 'price' => 120.00, 'duration' => 45],
            ['name' => 'Fluorización', 'price' => 80.00, 'duration' => 30],

            // Restauradora
            ['name' => 'Curación Simple (Resina)', 'price' => 150.00, 'duration' => 45],
            ['name' => 'Curación Compuesta', 'price' => 200.00, 'duration' => 60],
            ['name' => 'Perno Dental', 'price' => 250.00, 'duration' => 60],

            // Endodoncia
            ['name' => 'Endodoncia Unirradicular', 'price' => 400.00, 'duration' => 90],
            ['name' => 'Endodoncia Multirradicular', 'price' => 600.00, 'duration' => 120],

            // Cirugía
            ['name' => 'Exodoncia Simple', 'price' => 100.00, 'duration' => 45],
            ['name' => 'Exodoncia Tercera Molar', 'price' => 350.00, 'duration' => 90],

            // Estética
            ['name' => 'Blanqueamiento Dental Laser', 'price' => 500.00, 'duration' => 60],
            ['name' => 'Carillas de Resina', 'price' => 300.00, 'duration' => 90],

            // Prótesis
            ['name' => 'Corona de Porcelana', 'price' => 800.00, 'duration' => 0], // Multiple sessions usually
            ['name' => 'Prótesis Total', 'price' => 1500.00, 'duration' => 0],
            ['name' => 'Prótesis Removible', 'price' => 1000.00, 'duration' => 0],

            // Ortodoncia
            ['name' => 'Instalación de Brackets', 'price' => 1200.00, 'duration' => 120],
            ['name' => 'Consulta Mensual Ortodoncia', 'price' => 150.00, 'duration' => 45],
        ];

        foreach ($treatments as $treatment) {
            Treatment::firstOrCreate(
            ['name' => $treatment['name']],
                $treatment
            );
        }
    }
}
