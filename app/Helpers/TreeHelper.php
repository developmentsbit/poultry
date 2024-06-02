<?php

namespace App\Helpers;

use App\Models\generation;
use App\Models\member_info;

class TreeHelper
{

    public $level;
    public $childrens = '';
    private $current_level = 0;
    private $gen_enter = false;
    private $gen1_enter = 0;
    private $gen2_enter = 0;
    private $gen3_enter = 0;

    public function __construct($level = 1)
    {
        $this->level = $level;
    }


    public function childs($gen)
    {

        $this->current_level++;

        $parent = $this->get_member_info($gen->member_id);

        $this->childrens .= '<div class="col">
        <div class="card mb-0"><span class="square-card rounded-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="<b>' . $parent->name . '</b><br><b>' . $parent->member_id . '</b>">Parent</span>
        ' . $parent->name . '
        </div> 
    </div>';

        $left_member = $this->get_member_info(@$gen->left ?? '');
        $left_route = @$left_member->id ? route('member.show', @$left_member->id ?? 0) : '#';
        $left = '<div class="col">
            <div class="card mb-0"><a href="' . $left_route . '"><span class="square-card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="<b>' . (@$left_member->name ?? 'empty') . '</b><br><b>' . (@$gen->left ?? 'empty') . '</b>">L1</span></a>
            ' . (@$left_member->name ?? 'empty') . '
            </div> 
            <hr>
            <div class="row justify-content-around">
            ' . $this->gen($gen->left) . '
            </div>
        </div>';

        $right_member = $this->get_member_info(@$gen->right ?? '');
        $right_route = @$right_member->id ? route('member.show', @$right_member->id ?? 0) : '#';
        $right = '<div class="col">
            <div class="card mb-0"><a href="' . $right_route . '"><span class="square-card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="<b>' . (@$right_member->name ?? 'empty') . '</b><br><b>' . (@$gen->right ?? 'empty') . '</b>">R1</span></a>
            ' . (@$right_member->name ?? 'empty') . '
            </div> 
            <hr>
            <div class="row justify-content-around">
            ' . $this->gen($gen->right) . '
            </div>
        </div>';

        $this->childrens .= '<div class="row justify-content-around">' . $left . $right . '</div>';

        return $this->childrens;
    }

    public function gen($parent)
    {
        if (!$this->gen_enter) {
            $side = 'L';
            $level = 2;
            $this->gen_enter = true;
        } else {
            $side = 'R';
            $level = 2;
        }

        $gen = generation::query()->where('member_id', $parent)->first();
        $left_member = $this->get_member_info(@$gen->left ?? '');
        $left_route = @$left_member->id ? route('member.show', @$left_member->id ?? 0) : '#';
        $right_member = $this->get_member_info(@$gen->right ?? '');
        $right_route = @$right_member->id ? route('member.show', @$right_member->id ?? 0) : '#';
        return '<div class="col">
        <div class="card mb-0"><a href="' . $left_route . '"><span class="square-card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-html="true" data-bs-title="<b>' . (@$left_member->name ?? 'empty') . '</b><br>' . (@$gen->left ?? 'empty') . '">' . $side . $level++ . '</span></a>
        ' . (@$left_member->name ?? 'empty') . '
        </div>
        <hr>
        <div class="row justify-content-around">
        ' . $this->gen2(@$gen->left) . '
        </div>
    </div>
    <div class="col">
        <div class="card mb-0"><a href="' . $right_route . '"><span class="square-card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-html="true" data-bs-title="<b>' . (@$right_member->name ?? 'empty') . '</b><br>' . (@$gen->right ?? 'empty') . '">' . $side . $level++ . '</span></a>
        ' . (@$right_member->name ?? 'empty') . '
        </div>
        <hr>
        <div class="row justify-content-around">
        ' . $this->gen2(@$gen->right) . '
        </div>
    </div>';
    }

