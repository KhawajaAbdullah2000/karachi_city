<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Student extends Authenticatable
{
    protected $fillable=[
        'first_name',
        'email',
        'last_name',
        'DOB',
        'password',
        'gender',
        'branch',
        'phone',
        'emergency_name',
        'emergency_contact',
        'medical',
        'branch_id',
        'school',
        'parent_email',
        'parent_phone',
    ];
    use HasFactory;
}
