<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class BranchGallery extends BaseModel
{
    use HasFactory;

    protected $fillable = ['branch_id', 'full_url', 'status'];
    protected $casts = [
        'branch_id' => 'integer',
        'created_by'=> 'integer',
        'updated_by'=> 'integer',
        'deleted_by' => 'integer',
      ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
