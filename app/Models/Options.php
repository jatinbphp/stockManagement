<?php

namespace App\Models;
use App\Models\OptionsValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Options extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['type', 'name', 'status'];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    public function option_values()
    {
        return $this->hasMany(OptionsValue::class, 'option_id')->orderBy('id', 'ASC');
    }

    const TYPE_SELECT_OPTION = '';
    const TYPE_SELECT = 'select';
    const TYPE_RADIO = 'radio';

    public static $option_types = [
        self::TYPE_SELECT_OPTION => 'Select Option Type',
        self::TYPE_SELECT => 'Select Box',
        self::TYPE_RADIO => 'Radio Button',
    ];
}
