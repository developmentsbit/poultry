<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class internal_loan_provide extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];
}
