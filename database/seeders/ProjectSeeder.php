<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Facility;
use App\Models\Project;
use App\Models\ProjectArea;
use App\Models\ProjectBloc;
use App\Models\ProjectUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $developer = Developer::create([
        //     'name' => 'PT Babatan Kusuma'
        // ]);
        // $project = Project::create([
        //     'developer_id' => $developer->id,
        //     'city_id' => 3578,
        //     'name' => 'The Grand Kenjeran'
        // ]);
        // $projectArea = ProjectArea::create([
        //     'developer_id' => $developer->id,
        //     'project_id' => $project->id,
        //     'name' => 'Akeno'
        // ]);
        // $bloc = ProjectBloc::create([
        //     'developer_id' => $developer->id,
        //     'project_area_id' => $projectArea->id,
        //     'name' => 'A05'
        // ]);
        // $bloc = ProjectUnit::create([
        //     'developer_id' => $developer->id,
        //     'project_bloc_id' => $bloc->id,
        //     'name' => '01'
        // ]);

        $faker = Faker::create();

        for ($d = 1; $d <= 3; $d++) {
            $developer = Developer::create([
                'name' => $faker->company, // Nama developer random
            ]);

            for ($p = 1; $p <= 3; $p++) {
                $project = Project::create([
                    'developer_id' => $developer->id,
                    'city_id' => 3578,
                    'name' => $faker->streetName . ' Residence', // Nama project random
                ]);
                for ($f = 1; $f <= 3; $f++) {
                    // Create Facility for Project
                    Facility::create([
                        'developer_id' => $developer->id,
                        'project_id' => $project->id,
                        'title' => $faker->sentence(3), // Title Facility
                        // 'image' => 'dummy-facility.jpg', // Gambar dummy
                        'description' => $faker->paragraph, // Deskripsi Facility
                        'created_by' => 1, // Asumsi Admin ID = 1
                        'is_active' => $faker->boolean(80) ? 1 : 0, // 80% aktif, 20% tidak aktif
                    ]);
                }

                for ($a = 1; $a <= 2; $a++) {
                    $projectArea = ProjectArea::create([
                        'developer_id' => $developer->id,
                        'project_id' => $project->id,
                        'name' => 'Area ' . strtoupper($faker->bothify('??-##')), // Nama area kombinasi huruf-angka random
                    ]);

                    for ($b = 1; $b <= 2; $b++) {
                        $bloc = ProjectBloc::create([
                            'developer_id' => $developer->id,
                            'project_area_id' => $projectArea->id,
                            'name' => 'Bloc ' . strtoupper($faker->bothify('B-##')), // Nama bloc random
                        ]);

                        for ($u = 1; $u <= 4; $u++) {
                            ProjectUnit::create([
                                'developer_id' => $developer->id,
                                'project_bloc_id' => $bloc->id,
                                'name' => 'Unit ' . $faker->buildingNumber, // Nama unit random
                            ]);
                        }
                    }
                }
            }
        }
    }
}
