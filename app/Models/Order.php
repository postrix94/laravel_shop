<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['status_id', 'user_id','vendor_order_id', 'name', 'surname', 'email', 'phone', 'city', 'address', 'total'];

    public function status():BelongsTo {
        return $this->belongsTo(OrderStatus::class);
    }

    public function user():BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function products():BelongsToMany {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'single_price');
    }

    public function transaction():HasOne {
        return $this->hasOne(Transaction::class);
    }
}
