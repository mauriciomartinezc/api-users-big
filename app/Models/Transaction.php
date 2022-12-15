<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const DEFAULT_PAGINATE = 20;
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_api',
        'client_id',
        'segmentation_id',
        'transaction_type_id',
        'transaction_status_id',
        'transaction_currency_id',
        'transaction_source_id',
        'year',
        'month',
        'amount',
        'savings_expiration_date',
        'transaction_detail',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function syncData(array $transactions)
    {
        foreach ($transactions as $attributes) {
            $attributes['id_api'] = $attributes['id'];
            unset($attributes['id']);
            $transaction = $this->where('id_api', $attributes['id_api'])->first();
            if (!$transaction) {
                $this->create($this->setDataCreate($attributes));
            } else {
                $transaction = $transaction->setDataUpdate($attributes);
                if (!$transaction->isClean()) {
                    $transaction->save();
                }
            }
        }
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function setDataCreate(array $attributes): array
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
    private function setDataUpdate(array $attributes): Transaction
    {
        $this->segmentation_id = $attributes['segmentation_id'];
        $this->transaction_type_id = $attributes['transaction_type_id'];
        $this->transaction_status_id = $attributes['transaction_status_id'];
        $this->transaction_currency_id = $attributes['transaction_currency_id'];
        $this->transaction_source_id = $attributes['transaction_source_id'];
        $this->year = $attributes['year'];
        $this->month = $attributes['month'];
        $this->amount = $attributes['amount'];
        $this->savings_expiration_date = $attributes['savings_expiration_date'];
        $this->transaction_detail = $attributes['transaction_detail'];
        $this->created_by = $attributes['created_by'];
        $this->updated_by = $attributes['updated_by'];
        $this->updated_at = $attributes['updated_at'];
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
