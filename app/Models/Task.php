<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['title', 'description','order', 'status', 'user_id'];

    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
