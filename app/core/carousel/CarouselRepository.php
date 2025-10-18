<?php

namespace App\core\carousel;

use App\Models\Carousel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        return Carousel::whereIn('user_id', $artists)->with('artist')->paginate(5);
    }

    /**
     * Store a new carousel banner
     */
    public function storeBannerImage($data)
    {
        if (!empty($data['carousel'])) {
            $imageFile = $data['carousel'];

            if ($imageFile->isValid()) {
                $manager = new ImageManager(new Driver());
                $image = $manager->read($imageFile->getRealPath())->resize(370, 246);

                $filename = time() . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();
                $directory = public_path('storage/Carousel');

                if (!is_dir($directory)) {
                    mkdir($directory, 0777, true);
                }

                $path = $directory . '/' . $filename;
                $image->save($path, 60);

                $data['carousel'] = $filename;
            }
        }

        return Carousel::create($data);
    }

    /**
     * Delete a carousel banner
     */
    public function deleteBannerImage($id)
    {
        $banner = Carousel::find($id);

        if (!$banner) {
            return false;
        }

        // Delete stored image
        if (!empty($banner->carousel)) {
            $imagePath = public_path('storage/Carousel/' . $banner->carousel);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        return $banner->delete();
    }

    /**
     * Optional helper (not in interface, but used by controller)
     */
    public function getBannerById($id)
    {
        return Carousel::with('artist')->find($id);
    }

    /**
     * Optional helper for updates (used by controller)
     */
    public function updateBannerImage($id, $data)
    {
        $banner = Carousel::find($id);

        if (!$banner) {
            return false;
        }

        if (!empty($data['carousel'])) {
            $imageFile = $data['carousel'];

            if ($imageFile->isValid()) {
                $manager = new ImageManager(new Driver());
                $image = $manager->read($imageFile->getRealPath())->resize(370, 246);

                $filename = time() . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();
                $directory = public_path('storage/Carousel');

                if (!is_dir($directory)) {
                    mkdir($directory, 0777, true);
                }

                $path = $directory . '/' . $filename;
                $image->save($path, 60);

                // Delete old image
                if (!empty($banner->carousel)) {
                    $oldImagePath = public_path('storage/Carousel/' . $banner->carousel);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $data['carousel'] = $filename;
            }
        }

        $banner->update($data);
        return true;
    }
}
