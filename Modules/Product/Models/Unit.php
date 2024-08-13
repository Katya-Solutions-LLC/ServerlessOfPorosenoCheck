<?php

namespace Modules\Product\Models;

use App\Models\BaseModel;
use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Unit extends BaseModel
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $table = 'units';

    const CUSTOM_FIELD_MODEL = 'Modules\Product\Models\Product';

    protected $fillable = ['name', 'slug', 'status'];

    protected $casts = [
        'status' => 'integer',
    ];

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\UnitFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function scopeCheckMultivendor($query)
    {
        if (enableMultivendor() == "0") {
            return $query->where(function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->whereIn('user_type', ['admin', 'demo_admin']);
                })
                ->orWhereNull('created_by');
            });
        }
        return $query;
    }
}
