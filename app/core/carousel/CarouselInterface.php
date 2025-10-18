<?php
namespace App\core\carousel;

interface CarouselInterface {
    public function getAllBanners($request);
    public function getArtistBanners();
    public function storeBannerImage($data);
    public function deleteBannerImage($id);
    
}

