<?php
 namespace App\Repositories;

interface BuildingRepositoryInterface {

     /**
     * Get a paginated list of buildings with search and sorting.
     *
     * @param string|null $search
     * @param int $perPage
     * @param string $sortOrder
     */
    public function getAllBuildings($search = null, $perPage = 10, $sortOrder = 'asc');

     /**
     * Create a new building record.
     *
     * @param array $data
     * @return \App\Models\Building
     */

    public function create($data);

    /**
     * Update an existing building record.
     *
     * @param \App\Models\Building $building
     * @param array $data
     * @return \App\Models\Building
     */
    public function update($building, $data);

    /**
     * Delete a building by ID.
     *
     * @param \App\Models\Building $building
     * @return bool
     */
    public function delete($building);

    /**
     * Retrieve a building by its ID.
     *
     * @param int $id
     * @return \App\Models\Building
     */
    public function findById($id);
}