<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\InitRequest;
use App\Models\BaseSetting;
use App\Models\Site;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class InitController extends Controller
{
    // 初始化类

    public function index(InitRequest $request, BaseSetting $baseSetting, Site $site)
    {
        $registerData = Cache::get($request->register_key);

        if (!$registerData) {
            abort(403, '初始化注册码无效，请联系管理员！');
        }

        $site = $site->where('uuid',$registerData['site_id'])->first();
        if ($site->initialize === 1) {
            abort(403, '请勿重复初始化！');
        }

        // 启用事务
        DB::beginTransaction();
        try {
            $baseSetting->site_id = $site->id;
            $baseSetting->logo = '11'; // 默认初始化logo地址
            $baseSetting->ico = '11'; // 默认初始化ico地址
            $baseSetting->search_message = '请输入产品名称~'; // 产品搜索提示语
            $baseSetting->copyright = '朗正集成信息科技（南京）有限公司'; // 版权信息
            $baseSetting->bolg_copyright = '朗正集成信息科技（南京）有限公司'; // 博客版权信息
            $baseSetting->company = '朗正集成信息科技（南京）有限公司'; // 公司名称
            $baseSetting->save();
            $site->initialize = 1;
            $site->base_id = $baseSetting->id;
            $site->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 403);
        }

        return response()->json([
            'message' => '初始化成功！'
        ], 201);

    }
}
