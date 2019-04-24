<?php
# TreeTest.php
namespace j\tree\tests;

require __DIR__ . '/init.php';

/**
 * Class BTree
 * @package j\tree\tests
 * @property array $tree
 */
class BTreeX {

    protected $source;
    public $index = [];

    public $idKey = 'id';
    public $pidKey = 'pid';
    public $childKey = 'child';

    /**
     * BTree constructor.
     * @param $source
     */
    public function __construct($source){
        $this->source = $source;
    }

    public function __get($name){
        if($name == 'tree'){
            return $this->tree = $this->buildTree();
        } else {
            return null;
        }
    }

    protected function buildTree(){
        $keyId = $this->idKey;
        $keyPid = $this->pidKey;
        $keyChild = $this->childKey;

        $tree = array();
        $childMap =& $this->index;
        foreach($this->source as $item) {
            $item[$keyChild] = array(); //给每个节点附加一个child项
            $key = $item[$keyId];

            if($item[$keyPid] == 0) {
                if(isset($childMap[$key])){
                    // 已设置当前子类映射
                    $childMap[$key] += $item;
                    $tree[$key] =& $childMap[$key];
                } else {
                    $tree[$key] = $item;
                    $childMap[$key] =& $tree[$key];
                }
            }else {
                $pid = $item[$keyPid];
                if(isset($childMap[$key])){
                    // 已设置当前子类映射
                    $childMap[$key] += $item;
                    $childMap[$pid][$keyChild][$key] =& $childMap[$key];
                } else {
                    $childMap[$pid][$keyChild][$key] = $item;
                    $childMap[$key] =& $childMap[$pid][$keyChild][$key];
                }
            }
        }
        return $tree;
    }

    function getTree(){
        return $this->tree;
    }

    /**
     * @param $id
     * @return array
     */
    function getParent($id){
        return $this->index[$id];
    }

    function getParents($id, $self = false, $maxLevel = 6) {
        $keyId = $this->idKey;
        $keyPid = $this->pidKey;

        $item = $this->index[$id];
        $parents = $self ? [$id => $item] : [];
        $i = 0;
        while(isset($this->index[$item[$keyPid]])){
            $item = $parents[$item[$keyId]] =  $this->index[$item[$keyPid]];
            if($i++ > $maxLevel){
                break;
            }
        }
        return array_reverse($parents, true);
    }

    function getParentIds($id, $self = false, $maxLevel = 6){
        return array_keys($this->getParents($id, $self, $maxLevel));
    }

    function parentId($id){
        return $this->index[$id][$this->pidKey];
    }

    /**
     * @param $id
     * @return array
     */
    function getChild($id){
        return $this->index[$id][$this->childKey];
    }

    function getChildIdentifying($id, $self = false, $recursive = true){
        $ids = $self ? [$id] : array();
        $items = $this->index[$id][$this->childKey];
        if($recursive){
            $stack = [];
            array_push($stack, $items);
            while($items = array_pop($stack)){
                foreach($items as $item){
                    $ids[] = $item[$this->idKey];
                    if(count($item[$this->childKey]) > 0){
                        array_push($stack, $item[$this->childKey]);
                    }
                }
            }
        } else {
            $ids = array_merge($ids, array_keys($items[$this->childKey]));
        }
        return $ids;

        //        array_walk_recursive($this->tree[$id]['child'], function($item, $key) use(& $ids){
        //            if($key == 'id'){
        //                $ids[] = $item;
        //            }
        //        });
    }
};

// b+树
// 测试数据
$data = array(
    array('id' => 1, 'pid' => 0),
    array('id' => 4, 'pid' => 2),
    array('id' => 3, 'pid' => 2),
    array('id' => 2, 'pid' => 1),
);

$t = new BTreeX($data);
$tree = $t->getTree();

assert_expr(count($tree) == 1, 'ROOT NODE TEST');
assert_expr(count($tree[1]['child']) == 1, 'Child test1');
assert_expr(count($tree[1]['child'][2]['child']) == 2, 'Child test1');
assert_expr(count($t->getChildIdentifying(1)) == 3, 'Child ids');
assert_expr(count($t->getChildIdentifying(2)) == 2, 'Child ids');
assert_expr(count($t->getChildIdentifying(3)) == 0, 'Child ids');
assert_expr(count($t->getChildIdentifying(4)) == 0, 'Child ids');


// pid = 6, level = 3
// pid = 9, level = 2
$data = array(
    array('id' => 1, 'pid' => 0),
    array('id' => 2, 'pid' => 0),
    array('id' => 9, 'pid' => 0),

    array('id' => 3, 'pid' => 2),
    array('id' => 4, 'pid' => 2),
    array('id' => 5, 'pid' => 2),

    array('id' => 8, 'pid' => 6),
    array('id' => 10, 'pid' => 6),

    array('id' => 6, 'pid' => 9),
    array('id' => 7, 'pid' => 9),

);

$t = new BTree($data);
$tree = $t->getTree();

assert_expr(count($tree) == 3, 'ROOT NODE TEST');
assert_expr(count($tree[1]['child']) == 0, 'Child test1');
assert_expr(isset($tree[9]['child'][6]['child'][8]), 'Child test1');
assert_expr(count($tree[2]['child']) == 3, 'Child test2');
assert_expr(count($tree[9]['child']) == 2, 'Child test9');

assert_expr(count($t->getChildIdentifying(1)) == 0, 'Child ids');
assert_expr(count($t->getChildIdentifying(2)) == 3, 'Child ids');
assert_expr(count($t->getChildIdentifying(6)) == 2, 'Child ids');
assert_expr(count($t->getChildIdentifying(10)) == 0, 'Child ids');
assert_expr(count($t->getChildIdentifying(9)) == 4, 'Child ids');

assert_expr(count($t->getParentIds(1)) == 0, 'parent ids');
assert_expr(count($t->getParentIds(9)) == 0, 'parent ids');
assert_expr(count($t->getParentIds(3)) == 1, 'parent ids');
assert_expr(count($t->getParentIds(8)) == 2, 'parent ids');