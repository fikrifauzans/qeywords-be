<?php

namespace App\Models\Transaction;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invoice'; // Mengubah nama tabel

    protected $fillable = [
        'user_id',
        'price',
        'duration',
    ];

    // Mutator untuk mentransformasi semua kolom
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $this->transformValue($key, $value);
    }

    // Accessor untuk mentransformasi semua kolom
    public function getAttribute($key)
    {
        return $this->transformValue($key, $this->attributes[$key]);
    }

    // Logika transformasi kustom
    private function transformValue($key, $value)
    {
        # __________________________________________________
        #
        # Contoh logika transformasi kustom
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
