<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatieRole;

class Permission extends SpatieRole
{
    use HasFactory;
}