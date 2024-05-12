<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Setting extends Model implements TranslatableContract, HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;
    use InteractsWithMedia;

    public $translatedAttributes = ['title', 'content'];
    protected $fillable = ['logo','favicon','facebook','phone','linkedin','email'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('favicon');
        $this->addMediaCollection('logo')->withResponsiveImages();
    }

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

        $this->addMediaConversion('thumb-cropped')
            ->crop('crop-center', 400, 400); // Trim or crop the image to the center for specified width and height.
    }
}
