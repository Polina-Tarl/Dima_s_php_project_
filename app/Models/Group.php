<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    HasMany, BelongsTo
};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;
    protected $table = 'groups';
    public $timestamps = false;

    protected $fillable = ['id_parent', 'name'];

    // Прямые товары в этой группе
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'id_group');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Group::class, 'id_parent');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'id_parent');
    }

    public function breadcrumbs()
    {
        $path = [];
        $current = $this;
        while ($current) {
            $path[] = $current;
            $current = $current->parent;
        }
        return array_reverse($path);
    }

}

