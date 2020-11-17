<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MemberRequest;
use App\Http\Resources\Api\MemberResource;
use App\Models\Member;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class MemberController extends Controller
{
    // 成员类


    /**
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
     * @param MemberRequest $request
     * @param Member $member
     * @return AnonymousResourceCollection
     */
    public function index(MemberRequest $request, Member $member)
    {
        $members = QueryBuilder::for(Member::class)
            ->allowedFilters([
                'email',
                AllowedFilter::exact('mobile'),
            ])
            ->allowedFields(['id', 'name', 'email', 'gender', 'mobile', 'company', 'contact_way', 'status', 'reg_time', 'login_time', 'login_ip'])
            ->paginate(2);

        return MemberResource::collection($members);
    }
}
