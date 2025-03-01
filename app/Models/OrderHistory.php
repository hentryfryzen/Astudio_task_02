<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $table = 'order_history'; // Explicitly set the table name
    protected $fillable = ['order_id', 'status', 'changed_by'];
}
