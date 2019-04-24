<?php

namespace j\tree\render;

use j\tree\Node;

class RenderComm extends Render{
    private $store;

    /**
     * @param Node $node
     * @param $deep
     * @param int $index
     */
    protected function leaf($node, $deep, $index = 0) {
        $node->setProp('deep', $deep);
        $this->store[$node->getId()] = $node;
    }
  
    protected function branchStart($node, $deep) {
        $this->leaf($node, $deep, 0);
    }
    
    protected function branchStop($node, $deep){
    }
  
    public function render($node){
        $this->store = array();
        $this->traversal($node);
        return $this->store;
    }
}
