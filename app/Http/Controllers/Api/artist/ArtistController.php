<?php

namespace App\Http\Controllers\Api\artist;

use App\core\artist\ArtistInterface;
use App\core\placement\PlacementInterface;
use App\core\style\StyleInterface;
use App\core\subject\SubjectInterface;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    private $artist, $styleInterface, $subjectInterface, $placementInterface;
    public function __construct(ArtistInterface $artistInterface, StyleInterface $styleInterface, SubjectInterface $subjectInterface, PlacementInterface $placementInterface)
    {
        $this->artist = $artistInterface;
        $this->styleInterface = $styleInterface;
        $this->subjectInterface = $subjectInterface;
        $this->placementInterface = $placementInterface;
    }
    public function artistInfo()
    {
        $data = $this->artist->getSingleArtist(auth()->id());

        if ($data == 'Not Found') {
            return response()->json([
                'status' => false,
                'msg' => 'No user found'
            ]);
        }
        return response()->json([
            'status' => true,
            'msg' => 'Artist data fetched successfully',
            'data' => $data
        ]);
    }

    public function artistGet($username){
        $data =  User::with('artworks', 'artworks.views', 'artworks.likes',  'artworks.comments', 'timeData', 'bannerImages')->where('username', $username)->first();

        if ($data) {
            return response()->json([
                'status' => true,
                'msg' => 'Artist data fetched successfully',
                'data' => $data
            ]);
            
        }
        return response()->json([
            'status' => false,
            'msg' => 'No user found'
        ]);
        
    }

    public function artistUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'string',
            'zipcode' => 'numeric|min:6',
            'phone' => 'numeric',
            'address' => 'nullable|string|max:500',
        ]);

        $data = $request->only('name', 'username', 'email', 'phone', 'address', 'address2', 'country', 'state', 'city', 'password', 'zipcode', 'latitude','longitude', 'profile_image', 'banner_image');
        $timeData = $request->only('sunday_from', 'sunday_to', 'monday_from', 'monday_to', 'tuesday_from', 'tuesday_to', 'wednesday_from', 'wednesday_to', 'thrusday_from', 'thrusday_to', 'friday_from', 'friday_to', 'saterday_from', 'saterday_to');
        $close = $request->only( 'sunday_close','monday_close', 'tuesday_close', 'wednesday_close', 'thrusday_close','friday_close', 'saterday_close');
        $update = $this->artist->updateArtist($data, $id, $timeData, $close);
        if ($update) {
            return response()->json([
                'status' => true,
            ]);
        } elseif ($update == 'No data') {
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function styles() {
        $data = $this->styleInterface->getAllStyle();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);

    }

    public function placements() {
        $data = $this->placementInterface->getAllPlacements();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);

    }

    public function subjects() {
        $data = $this->subjectInterface->getAllSubjects();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);

    }

    public function allArtist() {
        return response()->json([
            'data' => $this->artist->getAllArtist()
        ]);
    }
}
