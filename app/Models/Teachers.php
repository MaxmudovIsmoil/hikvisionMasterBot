<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teachers  extends Model
{
    public static function create($name, $phone)
    {
        $static = new static();
        $static->name = $name;
        $static->phone = $phone;
        return $static;
    }
}
