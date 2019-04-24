<?php

namespace j\tree;

use Iterator;

/**
 * Class Node
 * @package j\tree
 * @property array $nodes
 * @property int $id
 * @property string $name
 */
class Node implements NodeInterface, Iterator, \Countable {
    /**
     * @return int
     */
    public function count(){
        return count($this->nodes);
    }

    /**
     * implements
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value) {
        $this->__set($offset, $value);
    }

    public function offsetUnset($offset) {
        unset($this->props[$offset]);
    }

    public function offsetExists($offset) {
        return isset($this->props[$offset]);
    }

    public function offsetGet($offset) {
        return $this->__get($offset);
    }

    function __get($key) {
        return $this->getProp($key);
    }

    function __set($key, $value) {
        $this->setProp($key, $value);
    }

    function __toString(){
        return $this->getName() . '';
    }

    /**
     * fro Iterator;
     */
    protected $position = 0;


    public function current (){
        return $this->nodes[$this->position];
    }

    public function key (){
        return $this->position;
    }

    public function next (){
        $this->position++;
    }

    public function rewind (){
        $this->position = 0;
    }

    public function valid (){
        return isset($this->nodes[$this->position]);
    }

    /**
     *
     * @var TreeInterface
     */
    protected $tree;
    protected $id;
    protected $name;
    /**
     * @var array
     */
    protected $props = [];

    /**
     * put your comment there...
     *
     * @param TreeInterface $tree
     * @param mixed $id
     * @param string $name
     * @param array $props
     */
    function __construct(TreeInterface $tree, $id, $name, $props = []) {
        $this->id = $id;
        $this->name = $name;
        $this->tree = $tree;
        $this->props = $props;
    }

    function getName($full = false, $separator = ' > '){
        if(!$full) {
            return $this->name;
        } else {
            $parents = $this->tree->getParents($this->id);
            $parents[] = $this;
            return implode($separator, $parents);
        }
    }

    /**
     * Get the children of this node
     *
     * @return array
     */
    function getChild() {
        return $this->tree->getChild($this->id);
    }

    /**
     * @param bool $isTop
     * @return NodeInterface
     */
    function getParent($isTop = false) {
        if($isTop){
            return $this->getTopParent();
        } else {
            return $this->tree->getParent($this->id);
        }
    }

    function getTopParent(){
        $parents = $this->getParents($this->id);
        if($parents){
            return array_shift($parents);
        } else {
            return $this;
        }
    }

    /**
     * TestListener if this node has children
     *
     * @return bool
     */
    function hasChild() {
        return $this->tree->hasChild($this->id);
    }

    function getDeep(){
        return $this->tree->getDeep($this->id);
    }

    /**
     * @param bool $self
     * @return int[]|string[]
     */
    function getChildIdentifying($self = false){
        return $this->tree->getChildIdentifying($this->id, $self);
    }

    /**
     * @param $key
     * @param null $def
     * @return null|mixed
     */
    function getProp($key, $def = null){
        if($key == 'id'){
            return $this->getId();
        }

        if($key == 'name'){
            return $this->getName();
        }

        if($key == 'nodes'){
            return $this->nodes = array_values($this->getChild());
        }

        if(isset($this->props[$key]) || array_key_exists($key, $this->props)){
            return $this->props[$key];
        }

        return $def;
    }

    function setProp($key, $value = null){
        if(is_array($key)){
            $this->props = array_merge($this->props, $key);
        }else{
            $this->props[$key] = $value;
        }
    }

    function getId(){
        return $this->id;
    }

    /**
     * TestListener if this node has a parent
     *
     * @return bool
     */
    function hasParent() {
        return (boolean)$this->getParent();
    }

    /**
     * @param bool $self
     * @param int $maxLevel
     * @return NodeInterface[]
     */
    public function getParents($self = false, $maxLevel = 6){
        return $this->tree->getParents($this->id, $self, $maxLevel);
    }

    /**
     * @param NodeInterface $node
     * @return bool
     */
    function isContain(NodeInterface $node){
        if($node->getId() == $this->id){
            return true;
        }

        $tmp = $node;
        while($parent = $tmp->getParent()){
            if($parent->getId() == $this->id){
                return true;
            }
            $tmp = $parent;
        }

        return false;
    }

    function toArray(){
        return $this->props;
    }
}
