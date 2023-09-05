<?php

namespace App\Models;

use App\Services\FileStorageService;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string|null $description
 * @property string $SKU
 * @property float $price
 * @property int|null $discount
 * @property int $quantity
 * @property string $thumbnail
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Image> $images
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSKU($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model implements Buyable
{
    use HasFactory;

    protected const DEFAULT_IMAGE_THUMBNAIL = 'resources/images/admin/products/no_product.png';

    protected $fillable = [
        'slug',
        'title',
        'description',
        'SKU',
        'price',
        'discount',
        'quantity',
        'thumbnail',
    ];

    protected $with = ['categories'];

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageble', 'image_type', 'image_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function slug(): Attribute
    {
        return Attribute::make(set: fn(string $value) => Str::of($value)->slug('-')->value());
    }

    /**
     * @return \Attribute
     */
    public function thumbnailUrl():Attribute {

        return Attribute::get(function () {

            $key = "products.thumbnail.{$this->thumbnail}";

            if(!Cache::has($key)) {
                $link = Storage::disk('s3')->temporaryUrl($this->thumbnail, now()->addMinutes(10));
                Cache::put($key, $link, 580);
                return $link;
            }


            return Cache::get($key);
//           return Storage::disk('s3')->exists($this->thumbnail)
//               ? Storage::disk('s3')->temporaryUrl($this->thumbnail, now()->addMinutes(10))
//               : \Vite::asset(static::DEFAULT_IMAGE_THUMBNAIL);
        });
    }

    public function setThumbnailAttribute($thumbnail)
    {
            if(!empty($this->attributes['thumbnail'])) {
                FileStorageService::remove($this->attributes['thumbnail']);
            }

            $this->attributes['thumbnail'] =  FileStorageService::upload($thumbnail,
                $this->attributes['slug'] . '/thumbnail'
            );
    }

    public function price():Attribute {
        return Attribute::get(function () {
            return round($this->attributes['price'], 2);
        });
    }

    public function endPrice():Attribute {
        return Attribute::get(function () {
            $price = $this->attributes['price'];
            $discount = $this->attributes['discount'] ?? 0;

            $endPrice = $discount === 0
                ? $price
                : ($price - ($price * $discount/100));

            return $endPrice <= 0 ? 1 : round($endPrice, 2);
        });
    }


    public function getBuyableIdentifier($options = null)
    {
        return $this->id;
    }

    public function getBuyableDescription($options = null)
    {
        return $this->title;
    }

    public function getBuyablePrice($options = null)
    {
        return $this->endPrice;
    }

    public function getBuyableWeight($options = null)
    {
        return 0;
    }

    public function scopeAvailable(Builder $query): Builder {
        return $query->where('quantity', '>', 0);
    }
}
