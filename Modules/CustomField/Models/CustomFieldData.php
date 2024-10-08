<?php

namespace Modules\CustomField\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomFieldData extends BaseModel
{
    use HasFactory;

    protected $fillable = [];

    protected $table = 'custom_fields_data';
    protected $casts = [
        'custom_field_id' => 'integer',
        'model_id'=> 'integer',
      ];
    protected static function newFactory()
    {
        return \Modules\CustomField\Database\factories\CustomFieldDataFactory::new();
    }
}
