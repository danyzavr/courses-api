<?php

namespace Database\Seeders;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Основы дыхания маткой',
                'description' => 'Курс по основам дыхания матки и достижения сверчеловечности',
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'Быть Олегом',
                'description' => 'Как жить когда ты Олег',
                'start_date' => Carbon::now()->addDays(100),
                'end_date' => Carbon::now()->addDays(200),
            ],
            [
                'title' => 'Мастер класс для настоящих esoteric bimbo',
                'description' => 'Bimbo yourself',
                'start_date' => Carbon::now()->subDays(20),
                'end_date' => Carbon::now()->addDays(8),
            ],
            [
                'title' => 'Как найти работу в 2026 году и не поехать крышей',
                'description' => 'Курсы самопомощи',
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(50),
            ],
        ];
        foreach ($courses as $course) {
            Course::firstOrCreate(
                [
                    'title' => $course['title'],
                    'start_date' => $course['start_date'],
                    'end_date' => $course['end_date'],
                ],
                $course
            );
        }
    }
}
