<?php

namespace Modules\Tag\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Tag extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tags';

    const CUSTOM_FIELD_MODEL = 'Modules\Tag\Models\Tag';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Tag\database\factories\TagFactory::new();
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
