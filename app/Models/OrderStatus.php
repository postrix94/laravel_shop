<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeDefault(Builder $query): Builder
    {
        $orderStatus = config('order_status.in_process');

        return $this->statusQuery($query, $orderStatus);
    }

    public function scopePaid(Builder $query): Builder
    {
        $orderStatus = config('order_status.paid');

        return $this->statusQuery($query, $orderStatus);

    }

    public function scopeCanceled(Builder $query): Builder
    {
        $orderStatus = config('order_status.canceled');

        return $this->statusQuery($query, $orderStatus);

    }

    public function scopeCompleted(Builder $query): Builder
    {
        $orderStatus = config('order_status.completed');

        return $this->statusQuery($query, $orderStatus);

    }

    public function statusQuery(Builder $query, string $orderStatus): Builder {
        return $query->where('name', $orderStatus);
    }
}
