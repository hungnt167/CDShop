<?php
function get_data($data, $field)
{
    $field_array = explode(',', $field);
    $temp = array();
    foreach ($field_array as $k => $v) {
        foreach ($data as $k2 => $v2) {
            if ($k2 == trim(strtolower($v))) {
                $temp[$k2] = $v2;
            }
        }
    }
    return $temp;
}

/**
 * This function auto assign property of model with value in array $_POST
 * @param $model
 * @param $data
 * $return $model
 */

function autoAssignDataToProperty($model, $data)
{
    $properties = $model->properties;
    foreach ($properties as $property) {
        foreach ($data as $key => $value) {
            if ($key == $property) {
                $model->$property = $data[$key];
            } else {

            }
        }
    }
    return $model;
}
function create_field_action($controller, $id) {
    return '<a href="'.asset($controller.'/'.$id.'/edit').'"><i class="glyphicon glyphicon-edit"></i></a>
            <a href="'.asset($controller.'/'.$id.'/del').'"><i class="glyphicon glyphicon-remove"></i></a>';
}
function del_action($controller, $id) {
    return '<a href="'.asset($controller.'/'.$id.'/del').'"><i class="glyphicon glyphicon-remove"></i></a>';
}
function create_field_image($src, $attr ='') {
    return '<img src="'.asset($src).'" '.$attr.'>';
}

function create_field_status($status) {
    $str = '<span class="label label-sm label-success">Approved</span>';
    if($status == 0){
        $str = '<span class="label label-sm label-warning">Pending</span>';
    }
    return $str;
}

function price_formate($price) {
    return number_format($price,0,",",".");
}

/**
 * dump variable and exit
 * @param $var
 */
function adump($var){
    echo "<pre>";
    var_dump ($var);
    echo "</pre>";exit;
}
    function formPaymentAddress(){
        $form='';
    }
?>