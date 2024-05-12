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

class Post extends Model implements TranslatableContract, HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;
    use InteractsWithMedia;

    public $translatedAttributes = ['title', 'content', 'small_description' , 'tags'];
    protected $fillable = ['image','user_id','category_id'];

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
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
