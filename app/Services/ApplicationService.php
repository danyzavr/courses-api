<?php

namespace App\Services;

use App\Models\Application;
use App\Repositories\ApplicationRepository;
use App\Repositories\CourseRepositry;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use MA\LaravelApiResponse\Traits\APIResponseTrait;


class ApplicationService
{
    use APIResponseTrait;

    public function __construct(
        private ApplicationRepository $applicationRepository,
        private CourseRepositry       $courseRepositry,
    )
    {

    }

    /**
     * @param array $data
     *
     * @return \App\Models\Application
     */
    public function store(array $data): Application
    {
        $course = $this->courseRepositry->findOrFail($data['course_id']);
        if ($course->start_date <= Carbon::now()) {
            $this->apiException('Курс уже начался', 'Нельзя подать заявку на уже начавшийся курс', true, 'CONFLICT_ERROR', []);
        }

        if ($this->applicationRepository->existsForCourseAndEmail(
            $data['course_id'],
            $data['email']
        )) {
            $this->apiException('Заявка уже подана', 'Заявка с этим email уже существует для данного курса', true, 'CONFLICT_ERROR', []);
        }

        return $this->applicationRepository->create($data);
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function delete(array $data): void
    {
        $application = $this->applicationRepository->findOrFail($data['id']);
        if (!$application) {
            $this->apiException('Заявка не найдена', 'Не найдена заявка с данным id', true, 'CONFLICT_ERROR', []);
        }

        $this->applicationRepository->delete($application);
    }

    /**
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */
    public function get(array $filters = []): LengthAwarePaginator
    {
        return $this->applicationRepository->get($filters);
    }

}
