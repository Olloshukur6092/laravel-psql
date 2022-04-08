<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'article',
        'name',
        'status',
        'data',
        'isActive'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function setPropertiesAttribute($value)
	{
	    $data = [];

	    foreach ($value as $array_item) {
	        if (!is_null($array_item['key'])) {
	            $data[] = $array_item;
	        }
	    }

	    $this->attributes['data'] = json_encode($data);
	}
}
