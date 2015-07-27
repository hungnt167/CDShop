<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';
    protected $guarded = array('id', 'created_at', 'updated_at');
    protected $fillable = array('name');

    const HIDE = 0;
    const SHOW = 1;

    public function getDataForPagination($dataRequest)
    {
        // Config sort
        $sortBy    = 'id';
        $sortOrder = 'asc';
        if (isset($dataRequest['sort'])) {
            $sort      = $dataRequest['sort'];
            $sortColum = ['id', 'name'];
            $sortBy    = (in_array(key($sort), $sortColum)) ? key($sort) : 'id';
            $sortOrder = current($sort);
        }

        $query = $this->where(function () use ($dataRequest) {
            $this->where('name', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%');
        })->where('status',$this::SHOW);

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

    public function sideBar()
    {
        $types  = $this->get(['id', 'name'])->toArray();
        $result = '';
        foreach ($types as $type) {
            $result .= '<li><a href="';
            $result .= action('FrontendController@type', ['name' => $type['name'], 'id' => $type['id'], 'page' => 'start']);
            $result .= '">';
            $result .= $type['name'];
            $result .= '</a></li>';
        }
        return $result;
    }
}