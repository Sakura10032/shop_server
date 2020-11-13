<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\InitRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class InitController extends Controller
{
    // 初始化类

    public function index(InitRequest $request)
    {
        $registerData = Cache::get($request->register_key);


        if (!$registerData) {
            abort(403, '初始化注册码无效，请联系管理员！');
        }

        // 启用事务
        DB::beginTransaction();
        dd($registerData);
    }
}
