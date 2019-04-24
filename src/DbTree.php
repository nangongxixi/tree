<?php

namespace j\tree;

use j\db\Table;

/**
 * Class DbTree
 * @package j\tree
 */
class DbTree extends BaseTree {

    /**
     * @var Table
     */
    protected $table;
    protected $cond = [];
    protected $childCache = [];

    /**
     * DbTree constructor.
     * @param null $idKey
     * @param null $nameKey
     * @param null $pidKey
     */
    public function __construct($idKey = null, $nameKey = null, $pidKey = null){
        parent::__construct($idKey, $nameKey, $pidKey);
        $this->setKey($this->idKey, $this->nameKey, $this->pidKey);
    }


    public function setKey($idKey, $nameKey, $pidKey){
        parent::setKey($idKey, $nameKey, $pidKey);
        $this->cond['_fields'] = [$idKey, $nameKey, $pidKey];
    }

    function setSource($table, $cond = []){
        $this->table = $table;
        $this->cond = $cond + $this->cond;
    }

    protected function query($cond){
        if(!isset($this->table)){
            $this->load();
        }

        if(is_numeric($cond)){
            $cond = array('id' => $cond);
        }

        return $this->table->find($cond + $this->cond);
    }

    /**
     * @override
     * @param mixed $id
     * @param array $info
     * @return Node|NodeInterface|mixed
     */
    function getElementById($id, $info = []){
        if($info){
            return $this->nodes[$id] =  $this->createNode(
                $id,
                $info[$this->nameKey],
                $info
            );
        } else {
            return parent::getElementById($id);
        }
    }

    /**
     * @param $id
     * @return NodeInterface
     */
    protected function createElement($id){
        $info = $this
            ->query([$this->idKey => $id] + $this->cond)
            ->current();
        if($info){
            return $this->createNode($id, $info[$this->nameKey], $info);
        } else {
            return null;
        }
    }

    /**
     * @param $id
     * @return NodeInterface|null
     */
    function getParent($id){
        if(!$id){
            return null;
        }

        $node = $this->getElementById($id);
        if(!$node){
            return null;
        }

        $pid = $node->getProp($this->pidKey);
        if(!$pid){
            return null;
        }

        return $this->getElementById($pid);
    }

    /**
     * @param $id
     * @param int $maxLevel
     * @param bool $self
     * @return NodeInterface[]|array
     */
    function getParents($id, $self = false, $maxLevel = 5){
        if(!$id){
            return null;
        }

        $parents = array();
        if($self){
            $node = $this->getElementById($id);
            if(!$node){
                return $parents;
            }
            $parents[$id] = $node;
        }
        $i = 0;
        while($parent = $this->getParent($id)){
            if($i++ > $maxLevel){
                break;
            }
            $pid = $parent->getId();
            $parents[$pid] = $parent;
            $id = $pid;
        }

        return array_reverse($parents, true);
    }

    /**
     * @param $id
     * @return NodeInterface[]|array
     */
    function getChild($id){
        if(isset($this->childCache[$id])){
            return $this->childCache[$id];
        }

        $child = [];
        $rows = $this->query([$this->pidKey => $id]);
        foreach($rows as $row){
            $_id = $row[$this->idKey];
            $child[$_id] = $this->getElementById($_id, $row);
        }

        $this->childCache[$id] = $child;
        return $child;
    }

    /**
     * @param int $id
     * @param bool $self
     * @param int $maxLevel
     * @return int[]|string[]
     */
    function getChildIdentifying($id, $self = false, $maxLevel = 5){
        $child = $this->getChild($id);
        if(!$child){
            return [];
        }

        $ids = array_keys($child);
        $data = $ids;
        $level = 1;
        while($ids && $level < $maxLevel){
            $level++;
            // query db, getChild ids
            $child =  $this
                ->query([
                    $this->pidKey => $ids,
                    '_fields' => [$this->idKey]
                    ])
                ->toArray(null, $this->idKey);
            if($child){
                $ids = $child;
                $data = array_merge($data, $child);
            }else{
                break;
            }
        }
        if($self){
            $data[] = $id;
        }
        return $data;
    }

    /**
     * @param $id
     * @return bool
     */
    function hasChild($id){
        return count($this->getChild($id)) > 0;
    }

    /**
     * @param mixed $id
     * @return int
     */
    function getDeep($id){
        return count($this->getParents($id));
    }
}
