<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SynchronizationParameter extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'table',
        'column',
        'type',
        'value'
    ];

    /**
     * @param array $attributes
     * @return array
     */
    public function setDataCreate(array $attributes): array
    {
        $data = [];
        foreach ($this->fillable as $item) {
            $data[$item] = $attributes[$item];
        }
        return $data;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setDataUpdate(string $value): SynchronizationParameter
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param string $table
     * @param string $column
     * @param string $type
     * @return mixed
     */
    public function getSyncParameter(string $table, string $column, string $type): mixed
    {
        return $this->where('table', $table)
            ->where('column', $column)
            ->where('type', $type)
            ->latest('id')
            ->first();
    }

    /**
     * @param Model $model
     * @param string $value
     * @param string $type
     * @return array
     */
    public function creteOrUpdateSyncParameters(Model $model, string $value, string $type): array
    {
        $tableModel = $model->getTable();
        $columTable = $type == 'create' ? $model::SYNC_PARAMETER_COLUMN_CREATE : $model::SYNC_PARAMETER_COLUMN_UPDATE;
        $parameter = $this->getSyncParameter($tableModel, $columTable, $type);
        if ($columTable == 'updated_at') {
            $value = Carbon::parse($value);
        }
        if ($parameter && $parameter->value != $value) {
            if ($columTable == 'updated_at') {
                if (Carbon::parse($parameter->value) < Carbon::parse($value)) {
                    $parameter->setDataUpdate($value);
                    $parameter->save();
                }
            } else {
                $parameter->setDataUpdate($value);
                $parameter->save();
            }
        } else if (!$parameter){
            $this->create([
                'table' => $tableModel,
                'column' => $columTable,
                'type' => $type,
                'value' => $value
            ]);
        }
        $columCreate = $model::SYNC_PARAMETER_COLUMN_CREATE;
        $columnUpdate = $model::SYNC_PARAMETER_COLUMN_UPDATE;
        $parameterCreate = $this->getSyncParameter($tableModel, $columCreate, 'create');
        $parameterUpdate = $this->getSyncParameter($tableModel, $columnUpdate, 'update');
        return [
            'parameter_create' => $parameterCreate,
            'parameter_update' => $parameterUpdate
        ];
    }
}
