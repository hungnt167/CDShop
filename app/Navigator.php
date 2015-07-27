<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/3/2015
 * Time: 3:49 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Navigator extends Model
{
    protected $guarded = ['id'];
    protected $table = 'Navigators';
    public $properties = array('id', 'name', 'uri', 'parent_id', 'position', 'level', 'status', 'in_page','created_at', 'updated_at');
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'uri', 'parent_id', 'position', 'level', 'status'];

    public function listNavigator($option)
    {
        $cate           = array();
        $cate_root_name = array();
        $cate_lv1_name  = array();
        $cate_lv2_name  = array();
        $cate_lv3_name  = array();
        $cate_root      = array();
        $cate_lv1       = array();
        $cate_lv2       = array();
        $cate_lv3       = array();

        //check optional and get all Navigator
        if ($option == 'BE') {
            $listCategory = (Navigator::where('status', 1)
                ->where('in_page', 1)->orderBy('position', 'asc')
                ->get(['id', 'uri', 'name', 'parent_id', 'level'])
                ->toArray()
            );
        } elseif ($option == 'FE') {
            $listCategory = (Navigator::where('status', 1)
                ->where('in_page', 0)->orderBy('position', 'asc')
                ->get(['id', 'uri', 'name', 'parent_id', 'level'])
                ->toArray()
            );
        }//end check optional and get all Navigator

        //put into array
        for ($i = 0; $i < sizeof($listCategory); $i++) {
            if ($listCategory[$i]['level'] == 0) {
                array_push($cate_root, $listCategory[$i]);
            } elseif ($listCategory[$i]['level'] == 1) {
                array_push($cate_lv1, $listCategory[$i]);
            } elseif ($listCategory[$i]['level'] == 2) {
                array_push($cate_lv2, $listCategory[$i]);
            } elseif ($listCategory[$i]['level'] == 3) {
                array_push($cate_lv3, $listCategory[$i]);
            }
        }

        //loop amount root tag time
        for ($i = 0; $i < sizeof($cate_root); $i++) {

            //declare template array
            $_tmp = array();

            //put a name into array name root
            array_push($cate_root_name, $cate_root[$i]['name']);
            for ($j = 0; $j < sizeof($cate_lv1); $j++) {

                //declare template array
                $__tmp = array();

                //put a name into array name Navigator level1
                array_push($cate_lv1_name, $cate_lv1[$j]['name']);

                //check parent id of Navigator level1 is current  id of root id
                if ($cate_lv1[$j]['parent_id'] == $cate_root[$i]['id']) {
                    for ($m = 0; $m < sizeof($cate_lv2); $m++) {

                        //declare template array
                        $___tmp = array();

                        //put a name into array name Navigator level2
                        array_push($cate_lv2_name, $cate_lv2[$m]['name']);

                        //check parent id of Navigator level2 is current  id of Navigator level1 id
                        if ($cate_lv2[$m]['parent_id'] == $cate_lv1[$j]['id']) {
                            for ($n = 0; $n < sizeof($cate_lv3); $n++) {

                                //put a name into array name Navigator level3
                                array_push($cate_lv3_name, $cate_lv3[$n]['name']);

                                //check parent id of Navigator level3 is current  id of Navigator level2 id
                                if ($cate_lv3[$n]['parent_id'] == $cate_lv2[$m]['id']) {
                                    $___tmp = array_add($___tmp, $n, $cate_lv3[$n]);
                                }//end check parent id of Navigator level3 is current  id of Navigator level2 id
                            }
                            //check Navigator level1 has child
                            if (sizeof($___tmp) == 0) {
                                $__tmp = array_add($__tmp, $m, $cate_lv2[$m]);
                            } else {
                                $__tmp = array_add($__tmp, $m, $___tmp);
                            }//end check Navigator level1 has child
                        }//end check parent id of Navigator level2 is current  id of Navigator level1 id
                    }
                    //check root has child
                    if (emptyArray($__tmp)) {
                        $_tmp = array_add($_tmp, $cate_lv1_name[$j], $cate_lv1[$j]);
                    } else {
                        $_tmp = array_add($_tmp, $cate_lv1_name[$j], $__tmp);
                    }//end check root has child
                }//check parent id of Navigator level1 is current  id of root id
            }
            //add each element
            $cate = array_add($cate, $cate_root_name[$i], $_tmp);
        }

        return $cate;
    }

    public function sideBarBE($cate)
    {
        $result = '';
        //name root tag is index of array
        foreach ($cate as $nameRoot => $aCate) {
            // get data current Root
            $root = $this->where('name', $nameRoot)->where('in_page', 1)->first()->toArray();
            $result .= '<li>';
            if ($root['uri'] == '') {
                $result .= '<a href="#';
            } else {
                $result .= '<a href="' . url() . $root['uri'];
            }
            //get array child(1) of current root tag
            $arrKeysLv1 = array_keys($cate[($nameRoot)]);
            //check has child(1)
            if (sizeof($arrKeysLv1) > 0) {
                //true , print data
                $result .= '">';
                $result .= '<span class="fa arrow"></span>' . $nameRoot . '</a>';
                //End current root tag
                $result .= '<ul class="nav nav-first-level">  ';
                $result .= '<li>';
                //foreach child(1)
                foreach ($arrKeysLv1 as $nodeI) {
                    $node     = $this->where('name', $nodeI)->where('in_page', 1)->first()->toArray();
                    $subNodeI = $this->where('parent_id', $node['id'])->where('in_page', 1)->get(['id', 'name', 'uri'])->toArray();
                    if (sizeof($subNodeI) > 0) {
                        $result .= '<li>';
                        if ($node['uri'] == '') {
                            $result .= '<a href="#';
                        } else {
                            $result .= '<a href="' . url() . $node['uri'];
                        }
                        $result .= '">';
                        $result .= '<span class="fa arrow"></span>' . $node['name'] . '</a>';
                        //End child(1)
                        $result .= '<ul class="nav nav-second-level">  ';
                        //foreach child(2)
                        foreach ($subNodeI as $node) {
                            $subNodeII = $this->where('parent_id', $node['id'])->where('in_page', 1)->get(['id', 'name', 'uri'])->toArray();
                            if (sizeof($subNodeII) > 0) {
                                $result .= '<li>';
                                if ($node['uri'] == '') {
                                    $result .= '<a href="#';
                                } else {
                                    $result .= '<a href="' . url() . $node['uri'];
                                }
                                $result .= '">';
                                $result .= '<span class="fa arrow"></span>' . $node['name'] . '</a>';
                                //End child(2)
                                $result .= '<ul class="nav nav-third-level">  ';
                                //foreach child(3)
                                foreach ($subNodeII as $node) {
                                    $subNodeIII = $this->where('parent_id', $node['id'])->where('in_page', 1)->get(['name', 'uri'])->toArray();
                                    if (sizeof($subNodeIII) > 0) {
                                        $result .= '<li>';
                                        $result .= '<a href="' . url() . $node['uri'];
                                        $result .= '">';
                                        $result .= $node['name'] . '</a>';
                                    } else {
                                        $result .= '<li>';
                                        $result .= '<a href="' . url() . $node['uri'] . '">' . $node['name'] . '</a>';
                                    }
                                }
                                $result .= '</li>';
                                $result .= '</ul>';
                            } else {
                                $result .= '<li>';
                                $result .= '<a href="' . url() . $node['uri'] . '">' . $node['name'] . '</a>';
                            }
                        }
                        $result .= '</li>';
                        $result .= '</ul>';
                    } else {
                        $result .= '<a href="' . url() . $node['uri'] . '">' . $node['name'] . '</a>';
                    }

                }


                $result .= '</li>';
                $result .= '</ul>';
            } else {
                $result .= '">' . $nameRoot . '</a></li>';
            }
        }

        return $result;
    }

    public function navibarFE($cate)
    {
        $result = '';
        //name root tag is index of array
        foreach ($cate as $nameRoot => $aCate) {
            // get data current Root
            $root = $this->where('name', $nameRoot)->where('in_page', 0)->first()->toArray();
            $result .= '<li>';
            $result .= '<a href="' . url() . $root['uri'];
            //get array child(1) of current root tag
            $arrKeysLv1 = array_keys($cate[($nameRoot)]);
            //check has child(1)
            if (sizeof($arrKeysLv1) > 0) {
                //true , print data
                $result .= '" class="dropdown-toggle" data-toggle="dropdown">';
                $result .= '<b class="caret"></b>' . $nameRoot . '</a>';
                //End current root tag
                $result .= '<ul class="dropdown-menu">  ';
                $result .= '<li>';
                //foreach child(1)
                foreach ($arrKeysLv1 as $nodeI) {
                    $node     = $this->where('name', $nodeI)->where('in_page', 0)->first()->toArray();
                    $subNodeI = $this->where('parent_id', $node['id'])->where('in_page', 0)->get(['id', 'name', 'uri'])->toArray();
                    if (sizeof($subNodeI) > 0) {
                        $result .= '<li class="dropdown-submenu">';
                        $result .= '<a href="' . url() . $node['uri'];
                        $result .= '" class="dropdown-toggle" data-toggle="dropdown">';
                        $result .= $node['name'] . '</a>';
                        //End child(1)
                        $result .= '<ul class="dropdown-menu">  ';
                        //foreach child(2)
                        foreach ($subNodeI as $node) {
                            $subNodeII = $this->where('parent_id', $node['id'])->where('in_page', 0)->get(['id', 'name', 'uri'])->toArray();
                            if (sizeof($subNodeII) > 0) {
                                $result .= '<li class="dropdown-submenu">';
                                $result .= '<a href="' . url() . $node['uri'];
                                $result .= '" class="dropdown-toggle" data-toggle="dropdown">';
                                $result .= $node['name'] . '</a>';
                                //End child(2)
                                $result .= '<ul class="dropdown-menu">  ';
                                //foreach child(3)
                                foreach ($subNodeII as $node) {
                                    $subNodeIII = $this->where('parent_id', $node['id'])->where('in_page', 0)->get(['name', 'uri'])->toArray();
                                    if (sizeof($subNodeIII) > 0) {
                                        $result .= '<li class="dropdown-submenu">';
                                        $result .= '<a href="' . url() . $node['uri'];
                                        $result .= '" class="dropdown-toggle" data-toggle="dropdown">';
                                        $result .= $node['name'] . '</a>';
                                    } else {
                                        $result .= '<li>';
                                        $result .= '<a href="' . url().$node['uri'] . '">' . $node['name'] . '</a>';
                                    }
                                }
                                $result .= '</li>';
                                $result .= '</ul>';
                            } else {
                                $result .= '<li>';
                                $result .= '<a href="' . url().$node['uri'] . '">' . $node['name'] . '</a>';
                            }
                        }
                        $result .= '</li>';
                        $result .= '</ul>';
                    } else {
                        $result .= '<a href="' . url().$node['uri'] . '">' . $node['name'] . '</a>';
                    }

                }


                $result .= '</li>';
                $result .= '</ul>';
            } else {
                $result .= '">' . $nameRoot . '</a></li>';
            }
        }


        return $result;
    }

    public function listDOM($page)
    {


        $model = new Navigator();

        $result = '';
        //get biggest level (<4)
        $maxLv = $model->where('in_page', $page)->max('level');
        //count amount root tag
        $countRoot      = $model->where('in_page', $page)->where('level', 0)->count();
        $listNavigators = [];
        //get all Tag from level root(0)-> biggest(3);
        for ($i = 0; $i <= $maxLv; $i++) {
            $listNavigators[] = $model
                ->where('in_page', $page)
                ->where('level', $i)->
                get(['id', 'parent_id', 'uri', 'level', 'name'])
                ->toArray();
        }
        //loop time = amount root tag
        for ($i = 0; $i < $countRoot; $i++) {

            //get id ,name  of root tag [[0]=>[root=>['id'=>,...],[1]=>['child_lv1'=>['],,]]
            $result .= '<option value="' . array_get($listNavigators[0][$i], 'id') . '">----';
            $result .= array_get($listNavigators[0][$i], 'name');
            $result .= '</option>';
            //end tag root
            //check has list child(1)
            if (isset($listNavigators[1])) {
                //true, loop = amount child(1) tag
                for ($j = 0; $j < sizeof($listNavigators[1]); $j++) {
                    //check is child(1) of current root tag
                    if (array_get($listNavigators[1][$j], 'parent_id') == array_get($listNavigators[0][$i], 'id')) {
                        //True, get id ,name  of child(1) tag
                        $result .= '<option value="' . array_get($listNavigators[1][$j], 'id') . '">--------';
                        $result .= array_get($listNavigators[1][$j], 'name');
                        $result .= '</option>';
                        //check has list child(2)
                        if (isset($listNavigators[2])) {
                            //true, loop = amount child(2) tag
                            for ($m = 0; $m < sizeof($listNavigators[2]); $m++) {
                                if (array_get($listNavigators[2][$m], 'parent_id') == array_get($listNavigators[1][$j], 'id')) {
                                    $result .= '<option value="' . array_get($listNavigators[2][$m], 'id') . '">------------';
                                    $result .= array_get($listNavigators[2][$m], 'name');
                                    $result .= '</option>';
                                    //check has list child(3)
                                    if (isset($listNavigators[3])) {
                                        //true, loop = amount child(3) tag
                                        for ($n = 0; $n < sizeof($listNavigators[3]); $n++) {
                                            //check is child(1) of current child(2) tag
                                            if (array_get($listNavigators[3][$n], 'parent_id') == array_get($listNavigators[2][$m], 'id')) {
                                                $result .= '<option value="' . array_get($listNavigators[3][$n], 'id') . '">----------------';
                                                $result .= array_get($listNavigators[3][$n], 'name');
                                                $result .= '</option>';
                                                $result .= array_get($listNavigators[3][$n], 'name');

                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }


        }
        echo $result;
    }

    public function listPosition($inPage, $optional, $Navigator)
    {
        $result = '';
        //check optional
        //type new
        if ($optional == 'new') {
            //check is current folder root or
            //if differ root
            if ($Navigator != 'root') {
                $check = $this->where('name', $Navigator)->where('in_page', $inPage)->count();
                if ($check > 0) {
                    //get id current tag
                    $parent   = $this->where('name', $Navigator)->where('in_page', $inPage)->first()->toArray();
                    $idParent = $parent['id'];

                    //check current tag has >2 tag, if more rend position
                    $check = $this->where('parent_id', $idParent)->where('in_page', $inPage)->count();
                    if ($check > 2) {

                        //get  position child tag
                        $subNavigators = $this->where('parent_id', $idParent)->where('in_page', $inPage)->get(['position'])->toArray();

                        //get pos of tag bottom
                        $biggest = $this->where('parent_id', $idParent)->where('in_page', $inPage)->max('position');

                        //get pos of head tag
                        $smallest = $this->where('parent_id', $idParent)->where('in_page', $inPage)->min('position');

                        //new pos of new head tag = old head -1
                        $result .= '<option value="' . ($smallest - 1) . '">Top</option>';

                        //rend pos in body
                        foreach ($subNavigators as $subNavigator) {
                            $result .= '<option value="' . $subNavigator['position'] . '">' . $subNavigator['position'] . '</option>';
                        }

                        // new pos last= pos of old last +1
                        $result .= '<option value="' . ($biggest + 1) . '">Bottom</option>';
                    } else {
                        $result .= '<option value="0">Top</option>';
                        $result .= '<option value="1">Bottom</option>';
                    }//end check has >2 child tag
                }
            } else {
                //parent root tag =0
                $idParent = 0;
                //ensure root always exist
                $subNavigators = $this->where('parent_id', $idParent)->where('in_page', $inPage)->get(['position'])->toArray();

                //get pos head ,bottom tag

                $biggest  = $this->where('parent_id', $idParent)->where('in_page', $inPage)->max('position');
                $smallest = $this->where('parent_id', $idParent)->where('in_page', $inPage)->min('position');

                // new pos head tag
                $result .= '<option value="' . ($smallest - 1) . '">Top</option>';
                foreach ($subNavigators as $subNavigator) {
                    $result .= '<option value="' . $subNavigator['position'] . '">' . $subNavigator['position'] . '</option>';
                }
                //new pos bottom tag
                $result .= '<option value="' . ($biggest + 1) . '">Bottom</option>';
            }

        } else {
            //check has current tag exist
            $check = $this->where('name', $Navigator)->where('in_page', $inPage)->count();
            if ($check > 0) {
                //true, get data parent
                $parent   = $this->where('name', $Navigator)->where('in_page', $inPage)->orderBy('position')->get(['parent_id'])->toArray();
                $idParent = $parent[0]['parent_id'];
                $check    = $this->where('parent_id', $idParent)->where('in_page', $inPage)->count();
                //check current tag has more 2 child
                if ($check > 2) {
                    //get data, make new pos
                    $subNavigators = $this->where('parent_id', $idParent)->where('in_page', $inPage)->get(['position'])->toArray();
                    $biggest       = $this->where('parent_id', $idParent)->where('in_page', $inPage)->max('position');
                    $smallest      = $this->where('parent_id', $idParent)->where('in_page', $inPage)->min('position');
                    $result .= '<option value="' . ($smallest - 1) . '">Top</option>';

                    foreach ($subNavigators as $subNavigator) {
                        $result .= '<option value="' . $subNavigator['position'] . '">' . $subNavigator['position'] . '</option>';
                    }
                    $result .= '<option value="' . ($biggest + 1) . '">Bottom</option>';
                } else {
                    $result .= '<option value="0">Top</option>';
                    $result .= '<option value="1">Bottom</option>';
                }//end check current tag has more 2 child
            } else {
                $error = ['type' => 'e', 'message' => 'Not exist tag!'];
                return json_encode($error);
            }//end check exist
        }//end type update
        return $result;
    }
}