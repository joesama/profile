<?php
namespace Joesama\Profile\Data\Traits;

use Illuminate\Database\Eloquent\Builder;

trait UseProfileFilter
{

    /**
     * Order by name.
     *
     * @param [type] $query
     *
     * @return void
     */
    public function scopeOrderByName(Builder $query)
    {
        $query->orderBy('name');
    }

    /**
     * Filter profile model base on parameter.
     *
     * @param Builder $query
     * @param array $filters
     *
     * @return void
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        })->when($filters['sort'] ?? null, function ($query, $column) {
            $query->orderBy($column['field'] ?? 'name', $column['type'] ?? 'desc');
        }, function ($query) {
            return $query->orderByName();
        })->when($filters['column'] ?? null, function ($query, $filter) {
            collect($filter)->each(function ($string, $key) use ($query) {
                if ($string !== '') {
                    $query->orWhere($key, 'like', '%'.$string.'%');
                }
            });
        });
    }
}
