<?php

namespace App\Models;

use App\Models\Notebook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory, SoftDeletes;

    // protected $fillable = [
    //     'user_id',
    //     'title',
    //     'text',
    // ];

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notebook()
    {
        return $this->belongsTo(Notebook::class);
    }
}
