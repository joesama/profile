<?php
namespace Joesama\Profile\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use Maatwebsite\Excel\HeadingRowImport;
use Joesama\Profile\Services\Imports\ImportProfileFromXls;
use Joesama\Profile\Services\Contracts\ProcessProfileContract;

/**
 * Upload user profile services.
 *
 * 1. Upload profile information.
 */
class UploadProfile extends AbstractProfile implements ProcessProfileContract
{
    protected $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function import()
    {
        (new ImportProfileFromXls)->import($this->filePath, 'local', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Verify parameter passed.
     * Implementation should happend inherit class side.
     *
     * @param array $parameters
     *
     * @return bool
     */
    public function verify(array $parameters): bool
    {
        $headings = (new HeadingRowImport)->toArray($this->filePath);

        return Collection::make($headings)->flatMap(function ($book) {
            return Collection::make($book)->filter(function ($sheet) {
                return Collection::make($sheet)->contains(['name','email']);
            });
        })->count() > 0 ? false : true;
    }

    /**
     * Get the validation errors.
     * Implementation should happend inherit class side.
     *
     * @return MessageBag
     */
    public function validationErrors(): MessageBag
    {
        return new MessageBag([
            'file' => __('profile::profile.upload.not-valid')
        ]);
    }
}