    public function gen2($parent)
    {
        if ($this->gen1_enter == 0) {
            $side = 'L';
            $level = 4;
            $this->gen1_enter++;
        } elseif ($this->gen1_enter == 1) {
            $side = 'L';
            $level = 6;
            $this->gen1_enter++;
        } elseif ($this->gen1_enter == 2) {
            $side = 'R';
            $level = 4;
            $this->gen1_enter++;
        } elseif ($this->gen1_enter == 3) {
            $side = 'R';
            $level = 6;
            $this->gen1_enter++;
        }

        $gen = generation::query()->where('member_id', $parent)->first();
        $left_member = $this->get_member_info(@$gen->left ?? '');
        $left_route = @$left_member->id ? route('member.show', @$left_member->id ?? 0) : '#';
        $right_member = $this->get_member_info(@$gen->right ?? '');
        $right_route = @$right_member->id ? route('member.show', @$right_member->id ?? 0) : '#';
        return '<div class="col">
        <div class="card mb-0"><a href="' . $left_route . '"><span class="square-card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-html="true" data-bs-title="<b>' . (@$left_member->name ?? 'empty') . '</b><br>' . (@$gen->left ?? 'empty') . '">' . $side . $level++ . '</span></a>
        ' . (@$left_member->name ?? 'empty') . '
        </div>
        <hr>
        <div class="row justify-content-around">
        ' . $this->gen3(@$gen->left) . '
        </div>
    </div>
    <div class="col">
        <div class="card mb-0"><a href="' . $right_route . '"><span class="square-card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-html="true" data-bs-title="<b>' . (@$right_member->name ?? 'empty') . '</b><br>' . (@$gen->right ?? 'empty') . ' ">' . $side . $level++ . '</span></a>
        ' . (@$right_member->name ?? 'empty') . '
        </div>
        <hr>
        <div class="row justify-content-around">
        ' . $this->gen3(@$gen->right) . '
        </div>
    </div>';
    }

    public function gen3($parent)
    {
        if ($this->gen2_enter == 0) {
            $side = 'L';
            $level = 8;
            $this->gen2_enter++;
        } elseif ($this->gen2_enter == 1) {
            $side = 'L';
            $level = 10;
            $this->gen2_enter++;
        } elseif ($this->gen2_enter == 2) {
            $side = 'L';
            $level = 12;
            $this->gen2_enter++;
        } elseif ($this->gen2_enter == 3) {
            $side = 'L';
            $level = 14;
            $this->gen2_enter++;
        } elseif ($this->gen2_enter == 4) {
            $side = 'R';
            $level = 8;
            $this->gen2_enter++;
        } elseif ($this->gen2_enter == 5) {
            $side = 'R';
            $level = 10;
            $this->gen2_enter++;
        } elseif ($this->gen2_enter == 6) {
            $side = 'R';
            $level = 12;
            $this->gen2_enter++;
        } elseif ($this->gen2_enter == 7) {
            $side = 'R';
            $level = 14;
            $this->gen2_enter++;
        }

        $gen = generation::query()->where('member_id', $parent)->first();

        $left_member = $this->get_member_info(@$gen->left ?? '');
        $left_route = @$left_member->id ? route('member.show', @$left_member->id ?? 0) : '#';
        $right_member = $this->get_member_info(@$gen->right ?? '');
        $right_route = @$right_member->id ? route('member.show', @$right_member->id ?? 0) : '#';
        return '<div class="col">
        <div class="card mb-0"><a href="' . $left_route . '"><span class="square-card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-html="true" data-bs-title="<b>' . (@$left_member->name ?? 'empty') . '</b><br>' . (@$gen->left ?? 'empty') . ' ">' . $side . $level++ . '</span></a>
        ' . (@$left_member->name ?? 'empty') . '
        </div>
    </div>
    <div class="col">
        <div class="card mb-0"><a href="' . $right_route . '"><span class="square-card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-html="true" data-bs-title="<b>' . (@$right_member->name ?? 'empty') . '</b><br>' . (@$gen->left ?? 'empty') . ' ">' . $side . $level++ . '</span></a>
        ' . (@$right_member->name ?? 'empty') . '
        </div>
    </div>';

    }

    public function get_member_info(string $member_id)
    {
        $member = member_info::query()->where('member_id', $member_id)->first();
        return @$member ?? 'empty';
    }


}