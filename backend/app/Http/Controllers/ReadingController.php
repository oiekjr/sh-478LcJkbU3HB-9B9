<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReadingStoreRequest;
use App\Http\Requests\ReadingUpdateRequest;
use App\Services\ReadingService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ReadingController extends Controller
{
    protected ReadingService $service;

    public function __construct(ReadingService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $readings = $this->service->getAll();
        return response()->json($readings);
    }

    public function show($id): JsonResponse
    {
        $reading = $this->service->getById($id);
        if (!$reading) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($reading);
    }

    public function store(ReadingStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $reading = $this->service->create($validated);
        return response()->json($reading, Response::HTTP_CREATED);
    }

    public function update(ReadingUpdateRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();
        $reading = $this->service->update($id, $validated);
        if (!$reading) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($reading);
    }

    public function destroy($id): JsonResponse
    {
        $deleted = $this->service->delete($id);
        if (!$deleted) {
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['message' => 'Deleted']);
    }
}
