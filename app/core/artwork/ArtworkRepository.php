<?php

namespace App\core\artwork;

use App\core\artwork\ArtworkInterface;
use App\Models\Artwork;
use App\Models\Comment;
use App\Models\Like;
use App\Models\TotalView;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ArtworkRepository implements ArtworkInterface
{
    public function getAllArtwork()
    {
        // return Artwork::with('user', 'views', 'likes', 'comments', 'user.timeData')->orderBy('id', 'DESC')->get();
       return Artwork::with(['user', 'views', 'likes', 'comments', 'user.timeData' => function ($query) {
        $query->whereNotNull('sunday_from')
            ->orWhereNotNull('sunday_to')
            ->orWhereNotNull('monday_from')
            ->orWhereNotNull('monday_to')
            ->orWhereNotNull('tuesday_from')
            ->orWhereNotNull('tuesday_to')
            ->orWhereNotNull('wednesday_from')
            ->orWhereNotNull('wednesday_to')
            ->orWhereNotNull('thrusday_from')
            ->orWhereNotNull('thrusday_to')
            ->orWhereNotNull('friday_from')
            ->orWhereNotNull('friday_to')
            ->orWhereNotNull('saterday_from')
            ->orWhereNotNull('saterday_to');
    }])
    ->orderBy('id', 'DESC')
    ->paginate(5);

    }

    public function getSalesPersonArtwork(){
        $salespersonId = Auth::guard('sales')->id(); // Get the logged-in salesperson's ID

        $artists = User::where('created_by', $salespersonId)->get(); // Get all artists created by this salesperson

        $artworks = Artwork::whereIn('user_id', $artists->pluck('id'))->paginate(5); 

        return $artworks;
    }
    protected function resizeImage($originalImagePath, $resizedImagePath, $newWidth, $newHeight)
    {
        // Get the image type and file size
        list($width, $height, $type) = getimagesize($originalImagePath);
        $fileSize = filesize($originalImagePath);
        
        // Create an image resource from the original file
        switch ($type) {
            case IMAGETYPE_JPEG:
                $srcImage = imagecreatefromjpeg($originalImagePath);
                break;
            case IMAGETYPE_PNG:
                $srcImage = imagecreatefrompng($originalImagePath);
                break;
            case IMAGETYPE_GIF:
                $srcImage = imagecreatefromgif($originalImagePath);
                break;
            default:
                return false;
        }
    
        // Calculate the new dimensions while keeping the aspect ratio
        $aspectRatio = $width / $height;
        if ($newWidth / $newHeight > $aspectRatio) {
            $newWidth = $newHeight * $aspectRatio;
        } else {
            $newHeight = $newWidth / $aspectRatio;
        }
    
        // Create a new blank image with new dimensions
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Resize the original image into the new image
        imagecopyresampled($resizedImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        
        // Save the resized image temporarily
        imagejpeg($resizedImage, $resizedImagePath, 100); // Save with maximum quality first
        
        // Check file size and apply compression if necessary
        $finalFileSize = filesize($resizedImagePath);
        if ($finalFileSize > 50 * 1024) { // If file size is greater than 50 KB
            imagejpeg($resizedImage, $resizedImagePath, 75); // Reduce quality for JPEG
        }
    
        // Free memory
        imagedestroy($srcImage);
        imagedestroy($resizedImage);
    }
    
    public function storeArtworkData(array $data)
    {
        $date = date('md') . substr(date('Y'), 2);
        $check_if_uploded = Artwork::where('user_id', $data['user_id'])->whereDate('created_at', now()->toDateString())->count();
        $username = User::where('id', $data['user_id'])->value('username');
        $data['title'] = $username . '_' . $date . '_' . ($check_if_uploded + 1);
        
        if (isset($data['image']) && $data['image'] != null) {
            $content_db = $data['title'] . "." . $data['image']->getClientOriginalExtension();
            
            // Resizing the image before storing it
            $originalImagePath = $data['image']->getPathName();
            $resizedImagePath = storage_path("app/public/ArtworkImage/" . $content_db);
            
            // Call a helper function to resize the image
            $this->resizeImage($originalImagePath, $resizedImagePath, 400, 400); // Adjust the size as needed
            
            // Save the image filename to the database
            $data['image'] = $content_db;
        }
    
        return Artwork::create($data);
    }
    
    public function updateArtwork($data, $id)
    {
        $find = Artwork::where('id', $id)->first();
        if ($find) {
            if (isset($data['image']) && $data['image'] != null) {
                // Delete the old image
                File::delete(public_path("storage/ArtworkImage/" . $find->image));
    
                // Prepare the new image filename
                $content_db = pathinfo($find->image, PATHINFO_FILENAME) . "." . $data['image']->getClientOriginalExtension();
                
                // Resize the new image before storing it
                $originalImagePath = $data['image']->getPathName();
                $resizedImagePath = storage_path("app/public/ArtworkImage/" . $content_db);
    
                // Call a helper function to resize the image
                $this->resizeImage($originalImagePath, $resizedImagePath, 400, 400); // Adjust the size as needed
                
                // Update the image path in the data array
                $data['image'] = $content_db;
            }
    
            // Update the artwork data
            return $find->update($data);
        } else {
            return 'No data';
        }
    }
    
    

    public function getSingleArtwork($id)
    {
        $find =  Artwork::where('id', $id)->first();
        if ($find) {
            return $find;
        } else {
            return 'Not Found';
        }
    }

  
    public function deleteArtwork($id){
        $find =  Artwork::where('id', $id)->first();
        if($find) {
            return $find->delete();
        }
        return 'not found';
    }


    public function likeUnlike($data){
        $check = Like::where('user_id', $data['user_id'])->where('artwork_id', $data['artwork_id'])->first();
        if($check){
            $check->delete();
            return 'unliked';
        }else{
            Like::create($data);
            return 'liked';
        }
    }


    public function artworkWiseLike($id){
        return Like::with('user')->where('artwork_id', $id)->get()->count();
    }

    public function commentPost($data){
        return DB::table('comments')->insert($data);
           
    }

    public function artworkWiseComment($id){
        return Comment::with('user')->where('artwork_id', $id)->get();
    }

    public function totalView($data){
        $check = TotalView::where('user_id', $data['user_id'])->where('artwork_id', $data['artwork_id'])->first();
        if($check){
            return 'viewed';
        }else{
            TotalView::create($data);
            return 'done';
        }
    }

    public function totalViewCount($data){
        return TotalView::where('artwork_id', $data)->get()->count();
    }
    public function getArtistWiseArtwork($id){
        return Artwork::where('user_id', $id)->paginate(5);
    }
}
