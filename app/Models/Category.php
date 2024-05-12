<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Category extends Model implements TranslatableContract, HasMedia
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;
    use InteractsWithMedia;

    public $translatedAttributes = ['title', 'content'];
    protected $fillable = ['image','parent'];

    public function registerMediaConversions(?Media $media = null): void
    {

        $this->addMediaConversion('inMainIndex')
        ->width(368)
        ->height(232)
        ->sharpen(10);
        $this->addMediaConversion('inSinglePage')
        ->width(750)
        ->height(350)
        ;

        $this->addMediaConversion('old-picture')
            ->sepia()
            ->border(10, 'black', Manipulations::BORDER_OVERLAY);
    }

    public function parentData()
    {
        return $this->belongsTo(Category::class, 'parent', 'id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent', 'id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }

}
