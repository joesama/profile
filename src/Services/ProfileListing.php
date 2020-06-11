<?php
namespace Joesama\Profile\Services;

use Illuminate\Support\Collection;
use Joesama\Profile\Data\Model\Profile;
use Joesama\Profile\Data\Model\Position;
use Joesama\Profile\Data\Model\Department;
use Joesama\Profile\Services\Traits\ModelTrait;
use Joesama\Profile\Services\Traits\ProfileFilter;

/**
 * User Profile Listing Services class
 *
 * 1. List all profile.
 * 2. Can paginate.
 * 3. Can be filtered with specific query field.
 * 4. Data can be formatted / transform.
 *
 */
class ProfileListing
{
    use ModelTrait, ProfileFilter;

    /**
     * Profile model class.
     *
     * @var string
     */
    private $profile;

    /**
     * Query filter.
     *
     * @var array
     */
    private $filter;

    /**
     * Page properties.
     *
     * @var array
     */
    private $page;

    /**
     * Profile position.
     *
     * @var array
     */
    public $position;

    /**
     * Initiate user profile service class.
     *
     */
    public function __construct()
    {
        $this->profile = config('profile.has.organization') ?
        config('profile.model.organization') :
        config('profile.model.default');

        $this->position = Position::pluck('description', 'id');

        $this->filter = [];
    }

    /**
     * Define filter query.
     *
     * @param array $filters
     *
     * @return void
     */
    public function filter(array $filters)
    {
        $this->filter = $this->availableFilter($filters);
    }

    /**
     * Get list of profile.
     *
     * @param int|null $paginate
     * @param callable $transform
     *
     * @return Collection
     */
    public function list(?int $paginate = 10, callable $transform = null): Collection
    {
        $importProfile = config('profile.allow.import');

        $modelClass = $importProfile ? config('profile.user.model') : $this->profile;

        $model = $this->model($modelClass);

        if ($importProfile) {
            $model = $model->with('profile');
        }

        $model = $model->orderByName()
        ->filter($this->filter)
        ->paginate($paginate);
  
        $this->page = [
            'total' => $model->total(),
            'page' => $model->perPage(),
            'current' => $model->currentPage(),
        ];

        return $model->transform($this->transform($transform));
    }

    /**
     * Get page properties.
     *
     * @return array
     */
    public function pages(): array
    {
        return $this->page;
    }

    /**
     * Get organization list.
     *
     * @param int $departmentId
     *
     * @return
     */
    public function organization(int $departmentId = null)
    {
        return Department::when($departmentId, function ($query, $departmentId) {
            $query->where('id', $departmentId)
                  ->with('unit');
        }, function ($query) {
            $query->with('unit');
        })->get()
        ->transform(function ($department) {
            return [
                'key' => $department->id,
                'description' => $department->description,
                'unit' => $department->unit
            ];
        });
    }
}
