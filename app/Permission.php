<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class Permission extends Model
{
    public function getDataForPagination($dataRequest, $config)
    {

        //Update path
        //get all route
        $routes = Route::getRoutes();
        $arr_routes = [];
        $allRoutes=[];
        //put route into array
        foreach ($routes as $value) {
            $path = $value->getPath();
            //check all route is of backend
            if (preg_match('/^admin/', $path)) {
                $allRoutes[] = $path;

            }
        }
        //delete all old
//        $this->truncate();
        //foreach  add new permission
        $arr_routes = array_unique($allRoutes);
        foreach ($arr_routes as $route) {
            //check existed ?
            $count=$this->where('name','1|'.$route)->count();
            if($count==0){
                $new = new Permission();
                $new->name = '1|' . $route;
                $new->save();
            }

        }
        // check Role differ SA(1)
        $roles = Role::where('id', '!=', 1)->get(['id'])->toArray();
        $listRole = [];
        foreach ($roles as $role) {
            $listRole[] = $role['id'];
        }
        // Config sort
        $sortBy = 'id';
        $sortOrder = 'asc';
        if (isset($dataRequest['sort'])) {
            $sort = $dataRequest['sort'];
            $sortColum = ['id', 'name'];
            $sortBy = (in_array(key($sort), $sortColum)) ? key($sort) : 'id';
            $sortOrder = current($sort);
        }
        //check if user choice all then no orderby
        if (intval($dataRequest['rowCount']) == -1) {
            $permission = $this->where('name', 'like', '1|%')
                ->get(['id', 'name'])->toArray();
        } else {
            $permission = $this->where('name', 'like', '1|%')
                ->skip($config['offset'])
                ->take($config['limit'])
                ->get(['id', 'name'])->toArray();
        }//end

        $permissions = [];
        $listPermission = [];
        //get Data role
        foreach ($listRole as $roleID) {
            $listPermission[] = $this->where('name', 'like', $roleID . '|%')->get(['id', 'name'])->toArray();
        }
        //put permission into array
        foreach ($listPermission as $value) {
            foreach ($value as $subvalue) {
                $permissions[] = [$subvalue['id'], $subvalue['name']];
            }
        }


        $permission_key = array();
        $permission_name = array();
        $permission_uri = array();

        $permissionListUri = [];
        foreach ($listRole as $k => $role) {
            $permissionListUri[] = [];
        }

        $arrayPermission = [];
        for ($i = 0; $i < sizeof($listPermission); $i++) {
            $tmp = [];
            foreach ($listPermission[$i] as $per) {
                $tmp[] = substr($per['name'], 2);
            }
            $arrayPermission[] = $tmp;
        }
        foreach ($permission as $per) {
            $permission_uri[] = substr($per['name'], 2);
            $permission_name[] = $per['name'];
            $permission_key[] = $per['id'];
        }
        $num_uri = sizeof($permission_uri);
        for ($i = 0; $i < $num_uri; $i++) {
            for ($j = 0; $j < sizeof($arrayPermission); $j++) {
                $ck = false;
                foreach ($listRole as $k => $department) {
                    if ($j == $k) {
                        $col = $department;
                    }
                }
                $ic = '<input col=' . $col . ' data=' . $permission_uri[$i] . ' type=checkbox>';
                for ($m = 0; $m < sizeof($arrayPermission[$j]); $m++) {
                    if (strcmp($arrayPermission[$j][$m], $permission_uri[$i]) == 0) {
                        $ck = true;
                    }
                }
                if ($ck) {
                    $ic = '<input col=' . $col . ' data=' . $permission_uri[$i] . ' checked type=checkbox>';
                }
                $permissionListUri[$j][] = $ic;
            }
        }

        $rows = [];
        for ($i = 0; $i < $num_uri; $i++) {
            $rows[] = [
                'id' => $permission_key[$i],
                'name' => $permission_uri[$i],

            ];
            foreach ($listRole as $k => $role) {
                $rows[$i][$listRole[$k]] = $permissionListUri[$k][$i];
            }
        }
        $total = $permission = $this->where('name', 'like', '1|%')->count();
        return ['total' => $total, 'rows' => $rows];
    }
}
