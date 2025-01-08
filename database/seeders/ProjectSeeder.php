<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Project;
use App\Models\ProjectArea;
use App\Models\ProjectBloc;
use App\Models\ProjectUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $developer = Developer::create([
            'name' => 'PT Babatan Kusuma'
        ]);
        $project = Project::create([
            'developer_id' => $developer->id,
            'city_id' => 3578,
            'name' => 'The Grand Kenjeran'
        ]);
        $projectArea = ProjectArea::create([
            'developer_id' => $developer->id,
            'project_id' => $project->id,
            'name' => 'Akeno'
        ]);
        $bloc = ProjectBloc::create([
            'developer_id' => $developer->id,
            'project_area_id' => $projectArea->id,
            'name' => 'A05'
        ]);
        $bloc = ProjectUnit::create([
            'developer_id' => $developer->id,
            'project_bloc_id' => $bloc->id,
            'name' => '01'
        ]);
    }
}
