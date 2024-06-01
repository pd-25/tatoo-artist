<?php

namespace App\Http\Controllers\artist;

use App\core\artist\ArtistInterface;
use App\core\artwork\ArtworkInterface;
use App\core\placement\PlacementInterface;
use App\core\style\StyleInterface;
use App\core\subject\SubjectInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArtworkController extends Controller
{
    private $artworkInterface, $artistInterface, $styleInterface, $placementInterface, $subjectInterface;
    public function __construct(ArtworkInterface $artworkInterface, ArtistInterface $artistInterface, StyleInterface $styleInterface, PlacementInterface $placementInterface, SubjectInterface $subjectInterface)
    {
        $this->artworkInterface = $artworkInterface;
        $this->artistInterface = $artistInterface;
        $this->styleInterface = $styleInterface;
        $this->placementInterface = $placementInterface;
        $this->subjectInterface = $subjectInterface;
    }
    public function getArtistWiseArtwork() {
        $data['artworks'] =  $this->artworkInterface->getArtistWiseArtwork(auth()->guard('artists')->id());
        return view('admin.artwork.index', $data);
    }

    public function getForm(){
        $data['artists'] = $this->artistInterface->getAllArtist();
        $data['styles'] = $this->styleInterface->getAllStyle();
        $data['placements'] = $this->placementInterface->getAllPlacements();
        $data['subjects'] = $this->subjectInterface->getAllSubjects();
        return view('admin.artwork.create', $data);
      
    }

    public function uploadArtistWiseArtwork(Request $request) {
        $request->validate([
            'user_id' => 'required|numeric|exists:users,id',
            'style_id' => 'required|numeric|exists:styles,id',
            'placement_id' => 'required|numeric|exists:placements,id',
            'subject_id' => 'required|numeric|exists:subjects,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);
        $data = $request->only('user_id', 'style_id', 'placement_id', 'subject_id', 'image', 'zipcode', 'country');
        $store = $this->artworkInterface->storeArtworkData($data);
        if ($store) {
            return redirect()->route('artists.getForm')->with('msg', 'New artwork uploded successfully.');
        } else {
            return back()->with('msg', 'Some error occured.');
        }
    }

    public function editArtwork($id){
        $data['artwork'] =  $this->artworkInterface->getSingleArtwork(decrypt($id));
        $data['artists'] = $this->artistInterface->getAllArtist();
        $data['styles'] = $this->styleInterface->getAllStyle();
        $data['placements'] = $this->placementInterface->getAllPlacements();
        $data['subjects'] = $this->subjectInterface->getAllSubjects();
        if ($data['artwork'] == 'Not Found') {
            return back()->with('msg', 'No artwork found!');
        }
        return view('admin.artwork.edit', $data);
    }

    public function updateArtwork(Request $request, string $id)
    {
        $request->validate([
            'style_id' => 'required|numeric|exists:styles,id',
            'placement_id' => 'required|numeric|exists:placements,id',
            'subject_id' => 'required|numeric|exists:subjects,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);
        $data = $request->only('user_id', 'style_id', 'placement_id', 'subject_id', 'image','zipcode', 'country');
        $update = $this->artworkInterface->updateArtwork($data, decrypt($id));
        if ($update) {
            return back()->with('msg', 'Artwork information updated successfully.');
        } elseif ($update == 'No data') {
            return back()->with('msg', 'No artist found.');
        }
    }

    public function destroyArtwork(string $id)
    {
        try {
            $delete = $this->artworkInterface->deleteArtwork(decrypt($id));
            if ($delete) {
                return back()->with('msg', 'Artwork has been deleted successfully.');
            } elseif ($delete == 'No data') {
                return back()->with('msg', 'No artwork found.');
            }
        } catch (\Throwable $th) {
            return back()->with('msg', $th->getMessage());
        }
    }
}
