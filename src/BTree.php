<?php

namespace j\tree;


/**
 * Class BTree
 * @package j\tree\tests
 * @property array $map
 * @property array $tree
 */
class BTree extends BaseTree {

    protected $source;
    public $childKey = 'child';

    /**
     * @param $name
     * @return null
     */
    public function __get($name){
        if($name == 'map' || $name == 'tree'){
            $this->buildTree();
            return $this->{$name};
        } else {
            return null;
        }
    }

    /**
     * @param $id
     * @return NodeInterface
     */
    protected function createElement($id){
        if(isset($this->map[$id])){
            $props = $this->map[$id];
            $name = $props[$this->nameKey];
            return $this->createNode($id, $name, $props);
        } else {
            return null;
        }
    }

    function setSource($cats){
        $this->source = $cats;
        unset($this->map);
        unset($this->tree);
    }

    protected function buildTree(){
        $keyId = $this->idKey;
        $keyPid = $this->pidKey;
        $keyChild = $this->childKey;

        $tree = array();
        $childMap = [];
        foreach($this->source as $item) {
            $item[$keyChild] = array(); //给每个节点附加一个child项
            $key = $item[$keyId];

            if($this->isRoot($item[$keyPid])) {
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
        $this->map = $childMap;
        $this->tree = $tree;
    }


    /**
     * @param $id
     * @return NodeInterface|array
     */
    function getParent($id){
        if($pid = $this->parentId($id)){
            return $this->getElementById($pid);
        } else {
            return null;
        }
    }

    function parentId($id){
        if(isset($this->map[$id][$this->pidKey])){
            return $this->map[$id][$this->pidKey];
        } else {
            return null;
        }
    }

    function getParents($id, $self = false, $maxLevel = 6) {
        $keyPid = $this->pidKey;

        if(!isset($this->map[$id])){
            return [];
        }

        $item = $this->map[$id];
        $parents = $self ? [$id => $item] : [];
        $i = 0;
        while($pid = $item[$keyPid]){
            $parents[$pid] = $item = $this->map[$pid];
            if($i++ > $maxLevel){
                break;
            }
        }
        $parents = array_reverse($parents, true);
        return $this->getElements(array_keys($parents));
    }

    function getParentIds($id, $self = false, $maxLevel = 6){
        return array_keys($this->getParents($id, $self, $maxLevel));
    }


    /**
     * @param $id
     * @return array
     */
    function getChild($id){
        if($this->isRoot($id)){
            return $this->getElements(array_keys($this->tree));
        }

        if(!$this->hasChild($id)){
            return [];
        }

        $child = $this->map[$id][$this->childKey];
        return $this->getElements(array_keys($child));
    }

    function getChildIdentifying($id, $self = false, $recursive = true){
        if($this->isRoot($id)){
            return [];
        }

        $ids = $self ? [$id] : array();
        $items = $this->map[$id][$this->childKey];
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

    /**
     * @param mixed $id
     * @return int
     */
    function getDeep($id){
        return count($this->getParents($id));
    }

    /**
     * @param $id
     * @return bool
     */
    function hasChild($id){
        if($this->isRoot($id)){
            return true;
        }
        return isset($this->map[$id][$this->childKey]) && count($this->map[$id][$this->childKey]) > 0;
    }
}
