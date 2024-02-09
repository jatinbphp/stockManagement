<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'name', 'image', 'status', 'parent_category_id'];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_category_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category_id', 'id');
    }

    public function subcategories()
    {
        return $this->children()->with('children');
    }
}
