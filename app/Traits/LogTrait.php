<?php

namespace App\Traits;

use App\Models\Log;

trait LogTrait
{
    /**
     * @param string $class
     * @param string $method
     * @param array|null $inputParameters
     * @param array|null $outputParameters
     * @return mixed
     */
    protected function newLog(string $class, string $method, array $inputParameters = null, array $outputParameters = null): mixed
    {
        $attributes = $this->createAttributes($class, $method, $inputParameters, $outputParameters);
        $log = new Log();
        $dataCreate = $log->setDataCreate($attributes);
        return $log->create($dataCreate);
    }

    /**
     * @param string $class
     * @param string $method
     * @param array|null $inputParameters
     * @param array|null $outputParameters
     * @return array
     */
    private function createAttributes(string $class, string $method, array $inputParameters = null, array $outputParameters = null): array
    {
        return [
            'class' => $class,
            'method' => $method,
            'input_parameters' => $inputParameters ? json_encode($inputParameters, JSON_UNESCAPED_UNICODE) : null,
            'output_parameters' => $outputParameters ? json_encode($outputParameters, JSON_UNESCAPED_UNICODE) : null,
        ];
    }
}
