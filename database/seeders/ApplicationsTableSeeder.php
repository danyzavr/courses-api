<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();
        foreach ($courses as $course) {
            $appCount = rand(1, 3);
            $applications = collect(range(1, $appCount))->map(function () use ($course) {
                return [
                    'id' => Str::uuid()->toString(), // UUID вручную
                    'course_id' => $course->id,
                    'first_name' => fake()->firstName(),
                    'last_name' => fake()->lastName(),
                    'middle_name' => fake()->firstName(),
                    'email' => fake()->unique()->safeEmail(),
                    'created_at' => Carbon::parse($course->start_date)->subDays(rand(1, 20)),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null,
                ];
            })->toArray();
            Application::insert($applications);
        }
    }
}
