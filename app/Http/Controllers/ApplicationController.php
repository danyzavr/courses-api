<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteApplicationRequest;
use App\Http\Requests\GetApplicationsRequest;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Services\ApplicationService;
use Illuminate\Http\JsonResponse;

class ApplicationController extends Controller
{
    public function __construct(
        private ApplicationService $applicationService,
    )
    {
    }

    /**
     * @param StoreApplicationRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreApplicationRequest $request): JsonResponse
    {
        $validated = $this->apiValidate($request, [
            'course_id' => ['required', 'uuid', 'exists:courses,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);
        $application = $this->applicationService->store($validated);

        return $this->apiResponse([
            'message' => 'Заявка успешно создана',
            'data' => new ApplicationResource($application)
        ]);
    }

    /**
     * @param DeleteApplicationRequest $request
     *
     * @return JsonResponse
     */

    public function delete(DeleteApplicationRequest $request): JsonResponse
    {
        $validated = $this->apiValidate($request, [
            'id' => ['required', 'uuid', 'exists:applications,id'],
        ]);
        $this->applicationService->delete($validated);

        return $this->apiResponse([
            'message' => 'Заявка успешно удалена',
        ]);
    }

    /**
     * @param GetApplicationsRequest $request
     *
     * @return JsonResponse
     */
    public function get(GetApplicationsRequest $request): JsonResponse
    {
        $validated = $this->apiValidate($request, [
            'email' => 'email|nullable',
            'course_id' => 'uuid|nullable|exists:courses,id',
            'sort' => 'string|in:first_name,last_name,email,created_at|nullable',
            'order' => 'string|in:asc,desc|nullable',
            'page' => 'integer|min:1|nullable',
            'per_page' => 'integer|min:1|max:100|nullable',
        ]);
        $applications = $this->applicationService->get($validated);
        if ($applications->isEmpty()) {
            return $this->apiNotFound('Заявки не найдены');
        }

        return $this->apiPaginate(ApplicationResource::collection($applications));
    }
}
