<?php
namespace App\Helper;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Admin\Page;

class UserHelper {

    public static function change_dateformat($getdate){

        if(isset($getdate) && !empty($getdate)){

                $chk_format = strchr($getdate,"-");

                if($chk_format!=""){

                    $split_date = explode("-",$getdate);

                    $final_date = trim($split_date[2])."-".trim($split_date[1])."-".trim($split_date[0]);

                    return $final_date;

                }else{

                    return true;

                }   

        }else {

            return true;

        }

    }

    public static function display_dateformat($getdate){

        if(isset($getdate) && !empty($getdate)){

            if($getdate == "0000-00-00"){ // Default date 

                return "";

            }else {

                $split_date = explode("-",$getdate);

                $final_date = trim($split_date[2])."-".trim($split_date[1])."-".trim($split_date[0]);

                return $final_date;

            }

        }else{

            return "";

        }

    }

    
}