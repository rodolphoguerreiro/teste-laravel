<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        - Realizaria o insert de múltiplos registros dessa forma, pois geralmente é mais eficiente
        - Usaria o modelo Eloquent para deixar o código mais limpo e legível
        - Utilizaria transaction (App\Models\Category) do modelo para garantir a persistência
        */
        Category::insert([
            ['name' => 'Remessa Parcial'],
            ['name' => 'Remessa'],
        ]);
    }
}
