<?php

namespace App\Models;
use MongoDB\Laravel\Eloquent\Model;

class Task extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'tasks';

    protected $fillable = [
        'title', 'description', 'due_date', 'email', 'reminder_time'
    ];
}
