<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Follows extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'follows';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'student_id', 'teacher_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function teacherInfo()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function studentInfo()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
