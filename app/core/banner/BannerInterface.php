<?php
namespace App\core\banner;

interface BannerInterface {
    public function getAllBanners($request);
    public function getArtistBanners();
    public function storeBannerImage($data);
    public function deleteBannerImage($id);
    
}

