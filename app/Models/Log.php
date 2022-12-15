<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'class',
        'method',
        'input_parameters',
        'output_parameters',
    ];

    /**
     * @param array $attributes
     * @return array
     */
    public function setDataCreate(array $attributes): array
    {
        $data = [];
        foreach ($this->fillable as $attribute) {
            if (array_key_exists($attribute, $attributes)) {
                $data[$attribute] = $attributes[$attribute];
            }
        }
        return $data;
    }
}
