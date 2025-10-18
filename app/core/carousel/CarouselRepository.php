<?php

namespace App\core\carousel;

use App\Models\Carousel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CarouselRepository implements CarouselInterface
{
    /**
     * Get all carousel banners (admin or artist-wise)
     */
    public function getAllBanners($request)
    {
        if (auth()->guard('artists')->check()) {
            return Carousel::where('user_id', auth()->guard('artists')->id())
                ->with('artist')
                ->orderByDesc('id')
                ->get();
        }

        $searchCustomer = trim($request->search_customer ?? '');
        $query = Carousel::with('artist')->orderByDesc('id');

        if ($searchCustomer !== '') {
            $query->whereHas('artist', function ($q) use ($searchCustomer) {
                $q->where('username', 'like', "%{$searchCustomer}%")
                    ->orWhere('name', 'like', "%{$searchCustomer}%")
                    ->orWhere('email', 'like', "%{$searchCustomer}%");
            });
        }

        return $query->get();
    }

    /**
     * Get banners of all artists under a salesperson
     */
    public function getArtistBanners()
    {
        $salespersonId = Auth::guard('sales')->id();
        $artists = User::where('created_by', $salespersonId)->pluck('id');

        return Carousel::whereIn('user_id', $artists)
            ->with('artist')
            ->paginate(5);
    }

    /**
     * Store a new carousel banner
     */
    public function storeBannerImage($data)
    {
        if (!empty($data['carousel'])) {
            $data['carousel'] = $this->processImage($data['carousel']);
        }

        return Carousel::create($data);
    }

    /**
     * Update a carousel banner
     */
    public function updateBannerImage($id, $data)
    {
        $banner = Carousel::find($id);
        if (!$banner) return false;

        if (!empty($data['carousel'])) {
            // Delete old image
            if ($banner->carousel && Storage::disk('public')->exists('Carousel/' . $banner->carousel)) {
                Storage::disk('public')->delete('Carousel/' . $banner->carousel);
            }
            // Store new image
            $data['carousel'] = $this->processImage($data['carousel']);
        }

        $banner->update($data);
        return true;
    }

    /**
     * Delete a carousel banner
     */
    public function deleteBannerImage($id)
    {
        $banner = Carousel::find($id);
        if (!$banner) return false;

        // Delete stored image
        if ($banner->carousel && Storage::disk('public')->exists('Carousel/' . $banner->carousel)) {
            Storage::disk('public')->delete('Carousel/' . $banner->carousel);
        }

        return $banner->delete();
    }

    /**
     * Get banner by ID
     */
    public function getBannerById($id)
    {
        return Carousel::with('artist')->find($id);
    }

    /**
     * Handle image resizing and storage
     */
    private function processImage($imageFile)
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->make($imageFile)->resize(370, 246);

        $filename = time() . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();

        // Store in storage/app/public/Carousel
        $path = 'Carousel/' . $filename;
        Storage::disk('public')->put($path, (string) $image->encode('jpg', 60));

        return $filename;
    }
}
