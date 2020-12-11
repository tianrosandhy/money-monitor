<?php

namespace App\Core\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use Permission;

class AdminAuth
{

    public function handle($request, Closure $next)
    {
        $user = admin_guard()->user();
        if($request->segment(1) == "login" || $request->segment(2) == "login")
            return $next($request);

        if($user){
            $role = app('role')->find($user->role_id);
            if(!empty($role)){
                $roles_bawahan = $this->getBawahanRole($role);

                if($role->is_sa){
                    //semuanya accessible
                    $accessible_role = app('role')->pluck('id')->toArray();
                }
                else{
                    $accessible_role = $roles_bawahan;
                }

                $request->attributes->add([
                    'user' => $user,
                    'role' => $role,
                    'current_role' => $role->id,
                    'is_sa' => $role->is_sa,
                    'base_permission' => json_decode($role->priviledge_list, true),
                    'subordinate_role' => $roles_bawahan,
                    'accessible_role' => $accessible_role,
                ]);


                //check if current user have access to current route
                $route_name = $request->route()->getName();
                if(!Permission::has($route_name)){
                    //forbidden access
                    abort(403);
                }

                return $next($request);
            }
            else{
                //artinya user dlm kondisi logged in, tapi role tidak ditemukan.
                //action : auto logout
                admin_guard()->logout();
            }
        }

        return Redirect()->intended($request->segment(1)."/login");
    }

    //iterate children id
    protected function getBawahanRole($role, $data=[]){
        $role = app('role')->find($role->id);
        $data[] = $role->id;
        if($role->children->count() > 0){
            foreach($role->children as $child){
                $data = $this->getBawahanRole($child, $data);
            }
        }
        return $data;
    }
}
