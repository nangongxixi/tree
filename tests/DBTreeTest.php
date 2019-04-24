<?php

namespace j\tree;

use j\db\Table;

/**
 * Class TreeTest
 * @package j\tree
 */
class DBTreeTest extends BaseTestCase {

    function testAll(){
        $tree = DbTree::getInstance();
        $tree->setSource(Table::factory('test.category'));
        $this->treeTest($tree);
    }

}