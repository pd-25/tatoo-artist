<?php
namespace App\core\style;

use App\Models\Style;

class StyleRepository implements StyleInterface {
    public function getAllStyle(){
        return Style::orderBy('id', 'asc')->get();
    }
}