<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetCoursesRequest;
use App\Http\Resources\CourseResource;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;


class CourseController extends Controller
{

    public function __construct(
        private CourseService $courseService,
    )
    {
    }

    /**
     * @param GetCoursesRequest $request
     *
     * @return JsonResponse
     */

    public function get(GetCoursesRequest $request): JsonResponse
    {
        $validated = $this->apiValidate($request, [
            'title' => 'string|nullable',
            'start_date' => 'date|nullable',
            'end_date' => 'date|nullable',
            'sort' => 'string|in:title,start_date,end_date|nullable',
            'order' => 'string|in:asc,desc|nullable',
            'page' => 'integer|min:1|nullable',
            'per_page' => 'integer|min:1|max:100|nullable',
        ]);
        $courses = $this->courseService->getAllCourses($validated);
        if ($courses->isEmpty()) {
            return $this->apiNotFound('Курсы не найдены');
        }

        return $this->apiPaginate(
            CourseResource::collection($courses)
        );
    }
}
