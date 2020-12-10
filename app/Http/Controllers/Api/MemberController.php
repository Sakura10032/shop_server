<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MemberRequest;
use App\Http\Resources\Api\MemberResource;
use App\Models\Member;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MemberController extends Controller
{
    // 成员类


    /**
     * 添加网站会员
     *
     * @param Member $member
     * @param MemberRequest $request
     * @return MemberResource|JsonResponse
     */
    public function store(Member $member, MemberRequest $request)
    {
        $data = $request->all();
        $data['pwd'] = bcrypt($data['pwd']);
        $data['site_id'] = $request->auth['site_id'] ?: 1;
        $data['reg_ip'] = $request->getClientIp();
        try {
            $member->fill($data);
            $member->save();

            return new MemberResource($member);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 403);
        }
    }


    /**
     * 网站会员列表
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $members = QueryBuilder::for(Member::class)
            ->allowedFields(['id', 'name', 'email', 'gender', 'mobile', 'company', 'contact_way', 'status', 'reg_time', 'login_time', 'login_ip', 'site_id', 'site.id', 'site.uuid', 'site.name'])
            ->allowedIncludes('site')
            ->allowedFilters([
                'email',
                AllowedFilter::exact('mobile'),
            ])
            ->paginate(15);

        return MemberResource::collection($members);
    }


    /**
     * 网站会员详情
     *
     * @param $memberId
     * @return MemberResource
     */
    public function show($memberId)
    {
        $member = QueryBuilder::for(Member::class)
            ->allowedFields('site_id', 'site.id', 'site.uuid', 'site.name')
            ->allowedIncludes('site')
            ->findOrFail($memberId);

        return new MemberResource($member);
    }


    /**
     * 更新网址会员信息
     *
     * @param MemberRequest $request
     * @param Member $member
     * @return MemberResource
     */
    public function update(MemberRequest $request,Member $member): MemberResource
    {
        $member = $member->find($request->id);
        if ($request->pwd !== '') {
            $request->merge(['pwd' => bcrypt($request->pwd)]);
        }
        $member->update($request->all());
        return new MemberResource($member);
    }


    /**
     * 删除网站会员信息
     *
     * @param Member $member
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function destroy(Member $member, $id)
    {
        $member->destroy($id);

        return response(null, 204);
    }
}
