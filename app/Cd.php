<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/3/2015
 * Time: 3:49 PM
 */

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Cd extends Model
{
    const ACTIVE = 1;
    const IN_ACTIVE = 0;
    protected $guarded = ['id'];
    public $properties
        = [
            'root_price', 'name', 'singer_id', 'composer_id', 'portal', 'format_id', 'public_date',
            'description', 'quantity', 'group_price_id', 'type_id', 'status', 'price', 'sale_off'
        ];
    protected $fillable=[
        'root_price', 'name', 'singer_id', 'composer_id', 'portal', 'format_id', 'public_date',
        'description', 'quantity', 'group_price_id', 'type_id', 'status','buy_time', 'price', 'sale_off,created_at'
    ];
    public static $columnForPage
        = ['cds.id', 'cds.name', 'singer_id', 'composer_id', 'artists.name as singer',
            'cds.status', 'format_id', 'type_id', 'quantity', 'public_date', 'portal', 'buy_time',
            'cds.price', 'cds.sale_off', 'cds.group_price_id',
            'price_groups.price as price_group', 'price_groups.sale_off as sale_off_group',];

    public function priceGroup()
    {
        return $this->hasOne('App\Price_group', 'id', 'group_price_id');
    }


    public function singer()
    {
        return $this->hasOne('App\Artist', 'id', 'singer_id');
    }

    public function composer()
    {
        return $this->hasOne('App\Artist', 'id', 'composer_id');
    }

    public function type()
    {
        return $this->hasOne('App\Type', 'id', 'type_id');
    }

    public function format()
    {
        return $this->hasOne('App\Format_cd', 'id', 'format_id');
    }


    //get new products in home page
    public function getNewProduct($offset, $limit)
    {

        $models = DB::table('cds')
            ->where('cds.status', $this::ACTIVE)
            ->orderBy('public_date', 'des')
            ->skip($offset)
            ->take($limit)
            ->get(['cds.id']);
        $cds    = [];
        foreach ($models as $k => $model) {
            $cds[] = json_decode($this->getDataAProduct($model->id, $this::$columnForPage));
        }

        return [
            'count' => $this->where('status', $this::ACTIVE)->count(),
            'cds' => $cds
        ];
    }

    //get products in music kingdom page
    public function getBestSellerProduct($offset, $limit)
    {
        $models = DB::table('cds')
            ->where('cds.status', $this::ACTIVE)
            ->orderBy('buy_time', 'des')
            ->skip($offset)
            ->take($limit)
            ->get(['cds.id']);
        $cds    = [];
        foreach ($models as $k => $model) {
            $cds[] = json_decode($this->getDataAProduct($model->id, $this::$columnForPage));
        }
        return [
            'count' => $this->where('status', $this::ACTIVE)->count(),
            'cds' => $cds
        ];

    }

    public function getProductByType($id, $offset, $limit)
    {
        $orderOption = $this->filter();
        $models      = DB::table('cds')
            ->leftJoin('price_groups', 'cds.group_price_id', '=', 'price_groups.id')
            ->where('cds.status', $this::ACTIVE)
            ->where('cds.type_id', $id)
            ->orderBy($orderOption['sort'], $orderOption['sortType'])
            ->skip($offset)
            ->take($limit)
            ->get(['cds.id']);
        $cds         = [];
        foreach ($models as $k => $model) {
            $cds[] = json_decode($this->getDataAProduct($model->id, $this::$columnForPage));
        }
        return [
            'count' => $this->where('type_id', $id)->where('status', $this::ACTIVE)->count(),
            'cds' => $cds
        ];


    }

    public function getProductByFormat($id, $offset, $limit)
    {
        $orderOption = $this->filter();
        $models      = DB::table('cds')
            ->leftJoin('price_groups', 'cds.group_price_id', '=', 'price_groups.id')
            ->where('cds.status', $this::ACTIVE)
            ->where('format_id', $id)
            ->orderBy($orderOption['sort'], $orderOption['sortType'])
            ->skip($offset)
            ->take($limit)
            ->get(['cds.id']);
        $cds         = [];
        foreach ($models as $k => $model) {
            $cds[] = json_decode($this->getDataAProduct($model->id, $this::$columnForPage));
        }
        return [
            'count' => $this->where('format_id', $id)->where('status', $this::ACTIVE)->count(),
            'cds' => $cds
        ];
    }

    public function allProduct($offset, $limit)
    {
        if (($this->where('status', $this::ACTIVE)->count()) > 0) {

            $orderOption = $this->filter();
            $models      = DB::table('cds')
                ->leftJoin('price_groups', 'cds.group_price_id', '=', 'price_groups.id')
                ->where('cds.status', $this::ACTIVE)
                ->orderBy($orderOption['sort'], $orderOption['sortType'])
                ->skip($offset)
                ->take($limit)
                ->get(['cds.id']);

            $cds = [];
//            dd($models);
            foreach ($models as $k => $model) {
                $cds[] = json_decode($this->getDataAProduct($model->id, $this::$columnForPage));
            }
            return [
                'count' => $this->where('status', $this::ACTIVE)->count(),
                'cds' => $cds
            ];
        } else {
            return [];
        }
    }

    private function filter()
    {
        $sortType = 'asc';
        $sort     = 'id';
        $filter   = session('filter');
        if (isset($filter['price']) && $filter['price']) {
            $sort     = 'cds.price';
            $sortType = 'des';
        }
        if (isset($filter['public_date']) && $filter['public_date']) {
            $sort     = 'public_date';
            $sortType = 'des';
        }
        if (isset($filter['name']) && $filter['name']) {
            $sort     = 'cds.name';
            $sortType = 'des';
        }
        return ['sort' => $sort, 'sortType' => $sortType];
    }


    public function getDataAProduct($id, $column)
    {
        $models              = DB::table('cds')
            ->join('artists', 'cds.singer_id', '=', 'artists.id')
            ->join('format_cds', 'cds.format_id', '=', 'format_cds.id')
            ->join('types', 'cds.type_id', '=', 'types.id')
            ->leftJoin('price_groups', 'cds.group_price_id', '=', 'price_groups.id')
            ->where('cds.id', $id)
            ->select($column)
            ->first();
        $composer            = Artist::find($models->composer_id)->first();
        $models->composer_id = $composer->id;
        $models->composer    = $composer->name;
        if ($models->price <= 0) {
            $models->price    = $models->price_group;
            $models->sale_off = $models->sale_off_group;

        }
        return json_encode($models);
    }


    public function getDataForPagination($dataRequest)
    {
        // Config sort
        $sortBy    = 'id';
        $sortOrder = 'asc';
        $column    = [
            'cds.id', 'cds.name', 'singer_id', 'composer_id', 'artists.name as singer',
            'cds.status', 'format_id', 'type_id', 'quantity', 'public_date', 'portal', 'cds.description',
            'cds.root_price', 'cds.price', 'cds.sale_off', 'cds.group_price_id',
            'price_groups.price as price_group', 'price_groups.sale_off as sale_off_group',
            'price_groups.id as price_g_id', 'price_groups.root_price as price_group_root_price'
        ];
        if (isset($dataRequest['sort'])) {
            $sort      = $dataRequest['sort'];
            $sortColum = ['id', 'name'];
            $sortBy    = (in_array(key($sort), $sortColum)) ? key($sort) : 'id';
            $sortOrder = current($sort);
        }


        $query = $this
            ->with('singer')
            ->with('composer')
            ->with('priceGroup')
            ->with('type')
            ->with('format')
            ->where('name', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%')
            ->orWhere('description', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%');


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
            $isPG = false;
            foreach ($aData as $k => $subData) {
                if (is_array($subData) && !empty($subData)) {
                    if ($k == 'singer') {
                        $aRow['singer'] = $subData['name'];
                    } elseif ($k == 'composer') {
                        $aRow['composer'] = $subData['name'];
                    } elseif ($k == 'price_group') {
                        $isPG                = true;
                        $aRow['price_group'] = $subData;
                    }
                } elseif ($k != 'description') {
                    //status
                    if ($k == 'status') {
                        if ($subData == 1) {
                            $aRow['status'] = 'Visible';
                        } else {
                            $aRow['status'] = 'Hide';
                        }
                    } else {
                        $aRow[$k] = $subData;
                    }
                }
            }
            if ($isPG) {
                $aRow['root_price'] = $aRow['price_group']['root_price'];
                $aRow['price']      = $aRow['price_group']['price'];
                $aRow['sale_off']   = $aRow['price_group']['sale_off'];
            }

            //cost=root+root*rate-root*sale
            $aRow['cost'] = $aRow['price'] + ($aRow['price'] * $aRow['sale_off'] * 0.01);
            $rowsData[]   = $aRow;
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