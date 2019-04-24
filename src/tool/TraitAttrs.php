<?php

namespace j\tree\tool;

/**
 * Class TraitAttrs
 * @package jui\form\element
 */
trait TraitAttrs {

    private $attrs = [];
    protected $encodeValue = false;
    public $stringAttr = '';

    /**
     * @param $key
     * @param null $value
     * @return $this
     */
    public function setAttr($key, $value = null) {
        if (is_array($key)) {
            $this->attrs = array_merge($this->attrs, $key);
        } else {
            $this->attrs[$key] = $value;
        }
        return $this;
    }

    /**
     * @param $key
     * @return $this
     */
    public function removeAttr($key){
        unset($this->attrs[$key]);
        return $this;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function hasAttr($key){
        return array_key_exists($key, $this->attrs);
    }

    /**
     * @param $key
     * @param null $def
     * @param bool $remove
     * @return null
     */
    public function getAttr($key, $def = null, $remove = false){
        $value = isset($this->attrs[$key]) ? $this->attrs[$key] : $def;
        if($remove){
            $this->removeAttr($key);
        }
        return $value;
    }

    /**
     * @return array
     */
    public function getAttrs(){
        return $this->attrs;
    }


    /**
     * @param array $attrs
     * @return string
     */
    protected function asString($attrs = []){
        if(!$attrs){
            $attrs = $this->attrs;
        }

        $string = [];
        if(isset($this->defaultClass)
            && $this->defaultClass
            && (strpos($this->stringAttr, 'class="') === false) && !isset($attrs['class'])
        ){
            $attrs['class'] = $this->defaultClass;
        }
        foreach($attrs as $key => $value){
            $string[] = $this->genAttr($key, $value);
        }

        return " " . implode(" ", $string) . $this->stringAttr;
    }

    /**
     * @param $key
     * @param $value
     * @return string
     */
    protected function genAttr($key, $value){
        if($this->encodeValue){
            $value = urlencode($value);
        }

        if(!$value && $this->notEmptyKeys && in_array($key, $this->notEmptyKeys)){
            return '';
        }

        return $key . '="' . $value . '"';
    }

    /**
     * @var array
     */
    protected $notEmptyKeys  = [];

    /**
     * @param $keys
     * @return $this
     */
    protected function setNotEmptyKeys($keys){
        $this->notEmptyKeys = $keys;
        return $this;
    }

    /**
     * @param $key
     * @return $this
     */
    protected function addNotEmptyKey($key){
        if(is_array($key)){
            $this->notEmptyKeys[] = $key;
        } else {
            $this->notEmptyKeys += $key;
        }
        return $this;
    }
}