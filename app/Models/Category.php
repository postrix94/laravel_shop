<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name', 'description', 'parent_id'];


    public function slug(): Attribute {
        return Attribute::make(
            set: fn (string $value) => Str::of($value)->slug('-'),
        );
    }

    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class);
    }

    public function parent(): BelongsTo {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function childs(): HasMany {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function image(): MorphOne {
        return $this->morphOne(Image::class,'imageble', 'image_type', 'image_id');
    }
}
