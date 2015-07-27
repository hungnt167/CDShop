<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Session;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $guarded = ['id'];
    protected $table = 'users';
    public $properties = array('name', 'password', 'email', 'phone', 'avatar', 'status', 'role_id', 'key_active',
        'remember_token', 'created_at', 'updated_at');
    public $timestamps = false;
    const ACTIVED_STATUS = 1;
    const IN_ACTIVED_STATUS = 0;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'password', 'email', 'phone', 'avatar', 'status', 'role_id', 'key_active',
        'remember_token', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
//    protected $hidden = ['password', 'remember_token'];
    public function role()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    public function getDataForPagination($dataRequest)
    {
        // Config sort
        $sortBy    = 'id';
        $sortOrder = 'asc';
        if (isset($dataRequest['sort'])) {
            $sort      = $dataRequest['sort'];
            $sortColum = ['id', 'name', 'password', 'email', 'phone', 'avatar', 'status', 'role_id'];
            $sortBy    = (in_array(key($sort), $sortColum)) ? key($sort) : 'id';
            $sortOrder = current($sort);
        }

        $searchRole  = Role::AD_ROLE_ID;
        $searchRole  = Session::get('role_filter');
        $query = $this->where(function () use ($dataRequest) {
            $this->where('name', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%')
                ->orWhere('emaiil', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%')
                ->orWhere('phone', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%')
                ->orWhere('avatar', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%')
                ->orWhere('status', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%');
        })->with('role')
            ->where('role_id', '!=', Role::SA_ROLE_ID)
            ->where('role_id',$searchRole);


        $queryGetTotal = $query;
        $total         = $queryGetTotal->count();


        if (intval($dataRequest['rowCount']) == -1) {
            $data = $query->orderBy($sortBy, $sortOrder)
                ->get()->toArray();
        } else {
            $data = $query->orderBy($sortBy, $sortOrder)
                ->skip($dataRequest['rowCount'] * ($dataRequest['current'] - 1))
                ->take($dataRequest['rowCount'])
                ->get()->toArray();
        }
            $rowsData = [];
            foreach ($data as $aData) {

                $aRow = [];
                foreach ($aData as $k => $subData) {
                    if (is_array($subData)) {
                        $aRow['role'] = $subData['name'];
                    } else {
                        $aRow[$k] = $subData;
                    }
                }
                $rowsData[] = $aRow;
            }
        $result             = [];
        $result['current']  = intval($dataRequest['current']);
        $result['rowCount'] = intval($dataRequest['rowCount']);
        $result['_token']   = csrf_token();
        $result['total']    = intval($total);
        $result['rows']     = ($rowsData);
        return $result;
    }
}
