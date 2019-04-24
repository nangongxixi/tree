<?php

namespace j\tree\render;

use j\tree\Node;
use j\tree\NodeInterface;

class Factory{
    /**
     * @param Node|NodeInterface $node
     * @param string $type
     * @return BaseRender|Select
     * @throws \Exception
     */
    static function getInstance(Node $node, $type = 'mselect'){
        $class = __NAMESPACE__ . '\\' . ucfirst($type);
        if(!class_exists($class)){
            throw new \Exception('Invalid type');
        }

        /** @var BaseRender $instance */
        $instance = new $class();
        $instance->setData($node);

        return $instance;
    }
}
