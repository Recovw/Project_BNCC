<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;

class Item extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 
        'price', 
        'stock', 
        'image', 
        'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
