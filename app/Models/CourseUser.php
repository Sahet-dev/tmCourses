<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseUser extends Pivot
{
    protected $table = 'course_user';

    protected $dates = ['enrolled_at', 'completed_at'];

    protected $fillable = ['course_id', 'user_id', 'enrolled_at', 'completed', 'completed_at'];
}
