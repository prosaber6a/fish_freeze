<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chalan extends Model
{
    use HasFactory;

    public function customer () {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function user () {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function chalanitem() {
        return $this->hasMany(ChalanItem::class, 'chalan_id');
    }


}
