<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseCrudModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'base_crud';

    protected $fillable = [
        'column_integer',
        'column_smallint',
        'column_string',
        'column_boolean',
        'column_float',
        'column_date',
        'column_time',
        'column_datetime',
        'column_text',
        'column_binary',
        'column_serverside',
        'column_map',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // Mutator for transforming all columns
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $this->transformValue($key, $value);
    }

    // Accessor for transforming all columns
    public function getAttribute($key)
    {
        return $this->transformValue($key, $this->attributes[$key]);
    }

    // Custom transformation logic
    private function transformValue($key, $value)
    {
        # __________________________________________________
        #
        # Custom transformation logic Example
        # __________________________________________________
        #  switch ($key) {
        #       case 'column_integer':
        #           return $value == 1 ? 'satu' : 'dua';
        #      default:
        #          return $value;
        #  }
        # ___________________________________________________

        return $value;
    }


    public function ColumnServerside()
    {
        return $this->belongsTo(BaseCrudModel::class, 'column_serverside', 'id');
    }
}
