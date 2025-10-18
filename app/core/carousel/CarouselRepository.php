<?php

namespace App\core\carousel;

use App\Models\Carousel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $imageFile = $data['carousel'];

        $manager = new \Intervention\Image\ImageManager(['driver' => 'gd']);
        $image = $manager->make($imageFile)->resize(370, 246);

        $filename = time() . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();

        // Save in storage/app/public/Carousel
        $path = 'Carousel/' . $filename;
        Storage::disk('public')->put($path, (string) $image->encode('jpg', 80));

        // Store record in DB
        return \App\Models\Carousel::create([
            'user_id' => $data['user_id'],
            'carousel' => $filename,
            'description' => $data['description'] ?? null,
            'from_date' => $data['from_date'] ?? null,
            'to_date' => $data['to_date'] ?? null,
        ]);
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
            $data['carousel'] = $this->storeImage($data['carousel']);
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
     * Store uploaded image without resizing
     */
    private function storeImage($imageFile)
    {
        $filename = time() . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();
        $path = $imageFile->storeAs('public/Carousel', $filename); // stores in storage/app/public/Carousel
        return $filename;
    }
}
