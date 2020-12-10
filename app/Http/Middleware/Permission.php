<?php

namespace App\Http\Middleware;

use App\Models\AdminRule;
use App\Models\Group;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Permission
{
    // 基础权限
    protected $baseRouter = [
        'admin/category/list',
        'admin/menu/index',
        'admin/procuratorate/list',
        'admin/category/list',
        'admin/appealCategory/list',
        'admin/version/show',
        'admin/group/list',
        'admin/home/index'
    ];
    protected $rules = [];

    //默认配置
    protected $config = array(
        'auth_on' => true,                      // 认证开关
        'auth_type' => 1,                         // 认证方式，1为实时认证；2为登录认证。
    );

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param String $param
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next, $param = '')
    {
        $response = $next($request);
        if (!Auth::user()) {
            throw new AuthenticationException('无 Token 值！');
        }
        $route = Route::currentRouteName();
        $name = str_replace(array($param.".v1.", '.'), array("", '/'), $route);
        $bool = $this->check($name, Auth::user());
        if (!$bool && !in_array($name, $this->baseRouter, true)) {
            return response(['message' => '您没有权限！'], 403);
        }
        return $response;
    }

    /**
     * 检查权限
     *
     * @param $name
     * @param $model
     * @param string $relation
     * @return bool
     */
    public function check($name, $model, $relation = 'or'): bool
    {
        if (!$this->config['auth_on']) return true;
        # 获取用户需要验证的所有有效规则列表
        $authList = $this->getAuthList($model);
        # 超级用户组直接通过
        if (isset($authList[0]) && $authList[0] === '*') {
            return true;
        }

        # 验证规则名称并进行格式化
        if (is_string($name)) {
            $name = strtolower($name);
            if (strpos($name, ',') !== false) {
                $name = explode(',', $name);
            } else {
                $name = array($name);
            }
        }
        $list = array(); //保存验证通过的规则名
        foreach ($authList as $auth) {
            $query = preg_replace('/^.+\?/U', '', $auth);
            if ($query == $auth) {
                parse_str($query, $param); //解析规则中的param
                $auth = preg_replace('/\?.*$/U', '', $auth);
                if (in_array($auth, $name, true)) {  //如果节点相符且url参数满足
                    $list[] = $auth;
                }
            } else if (in_array($auth, $name, true)) {
                $list[] = $auth;
            }
        }
        if ($relation === 'or' and !empty($list)) {
            return true;
        }
        $diff = array_diff($name, $list);
        if ($relation === 'and' and empty($diff)) {
            return true;
        }
        return false;
    }

    /**
     * 获得权限列表
     *
     * @param $model
     * @return array|mixed
     */
    protected function getAuthList($model)
    {
        static $_ruleList = []; //保存用户验证通过的权限列表
        if (isset($_ruleList[$model->id])) {
            return $_ruleList[$model->id];
        }

        //读取用户所属用户组
        $ids = $this->getRuleIds($model);
        if (empty($ids)) {
            $_ruleList[$model->id] = [];

            return [];
        }

        // 筛选条件
        $query = AdminRule::where('status', 1);
        if (!in_array('*', $ids, true)) {
            $query = $query->whereIn('id', $ids);
        }
        //读取用户组所有权限规则
        $this->rules = $query->get()->toArray();


        //循环规则，判断结果。
        $ruleList = []; //
        if (in_array('*', $ids, true)) {
            $ruleList[] = '*';
        }

        foreach ($this->rules as $rule) {
            //只要存在就记录
            $ruleList[$rule['id']] = strtolower($rule['app_name']) . '/' . strtolower($rule['name']);
        }

        $_ruleList[$model->id] = $ruleList;
        return array_unique($ruleList);
    }

    /**
     * 获取用户组的权限 ids
     *
     * @param $model
     * @return array
     */
    public function getRuleIds($model): array
    {
        //读取用户所属用户组
        $groups = Group::find($model->group_id)->toArray();
        $ids = []; //保存用户所属用户组设置的所有权限规则id
        $ids = array_merge($ids, explode(",", trim($groups['rules'], ',')));
        $ids = array_unique($ids);

        return $ids;
    }
}
