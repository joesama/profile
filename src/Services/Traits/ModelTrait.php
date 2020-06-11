<?php
namespace Joesama\Profile\Services\Traits;

use Carbon\Carbon;
use ReflectionClass;
use Illuminate\Database\Eloquent\Model;

trait ModelTrait
{
    /**
     * Get property model.
     *
     * @param string $model
     *
     * @return Model
     */
    protected function model(string $model): Model
    {
        $model = new ReflectionClass($model);

        return $model->newInstance();
    }
}
