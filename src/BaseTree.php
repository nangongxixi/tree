<?php

namespace j\tree;

/**
 * Class BaseTree
 * @package j\tree
 */
abstract class BaseTree implements TreeInterface{
    /**
     * @var self[]
     */
    protected static $instance;

    /**
     * @return static
     */
    public static function getInstance(){
        $key = get_called_class();
        if(isset(static::$instance[$key])){
            return static::$instance[$key];
        }
        static::$instance[$key] = new static();
        return static::$instance[$key];
    }

    /**
     * node store
     * @var array
     */
    protected $nodes;

    /**
     * @var mixed
     */
    protected $nodeClass = 'j\\tree\\Node';

    public $rootName = 'ROOT';
    protected $idKey = 'id';
    protected $pidKey = 'pid';
    protected $nameKey = 'name';

    /**
     * BaseTree constructor.
     * @param string $idKey
     * @param string $pidKey
     * @param string $nameKey
     */
    public function __construct($idKey = null, $nameKey = null, $pidKey = null){
        if($idKey)
            $this->idKey = $idKey;
        if($pidKey)
            $this->pidKey = $pidKey;
        if($nameKey)
            $this->nameKey = $nameKey;
    }

    protected function isRoot($id){
        return $id == 0;
    }



    /**
     * @param $idKey
     * @param $nameKey
     * @param $pidKey
     */
    public function setKey($idKey, $nameKey, $pidKey){
        $this->idKey = $idKey;
        $this->nameKey = $nameKey;
        $this->pidKey = $pidKey;
    }

    /**
     * @var bool
     */
    protected $loaded = false;

    /**
     * @param $cats
     * @return CounterTree
     */
    static function counterFactory($cats){
        /** @var Tree $tree */
        $tree = static::getInstance();
        $class = static::getCounterTreeClass();
        return new $class($tree, $cats);
    }


    /**
     * @return string
     */
    protected static function getCounterTreeClass(){
        return 'j\\tree\\CounterTree';
    }


    function getRoot(){
        return $this->getElementById(0);
    }

    /**
     * put your comment there...
     *
     * @param mixed $id
     * @return NodeInterface|Node
     */
    function getElementById($id){
        if(!$this->loaded){
            $this->load();
        }

        if(!isset($this->nodes[$id])){
            if($id == 0){
                $this->nodes[$id] =  $this->createNode($id, $this->rootName);
            } else {
                $this->nodes[$id] = $this->createElement($id);
            }
        }

        return $this->nodes[$id];
    }

    /**
     * @param $id
     * @return NodeInterface
     */
    abstract protected function createElement($id);


    /**
     * @param $id
     * @param $name
     * @param array $options
     * @return mixed
     */
    protected function createNode($id, $name, $options = []){
        // @import, create node
        $className = $this->nodeClass;
        /** @var Node $node */
        return new $className($this, $id, $name, $options);
    }


    protected function load(){
        $this->loaded = true;
    }

    function setLoaded(){
        $this->loaded = true;
    }

    protected function getElements($ids){
        $nodes = [];
        foreach($ids as $id){
            $nodes[$id] = $this->getElementById($id);
        }
        return $nodes;
    }

    function getName($cid, $full = false, $separator = ' > '){
        if($node = $this->getElementById($cid)){
            return $node->getName($full, $separator);
        } else {
            return '';
        }
    }
}
