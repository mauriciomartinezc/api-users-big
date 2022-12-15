<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    const SYNC_PARAMETER_COLUMN_CREATE = 'id';
    const SYNC_PARAMETER_COLUMN_UPDATE = 'updated_at';
    const DEFAULT_PAGINATE = 20;

    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_api',
        'segmentation_id',
        'program_id',
        'user_id',
        'netcommerce_id',
        'h2a_token',
        'one_signal_player_id',
        'firma',
        'identification_type_id',
        'identification_number',
        'mobile_number',
        'meta',
        'insitu_code_reference',
        'birth_date',
        'active',
        'has_updated_info',
        'inactivate_reason',
        'account_lockout_date',
        'state_user_id',
        'created_at',
        'updated_at'
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

    /**
     * @param array $attributes
     * @return $this
     */
    public function setDataUpdate(array $attributes): Client
    {
        foreach ($this->fillable as $attribute) {
            if (array_key_exists($attribute, $attributes)) {
                $this->$attribute = $attributes[$attribute];
            }
        }
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
