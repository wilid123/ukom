<?php

namespace App\Models;

use App\Models\Category;
use App\Models\PrivateCollection;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        'book_code', 'title', 'cover', 'slug', 'writer','publisher', 'year_publish', 'stock'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * The categories that belong to the Book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_category', 'book_id', 'category_id');
    }
    
    public function collection(): BelongsToMany
    {
        return $this->belongsToMany(PrivateCollection::class, 'book_category', 'book_id', 'category_id');
    }

    /**
     * Mendefinisikan relasi antara Book dan RentLogs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rentLogs(): HasMany
    {
        return $this->hasMany(RentLogs::class);
    }

}
