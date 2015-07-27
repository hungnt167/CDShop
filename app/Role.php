<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const SA_ROLE_ID = 1;
    const AD_ROLE_ID = 2;
    const CUS_ROLE_ID = 4;
    public function getDataForPagination($dataRequest){
        // Config sort
        $sortBy = 'id';
        $sortOrder = 'asc';
        if(isset($dataRequest['sort'])) {
            $sort = $dataRequest['sort'];
            $sortColum = ['id','name'];
            $sortBy = (in_array(key($sort), $sortColum)) ? key($sort) : 'id';
            $sortOrder = current($sort);
        }


        $query =$this
            ->where('name', 'LIKE', '%'.$dataRequest['searchPhrase'].'%');


        $queryGetTotal = $query;
        $total = $queryGetTotal->count();


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
        return ['total' => $total, 'rows' => $rows];
    }


}
