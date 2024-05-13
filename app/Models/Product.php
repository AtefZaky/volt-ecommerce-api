<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'price',
        'picture',
        'best_seller',
    ];

    public function scopeFilter($query, array $filters) {
        if($filters['category_id'] ?? false) {
            $query->where('category_id', request('category'));
        }

        if($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }

        if($filters['best_seller'] ?? false) {
            $query->where('best_seller', request('best_seller'));
        }
        if($filters['Limit'] ?? false) {
            $query->take(request('limit')) -> get();
        }
    }

    public function productReviews(): HasMany
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
