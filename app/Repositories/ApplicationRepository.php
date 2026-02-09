<?php

namespace App\Repositories;

use App\Models\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ApplicationRepository
{
    /**
     * @param array $data
     *
     * @return Application
     */
    public function create(array $data): Application
    {
        return Application::create($data);
    }

    /**
     * @param string $courseId
     * @param string $email
     *
     * @return bool
     */
    public function existsForCourseAndEmail(string $courseId, string $email): bool
    {
        return Application::query()
            ->where('course_id', $courseId)
            ->where('email', $email)
            ->exists();
    }

    /**
     * @param $id
     *
     * @return Application
     */
    public function findOrFail($id): Application
    {
        return Application::query()
            ->findOrFail($id);
    }

    public function delete(Application $application): void
    {
        $application->delete();
    }

    /**
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */

    public function get(array $filters = []): LengthAwarePaginator
    {
        $query = Application::query();

        if (!empty($filters['email'])) {
            $query->where('email', $filters['email']);
        }

        if (!empty($filters['course_id'])) {
            $query->where('course_id', $filters['course_id']);
        }

        $sort = $filters['sort'] ?? 'last_name';
        $order = $filters['order'] ?? 'asc';
        $query->orderBy($sort, $order);
        $perPage = $filters['per_page'] ?? 15;

        return $query->paginate($perPage);
    }
}
