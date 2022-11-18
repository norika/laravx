<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert(
            [
                [
                    'title' => "Petrol Ofisi",
                    'description' => "Petrol Ofisi - Lorem ipsum dolor",
                    'logo' => "po.jpg",
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
                [
                    'title' => "Shell",
                    'description' => "Shell - Lorem ipsum dolor",
                    'logo' => "shell.png",
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
                [
                    'title' => "Aytemiz",
                    'description' => "Aytemiz - Lorem ipsum dolor",
                    'logo' => "aytemiz.png",
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
                [
                    'title' => "Bp",
                    'description' => "Bp - Lorem ipsum dolor",
                    'logo' => "bp.png",
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ],
                [
                    'title' => "Lukoil",
                    'description' => "Lukoil - Lorem ipsum dolor",
                    'logo' => "lukoil.jpg",
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]
            ]
        );
    }
}
