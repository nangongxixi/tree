<?php

namespace j\tree;

/**
 * Class TreeTest
 * @package j\tree
 */
class BTreeTest extends BaseTestCase {

    function testAll(){
        $tree = BTree::getInstance();
        $tree->setSource($this->getData());
        $this->treeTest($tree);
    }

}