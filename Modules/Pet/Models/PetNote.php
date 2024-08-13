<?php

namespace Modules\Pet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
class PetNote extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'pet_id', 'description', 'status', 'is_private','created_by'];
    protected $casts = [
        'pet_id' => 'integer',
        'status' => 'boolean',
      ];
    protected static function newFactory()
    {
        return \Modules\Pet\Database\factories\PetNoteFactory::new();
    }
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }



}
