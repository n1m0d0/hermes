<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    const Active = 1;
    const Inactive = 2;
    const Processing = 3;
    const Finalized = 4;

    const Shipping = 1;
    const Order = 2;
}
