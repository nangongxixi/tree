<?php

namespace j\tree;

/**
 * Class TreeTest
 * @package j\tree
 */
class TreeTest extends BaseTestCase {

    function testAll(){
        $tree = Tree::getInstance();
        $tree->setSource($this->getData());
        $this->treeTest($tree);
    }
}