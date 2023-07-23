<?php

namespace App\UseCases\Admin;

use App\Models\User;
use App\Models\College;
use App\Models\Department;
use App\Models\Role;
use App\UseCases\OperationLog\OperationLogUseCase;

class ListUsersUseCase
{
    /**
     * @var OperationLogUseCase
     */
    private $operationLogUseCase;

    /**
     * OperationLogUseCaseの新しいインスタンスを作成します。
     *
     * @param  OperationLogUseCase  $operationLogUseCase
     * @return void
     */
    public function __construct(OperationLogUseCase $operationLogUseCase)
    {
        $this->operationLogUseCase = $operationLogUseCase;
    }

    public function execute()
    {
        $users = User::paginate(10);
        $colleges = College::all();
        $departments = Department::all();
        $roles = Role::all();

        $this->operationLogUseCase->store('● アカウントの一覧を表示しました');

        return [
            'users' => $users,
            'colleges' => $colleges,
            'departments' => $departments,
            'roles' => $roles,
        ];
    }
}
