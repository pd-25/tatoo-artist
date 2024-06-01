<?php
namespace App\core\artwork;

interface ArtworkInterface {
    public function getAllArtwork();
    public function getSalesPersonArtwork();
    public function storeArtworkData(array $data);
    public function getSingleArtwork($id);
    public function updateArtwork($data,$id);
    public function deleteArtwork($id);
    public function likeUnlike($data);
    public function artworkWiseLike($id);
    public function commentPost($data);
    public function artworkWiseComment($id);
    public function totalView($data);
    public function totalViewCount($data);
    public function getArtistWiseArtwork($id);
    
    

    

    

    
    
    
}