<?php
namespace Joesama\Profile\Data\Traits;

use Illuminate\Support\Str;
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
                    if (Str::contains($key, ['.'])) {
                        // Relation need to checked with allowed import or not.
                        $relation = ((config('profile.allow.import')) ? 'profile.' : '').
                                    Str::before($key, '.');

                        $field = Str::after($key, '.');

                        $query->whereHas($relation, function ($query) use ($field, $string) {
                            if (Str::contains($field, ['.'])) {
                                // Relation need to checked with allowed import or not.
                                $relation = Str::before($field, '.');
        
                                $field = Str::after($field, '.');
        
                                $query->whereHas($relation, function ($query) use ($field, $string) {
                                    $query->where($field, 'like', '%'.$string.'%');
                                });
                            } else {
                                $query->where($field, 'like', '%'.$string.'%');
                            }
                        });
                    } else {
                        $query->where($key, 'like', '%'.$string.'%');
                    }
                }
            });
        });
    }
}
