<?php

namespace App\Services;

use App\Repositories\CourseRepositry;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CourseService
{
    public function __construct(
        private CourseRepositry $courseRepositry,
    )
    {
    }

    /**
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */
    public function getAllCourses(array $filters = []): LengthAwarePaginator
    {
        return $this->courseRepositry->all($filters);
    }
}
