<?php

namespace App\Http\Controllers\Admin\Artworks;

use App\core\artist\ArtistInterface;
use App\core\artwork\ArtworkInterface;
use App\core\placement\PlacementInterface;
use App\core\style\StyleInterface;
use App\core\subject\SubjectInterface;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::guard('admins')->check()){
            $data['artworks'] =  $this->artworkInterface->getAllArtwork();
        }else{
            $data['artworks'] =  $this->artworkInterface->getSalesPersonArtwork();
        }    
        return view('admin.artwork.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['artists'] = $this->artistInterface->getAllArtist();
        $data['styles'] = $this->styleInterface->getAllStyle();
        $data['placements'] = $this->placementInterface->getAllPlacements();
        $data['subjects'] = $this->subjectInterface->getAllSubjects();
        return view('admin.artwork.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
            return redirect()->route('artworks.index')->with('msg', 'New artwork uploded successfully.');
        } else {
            return back()->with('msg', 'Some error occured.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
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


    public function allComment(){

        if(Auth::guard('artists')->check()){
            $artist = User::where('id', auth()->guard('artists')->id())->first();
           
            $artworks = $artist->artworks ?? collect();
           
            if ($artworks->isNotEmpty()) {
                $data['comments'] = Comment::whereIn('artwork_id', $artworks->pluck('id'))->get();

            }else{
                 $data['comments'] = [];
            }
        
        } else {
            $data['comments'] = Comment::with('user', 'artwork')->get();
        }
        
        return view('admin.comment', $data);
    }

    public function deleteComment($id){
        $delete=Comment::where('id', decrypt($id))->delete();
        if ($delete) {
            return back()->with('msg', 'Comment has been deleted successfully.');
        } elseif ($delete == 'No data') {
            return back()->with('msg', 'No comment found.');
        }
    }
}
