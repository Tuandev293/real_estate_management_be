<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use App\Repositories\BuildingRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class BuildingController extends BaseApiController
{
    private BuildingRepositoryInterface $buildingRepository;

    public function __construct(BuildingRepositoryInterface $buildingRepository)
    {
        $this->buildingRepository = $buildingRepository;
    }

    /**
     * Display a paginated list of buildings with search and sorting.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('key_word');
            $perPage = $request->query('per_page', 10);
            $sortOrder = $request->query('sort_order', 'asc');

            $buildings = $this->buildingRepository->getAllBuildings($search, $perPage, $sortOrder);

            return $this->success($buildings, 'Get Building Successfully', Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('message error:', ['error' => $e->getMessage()]);

            return $this->error('Internal Server Error', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function findById($id = 0)
    {
        try {
            $building = $this->buildingRepository->findById($id);

            if (!$building) {
                return $this->error('404 Not Found', [], Response::HTTP_NOT_FOUND);
            }

            return $this->success($building, 'Find Building Successfully', Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('message error:', ['error' => $e->getMessage()]);

            return $this->error('Internal Server Error', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a new building record in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'name_building' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'room_number' => 'required|integer',
                'price' => 'required|numeric',
                'image' => 'nullable|file|mimes:jpg,png,jpeg|max:2048'
            ]);

            if ($validator->fails()) {
                return $this->error('Validation failed', $validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('buildings');
                $image->move($destinationPath, $imageName);
                $data['image'] = 'buildings/' . $imageName;
            }

            $create = $this->buildingRepository->create($data);

            return $this->success($create, 'Create Successfully', Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error('message error:', ['error' => $e->getMessage()]);

            return $this->error('Internal Server Error', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update an existing building.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id = 0)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'name_building' => 'string|max:255',
                'address' => 'string|max:255',
                'room_number' => 'integer',
                'price' => 'numeric',
                'image' => 'nullable|file|mimes:jpg,png,jpeg|max:2048' // 2MB
            ]);

            if ($validator->fails()) {
                return $this->error('Validation Failed', $validator->errors()->toArray(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('buildings');
                $image->move($destinationPath, $imageName);
                $data['image'] = 'buildings/' . $imageName;
            }

            $building = $this->buildingRepository->findById($id);

            if (!$building) {
                return $this->error('404 Not Found', [], Response::HTTP_NOT_FOUND);
            }

            $updatedBuilding = $this->buildingRepository->update($building, $data);

            return $this->success($updatedBuilding, 'Updated Successfully', Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('message error:', ['error' => $e->getMessage()]);

            return $this->error('Internal Server Error', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete a building by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id = 0)
    {
        try {
            $building = $this->buildingRepository->findById($id);

            if (!$building) {
                return $this->error('404 Not Found', [], Response::HTTP_NOT_FOUND);
            }

            $this->buildingRepository->delete($building);

            return $this->success([], 'Deleted Successfully', Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('message error:', ['error' => $e->getMessage()]);

            return $this->error('Internal Server Error', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
