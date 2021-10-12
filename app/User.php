<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /** @var int 学校管理员 */
    const ROLE_SCHOOL = 2;
    /** @var int 教师 */
    const ROLE_TEACHER = 3;
    /** @var int 学生 */
    const ROLE_STUDENT = 4;
    const ROLE_LIST = [
        self::ROLE_SCHOOL => '学校管理员',
        self::ROLE_TEACHER => '教师',
        self::ROLE_STUDENT => '学生',
    ];

    /** @var int 正常 */
    const ENABLE_TRUE = 1;
    /** @var int 禁用 */
    const ENABLE_FALSE = 2;
    const ENABLE_LIST = [
        self::ENABLE_TRUE => '正常',
        self::ENABLE_FALSE => '禁用',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'enable', 'role', 'pid', 'line_openid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function pidInfo()
    {
        return $this->belongsTo(User::class, 'pid');
    }
}
