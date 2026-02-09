<?php

namespace App\Repositories;

use App\Models\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CourseRepositry
{
    /**
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */
    public function all(array $filters = []): LengthAwarePaginator
    {
        $query = Course::query();

        if (!empty($filters['title'])) {
            $query->where('title', 'like', "%{$filters['title']}%");
        }

        if (!empty($filters['start_date'])) {
            $query->where('start_date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->where('end_date', '<=', $filters['end_date']);
        }

        $sort = $filters['sort'] ?? 'start_date';
        $order = $filters['order'] ?? 'asc';
        $query->orderBy($sort, $order);
        $perPage = $filters['per_page'] ?? 15;

        return $query->paginate($perPage);
    }

    /**
     * @param $id
     *
     * @return Course
     */
    public function findOrFail($id): Course
    {
        return Course::query()
            ->findOrFail($id);
    }
}
