<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['menu_id', 'order_id', 'price_at_order', 'quantity'];

    public function menu(){
        return $this->belongsTo(Menu::class);
    }
}
