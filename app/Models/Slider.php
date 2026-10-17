<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'sliders';

    protected $fillable = ['title', 'short_description', 'image', 'mobile_image', 'status', 'link'];

    public function getActionUrlAttribute(): string
    {
        $link = trim((string) $this->link);
        if (! preg_match('/[\x00-\x20]/', $link) && ! str_contains($link, '\\')) {
            if (str_starts_with($link, '/') && ! str_starts_with($link, '//')) {
                return url($link);
            }
            if (filter_var($link, FILTER_VALIDATE_URL) && in_array(strtolower(parse_url($link, PHP_URL_SCHEME) ?? ''), ['http', 'https'], true)) {
                return $link;
            }
        }

        return route('search');
    }
}
