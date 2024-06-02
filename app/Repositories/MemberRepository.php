<?php


namespace App\Repositories;

use App\Interfaces\MemberInterface;
use App\Models\member_info;


class MemberRepository extends BaseRepository implements MemberInterface
{
    protected $model;

    public function __construct(member_info $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }
}