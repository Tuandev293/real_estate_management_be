<?php
namespace App\Repositories;

use App\Models\Building;
use App\Repositories\BuildingRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class BuildingRepository implements BuildingRepositoryInterface {
    private $building;

    public function __construct(Building $building){
        $this->building = $building;
    }

     /**
     * Get a paginated list of buildings with search and sorting.
     *
     * @param string|null $search
     * @param int $perPage
     * @param string $sortOrder
     */
    public function getAllBuildings($search = null, $perPage = 10, $sortOrder = 'asc')
    {
        return $this->building
            ->when($search, function ($query, $search) {
                $query->where('name_building', 'LIKE', "%$search%")
                      ->orWhere('address', 'LIKE', "%$search%");
            })
            ->orderBy('price', in_array(strtolower($sortOrder), ['asc', 'desc']) ? strtolower($sortOrder) : 'asc')
            ->paginate($perPage);
    }

    /**
     * Create a new building record in the database.
     *
     * @param array $data
     * @return \App\Models\Building
     */
    public function create($data) {
        return $this->building->create($data);
    }

    /**
     * Find a building by its ID.
     *
     * @param int $id
     * @return \App\Models\Building
     */
    public function findById($id){
        return $this->building->find($id);
    }

    /**
     * Update an existing building record.
     *
     * @param \App\Models\Building $building
     * @param array $data
     * @return \App\Models\Building
     */
    public function update($building, $data) {

        if(!empty($data['image'])){
            if($building->image){
                Storage::disk('public')->delete($building->image);
            }

            $building->image = $data['image'];
        }

        $building->update($data);

        return $building;
    }

    /**
     * Delete a building record by ID.
     *
     * @param \App\Models\Building $building
     * @return bool
     */
    public function delete($building){
        if ($building->image) {
            Storage::disk('public')->delete($building->image);
        }

        return $building->delete();
    }
}
