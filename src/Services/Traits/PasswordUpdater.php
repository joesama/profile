<?php
namespace Joesama\Profile\Services\Traits;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

trait PasswordUpdater
{
    protected function updateIdentityPassword(Model $userIdentityModel, string $newPassword)
    {
        $schema = $userIdentityModel->getConnection()->getSchemaBuilder();

        $tableName = $userIdentityModel->getTable();

        if (($schema->hasColumn($tableName, 'password'))) {
            $userIdentityModel->password = Hash::make($newPassword);
        }

        $userIdentityModel->save();
    }
}
