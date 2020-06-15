<?php

namespace Joesama\Profile\Services\Imports;

use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Joesama\Profile\Data\Model\Profile;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ImportProfileFromXls implements ToModel, WithHeadingRow, WithBatchInserts
{
    use Importable;

    /**
    * @param Collection $row
    *
    */
    public function model(array $row)
    {
        $name = $row['name'];

        $email = $row['email'];

        $uuid = Str::uuid();

        $userClass = config('profile.user.model');

        $user = (new ReflectionClass($userClass))->newInstance();

        $password = Str::random(8);

        $user->firstOrCreate([
                'name'  => $name,
                'email' => $email
        ], [
            'name'  => Str::title($name),
            config('profile.user.uuid') => $uuid,
            'password' => Hash::make($password)
        ]);

        Profile::where('email', $email)->forceDelete();

        return new Profile([
            'email' => $email,
            'name'  => Str::title($name),
            'user_type' => $userClass,
            'user_id' => $uuid
        ]);
    }

    public function batchSize(): int
    {
        return 200;
    }
}
