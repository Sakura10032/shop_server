<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\Site;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @param RegisterRequest $request
     * @param Site $site
     * @param User $user
     * @return JsonResponse
     */
    public function store(RegisterRequest $request, Site $site, User $user): JsonResponse
    {
        DB::beginTransaction();
        try {
            $uuid = Str::orderedUuid()->toString();
            $site->uuid = $uuid;
            $site->mobile = $request->mobile;
            $site->name = $request->site_name;
            $site->reg_time = date("Y-m-d H:i:s");
            $site->try_time = date("Y-m-d H:i:s", strtotime("+15 day")); // 试用时间 15 天
            $site->reg_ip = $request->getHost();
            $site->save();
            $user->site_id = $site->id;
            $user->account = $request->mobile;
            $user->pwd = bcrypt($request->pwd);
            $user->role = 2;
            $user->status = 1;
            $user->permission = '*';
            $user->reg_time = date("Y-m-d H:i:s");
            $user->login_ip = ''; // 默认 ip 为未登录
            $user->save();

            // 生成初始化注册码  时效 5 分钟
            if (!app()->environment('production')) {
                $key = 'shop.register-123456789';
                $expiredAt = now()->addMinutes(60);
            }else{
                $key = 'shop.register-'.Str::random(20);
                $expiredAt = now()->addMinutes(5);
            }
            Cache::put($key, ['site_id' => $uuid], $expiredAt);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 403);
        }

        return response()->json([
            'register_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ], 201);
    }

}
