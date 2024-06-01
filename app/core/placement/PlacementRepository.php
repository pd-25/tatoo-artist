<?php
namespace App\core\placement;

use App\Models\Placement;

class PlacementRepository implements PlacementInterface {
    public function getAllPlacements(){
        return Placement::orderBy('id', 'asc')->get();
    }
}