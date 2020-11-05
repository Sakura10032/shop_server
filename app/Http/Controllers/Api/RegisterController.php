<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\Site;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @param RegisterRequest $request
     * @param Site $site
     * @return JsonResponse
     */
    public function store(RegisterRequest $request, Site $site): JsonResponse
    {
        try {
            $site->mobile = $request->mobile;
            $site->name = $request->site_name;
            $site->reg_time = date("Y-m-d H:i:s");
            $site->try_time = date("Y-m-d H:i:s", strtotime("+15 day")); // 试用时间 15 天
            $site->reg_ip = $request->getHost();
            $site->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 403);
        }

        return response()->json([
            'message' => '注册成功！'
        ], 200);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
