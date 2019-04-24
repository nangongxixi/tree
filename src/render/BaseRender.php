<?php

namespace j\tree\render;

use j\tree\Node;

/**
 * Class BaseRender
 * @package j\tree\render
 */
class BaseRender {
    /**
     * put your comment there...
     *
     * @var \j\tree\Node
     */
    protected $data;
    protected $options = array();

    function setOption($k, $v = '') {
        if(is_array($k)){
            $this->options = array_merge($this->options, $k);
        }else{
            $this->options[$k] = $v;
        }
    }

    function getOption($k) {
        return isset($this->options[$k]) ? $this->options[$k] : '';
    }

    function setData(Node $node) {
        $this->data = $node;
    }
}
