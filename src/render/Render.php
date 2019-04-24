<?php

namespace j\tree\render;

use j\tree\NodeInterface;

/**
 * Class Render
 * @package j\tree\render
 */
abstract class Render {
    private $deep = -1;
  
    abstract protected function leaf($node, $deep, $index = 0);
    abstract protected function branchStart($node, $deep);
    abstract protected function branchStop($node, $deep);

    /**
     * @param NodeInterface $node
     */
    public function traversal(NodeInterface $node) {
        $this->deep++;
        if($this->deep > 0)
            $this->branchStart($node, $this->deep);
            
        if($node->hasChild()){
            /** @var NodeInterface[] $children */
            $children = $node->getChild();
            $i = 0;
            foreach ($children as $childNode) {
                if($childNode->hasChild()){
                    $this->traversal($childNode);
                }else{
                    $this->leaf($childNode, $this->deep + 1, $i++);
                }
            }
        }

        if($this->deep > 0)
            $this->branchStop($node, $this->deep);
        $this->deep--;
    }
    
    static function traveCallback(NodeInterface $node, $callback){
        $callback($node);
        if($node->hasChild()){
            /** @var NodeInterface $children */
            $children = $node->getChild();
            foreach ($children as $childNode) {
                if ($childNode->hasChild()) {
                    self::traveCallback($childNode, $callback);
                } else {
                    $callback($childNode);
                }
            }
        }
    }
}

