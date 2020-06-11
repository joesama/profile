<?php
namespace Joesama\Profile\Services\Traits;

use Carbon\Carbon;

trait ProfileFilter
{
    /**
     * Transform collection result.
     *
     * @param callable $transform
     *
     * @return callable
     */
    protected function transform(callable $transform = null): callable
    {
        return $transform ?? function ($model) {
            if (config('profile.allow.import')) {
                return [
                    'uuid' => $model->{config('profile.user.uuid')},
                    'name' => $model->name,
                    'email' => $model->email,
                    'position' => data_get($model, 'profile.position'),
                    'department' => data_get(collect(data_get($model, 'profile.department'))->first(), 'id'),
                    'unit' => data_get(collect(data_get($model, 'profile.unit'))->last(), 'id'),
                    'active' => data_get($model, 'profile.active'),
                    'created_at' => ($created = data_get($model, 'profile.created_at', null)) !== null ? $created->format('d-m-Y') : null,
                    'activated_at' => ($activate = data_get($model, 'profile.activated_at', null)) !== null ? $activate->format('d-m-Y') : null,
                ];
            } else {
                return [
                    'uuid' => $model->user->{config('profile.user.uuid')},
                    'name' => $model->name,
                    'email' => $model->email,
                    'position' => $model->position,
                    'department' => collect(data_get($model, 'department'))->first(),
                    'unit' => collect(data_get($model, 'unit'))->first(),
                    'active' => $model->active,
                    'created_at' => ($created = data_get($model, 'created_at', null)) !== null ? $created->format('d-m-Y') : null,
                    'activated_at' => ($activate = data_get($model, 'activated_at', null)) !== null ? $activate->format('d-m-Y') : null,
                ];
            }
        };
    }

    /**
     * List of visible field.
     * Default : name, email, position
     *
     * @return array
     */
    protected function visibleField(): array
    {
        $default = ['name', 'email', 'position'];

        return (config('profile.has.department') === true) ?
        array_merge($default, ['department', 'unit']):
        $default;
    }

    /**
     * Only available filter are allowed.
     *
     * @param array $query
     *
     * @return array
     */
    protected function availableFilter(array $query): array
    {
        return collect($query)->only(['search','sort','column'])->toArray();
    }
}
