<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * 后台 用户列表
     * @param User $user
     * @return Application|ResponseFactory|Response
     */
    public function index(User $user)
    {
        $ids = ProcuratorateController::getAllPId();
        $size = request()->get('size', 20);
        $name = request()->get('name', '');
        $info = $user
            ->from('admins as a')
            ->leftJoin('procuratorates as p', 'a.procuratorate_id', '=', 'p.id')
            ->select('a.id', 'a.username', 'a.procuratorate_id', 'a.group_id', 'a.status', 'a.sort', 'p.name')
            ->whereIn('a.procuratorate_id', $ids);
        if ($name) {
            $info = $info->where('a.username', 'like', '%' . $name . '%');
        }
        $info = $info->orderBy('a.sort', 'asc')
            ->orderBy('a.created_at', 'desc')
            ->paginate($size);
        return response($info, 200);
    }

    /**
     * 新增管理员
     *
     * @param UserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function store(UserRequest $request, User $user): UserResource
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user->fill($data);
        $user->save();
        return new UserResource($user);
    }


    /**
     * 删除管理员
     *
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function destroy($id)
    {
        if ($id === 1) {
            return response(['message' => '您没有权限！'], 403);
        }

        $uid = Auth::id();
        if($id === $uid){
            return response(['message' => '不可自己删除自己！'], 403);
        }
        User::destroy($id);
        return response(null, 204);
    }


    /**
     * 修改管理员
     *
     * @param UserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UserRequest $request, User $user): UserResource
    {

        if ($request->password === '') {
            unset($request['password']);
        } else {
            $request->merge(['password' => bcrypt($request->password)]);
        }
        $user->update($request->all());
        return new UserResource($user);
    }

    public function getUserInfo()
    {

        $data = [
            'roles' => ['admin'],
            'introduction' => '超级管理员',
            'avatar' => 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
            'name' => Auth::user()['username'],
            'procuratorate_id' => Auth::user()['procuratorate_id'],
        ];
        return response($data, 200);
    }

    /**
     * 改变 账号状态
     * @param User $user
     * @return Application|ResponseFactory|Response
     */
    public function changeStatus(User $user)
    {
        $id = request()->get('id');
        $status = request()->get('status');
        if ($id === 1) {
            return response(null, 200);
        }
        $user->where('id', $id)->update(['status' => $status]);
        return response(null, 200);
    }
}
