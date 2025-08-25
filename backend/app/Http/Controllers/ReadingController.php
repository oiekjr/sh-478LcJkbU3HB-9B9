<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReadingStoreRequest;
use App\Http\Requests\ReadingUpdateRequest;
use App\Services\ReadingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReadingController extends Controller
{
    protected ReadingService $service;

    public function __construct(ReadingService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $readings = $this->service->getAll($request->user());
        return response()->json($readings);
    }

    public function show(Request $request, $id): JsonResponse
    {
        $reading = $this->service->getById($request->user(), $id);
        if (!$reading) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($reading);
    }

    public function store(ReadingStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $reading = $this->service->create($request->user(), $validated);
        return response()->json($reading, Response::HTTP_CREATED);
    }

    public function update(ReadingUpdateRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();
        $reading = $this->service->update($request->user(), $id, $validated);
        if (!$reading) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($reading);
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        $deleted = $this->service->delete($request->user(), $id);
        if (!$deleted) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
