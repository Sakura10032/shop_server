<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    // 站点模型

    protected $table = 'sites';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'name', 'mobile', 'name', 'status', 'initialize', 'base_id', 'theme_id', 'try_time', 'reg_time', 'reg_ip'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * 获取模型的路由键
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

}
