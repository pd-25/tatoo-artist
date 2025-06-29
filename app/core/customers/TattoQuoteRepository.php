<?php
namespace App\core\customers;

use App\Models\User;
use App\Models\Quote;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use App\Helper\UserHelper;

class TattoQuoteRepository implements TattoQuoteInterface
{

	public function storeTattoQuoteData(array $data)
    {
    
        $data['artist_id'] = 1;
        return Quote::create($data);

    }
}