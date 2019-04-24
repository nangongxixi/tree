<?php

namespace j\tree;

use j\tree\exception\ExceptionRelation;

/**
 * (innert)
 */
class Relation {
    /**
     * child map
     * @var []
     */
    private $child = array();

    /**
     * children map
     * @var []
     */
    private $children = array();

    /**
     * parent map
     * @var []
     */
    private $parent = array();

    /**
     * parents map
     * @var []
     */
    private $parents = array();

    /**
     * deep map
     * @var []
     */
    private $deeps = array();


    /**
     * @param array $map = array(cid => pid, )
     */
    public function setParentMap($map) {

        $this->parent = $map;
        $this->parents = array();
        $this->deeps = array();
        $this->children = array();

        $child = array();
        foreach ($this->parent as $cid => $pid) {
            if($cid === $pid){
                throw(new ExceptionRelation("Invalid pid({$cid}-{$pid})"));
            }

            if(!isset($child[$pid])){
                $child[$pid] = array();
            }
            $child[$pid][] = $cid;
        }
        $this->child = $child;
    }

    /**
     * put your comment there...
     *
     * @param mixed $cid
     * @return mixed
     */
    public function getDeep($cid) {
        if(!isset($this->deeps[$cid])){
            $parents = $this->getParents($cid);
            $this->deeps[$cid] = count($parents);
        }
        return $this->deeps[$cid];
    }

    /**
     * put your comment there...
     *
     * @param mixed $id
     * @param int $maxLevel
     * @param bool $self
     * @return array array(cid, cid, cid)
     */
    public function getParents($id, $maxLevel = 5) {
        if(!isset($this->parents[$id])){
            $level = 0;
            $parents = array();
            $_id = $id;
            while($pid = $this->getParent($_id)){
                $parents[] = $pid;
                $_id = $pid;
                if($level++ > $maxLevel){
                    break;
                }
            }
            $this->parents[$id] = array_reverse($parents);
        }

        return $this->parents[$id];
    }

    public function getParent($cid, $deep = null){
        if(!is_numeric($deep)){
            return isset($this->parent[$cid]) ? $this->parent[$cid] : null;
        }else{
            $parents = $this->getParents($cid);
            if(isset($parents[$deep])){
                return $parents[$deep];
            }else{
                return null;
            }
        }
    }

    /**
     * get child from cid
     *
     * @param mixed $cid
     * @param boolean $self
     * @return array array(cid1, cid2)
     */
    public function getChild($cid, $self = false) {
        if(isset($this->child[$cid])){
            if($self){
                $cids = $this->child[$cid];
                $cids[] = $cid;
                return $cids;
            }
            return $this->child[$cid];
        }

        if($self){
            return array($cid);
        }else{
            return array();
        }
    }

    public function getChildren($cid, $self = false, $deep = 10) {
        if(!isset($this->children[$cid])){
            $children = $cats = $this->getChild($cid);
            foreach ($cats as $_cid) {
                $children = array_merge($children, $this->getChildren($_cid));
            }
            $this->children[$cid] = $children;
        }

        if($self){
            $cids = $this->children[$cid];
            $cids[] = $cid;
            return $cids;
        }

        return $this->children[$cid];
    }

    public function hasChild($cid){
        return isset($this->child[$cid]);
    }
}
