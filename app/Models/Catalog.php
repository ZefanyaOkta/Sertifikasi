<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    
    protected $fillable = ['title', 'genre', 'author', 'page', 'image', 'status', 'availability'];

    // Relationship
    // public function user() {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
}
