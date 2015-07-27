<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/3/2015
 * Time: 3:49 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Price_group extends Model
{

    public function getDataForPagination($dataRequest)
    {
        // Config sort
        $sortBy    = 'id';
        $sortOrder = 'asc';
        if (isset($dataRequest['sort'])) {
            $sort      = $dataRequest['sort'];
            $sortColum = ['id', 'name', 'root_price', 'price', 'sale_off'];
            $sortBy    = (in_array(key($sort), $sortColum)) ? key($sort) : 'id';
            $sortOrder = current($sort);
        }

        $query = $this
            ->where('name', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%');

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
                $aRow[$k] = $subData;
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