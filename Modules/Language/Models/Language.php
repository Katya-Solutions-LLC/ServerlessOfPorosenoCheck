<?php

namespace Modules\Language\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'languages';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Language\database\factories\LanguageFactory::new();
    }
}
