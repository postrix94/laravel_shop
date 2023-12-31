<?php

namespace App\Models;

use App\Services\FileStorageService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Image
 *
 * @property int $id
 * @property string $path
 * @property int $image_id
 * @property string $image_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $imageble
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'image_id', 'image_type'];

    public function imageble(): MorphTo {
        return $this->morphTo();
    }

    public function setPathAttribute(array $path)
    {
        $this->attributes['path'] = FileStorageService::upload(
            $path['image'],
            $path['directory'] ?? ""
        );
    }

    public function url(): Attribute
    {
        return Attribute::make(
            get: function() {

            $key = "products.image.{$this->attributes['path']}";

            if(!Cache::has($key)) {
                $link = Storage::disk('s3')->temporaryUrl($this->attributes['path'], now()->addMinutes(10));
                Cache::put($key, $link, 580);
                return $link;
            }

            return Cache::get($key);

//            if (!Storage::disk('s3')->exists($this->attributes['path'])) {
//                return $this->attributes['path'];
//            }
//
//            return Storage::disk('s3')->temporaryUrl($this->attributes['path'], now()->addMinutes(10));
        }
        );
    }

}
