<?php

namespace j\tree;

use PHPUnit\Framework\TestCase;

/**
 * Class BaseTestCase
 * @package j\tree
 */
class BaseTestCase extends TestCase{

    protected function getData(){
        return array(
            array('pid' => 6, 'name' => 'name8', 'id' => 8),
            array('pid' => 6, 'name' => 'name10', 'id' => 10),

            array('pid' => 0, 'name' => 'name2', 'id' => 2),
            array('pid' => 0, 'name' => 'name9', 'id' => 9),

            array('pid' => 2, 'name' => 'name3', 'id' => 3),
            array('pid' => 2, 'name' => 'name4', 'id' => 4),
            array('pid' => 2, 'name' => 'name5', 'id' => 5),

            array('pid' => 1, 'name' => 'name6', 'id' => 6),
            array('pid' => 1, 'name' => 'name7', 'id' => 7),

            array('pid' => 0, 'name' => 'name1', 'id' => 1),
        );
    }

    /**
     * @param TreeInterface $tree
     */
    protected function treeTest($tree){
        $node = $tree->getRoot();
        
        $this->assertTrue(count($node->getChild()) == 3, 'test root');
        $this->assertTrue(count($tree->getElementById(1)->getChild()) == 2, 'test getChild');
        $this->assertEquals(count($tree->getElementById(1)->getChild()), 2, 'test getChild');
        $this->assertEquals(count($tree->getElementById(1)->getChild()), 2, 'test getChild');

        $this->assertEquals(count($tree->getElementById(1)->getChildIdentifying()), 4, 'test getChildIdentifying');
        $this->assertEquals(count($tree->getElementById(6)->getChildIdentifying()), 2, 'test getChildIdentifying');

        $this->assertTrue($tree->getElementById(1)->hasChild(), 'test hasChild');
        $this->assertTrue($tree->getElementById(2)->hasChild(), 'test hasChild');
        $this->assertTrue($tree->getElementById(6)->hasChild(), 'test hasChild');
        $this->assertTrue(!$tree->getElementById(3)->hasChild(), 'test hasChild');
        $this->assertTrue(!$tree->getElementById(8)->hasChild(), 'test hasChild');
        $this->assertTrue(!$tree->getElementById(10)->hasChild(), 'test hasChild');

        $this->assertEquals($tree->getElementById(8)->getParent(true)->getId(), 1, 'test getParent 1');
        $this->assertEquals($tree->getElementById(10)->getParent(true)->getId(), 1, 'test getParent 1');
        $this->assertEquals($tree->getElementById(6)->getParent(true)->getId(), 1, 'test getParent 2');
        $this->assertEquals($tree->getElementById(8)->getParent()->getId(), 6, 'test getParent 3');
        $this->assertEquals($tree->getElementById(6)->getParent()->getId(), 1, 'test getParent 4');
        $this->assertEquals($tree->getElementById(1)->getParent(), null, 'test getParent 5');

        $this->assertEquals(count($tree->getElementById(1)->getParents()), 0, 'test getParents 1');
        $this->assertEquals(count($tree->getElementById(6)->getParents()), 1, 'test getParents 2');
        $this->assertEquals(count($tree->getElementById(8)->getParents()), 2, 'test getParents 3');

        $this->assertTrue(!$tree->getElementById(1)->hasParent(), 'test hasParent');
        $this->assertTrue(!$tree->getElementById(2)->hasParent(), 'test hasParent');
        $this->assertTrue($tree->getElementById(3)->hasParent(), 'test hasParent');
        $this->assertTrue($tree->getElementById(6)->hasParent(), 'test hasParent');
        $this->assertTrue($tree->getElementById(8)->hasParent(), 'test hasParent');

        $this->assertEquals($tree->getElementById(2)->getDeep(), 0, 'test getDeep');
        $this->assertEquals($tree->getElementById(6)->getDeep(), 1, 'test getDeep');
        $this->assertEquals($tree->getElementById(8)->getDeep(), 2, 'test getDeep');
        $this->assertEquals($tree->getElementById(1)->isContain($tree->getElementById(8)), true, 'test isContain');
        $this->assertEquals($tree->getElementById(1)->getName(), "name1", 'test getName');
        $this->assertEquals($tree->getElementById(6)->getName(true), "name1 > name6", 'test getName');

        echo "Test foreach\n";
        foreach($tree->getElementById(0) as $node){
            $this->assertTrue(in_array($node->getId(), [1, 2, 9]), 'test foreach');
            $this->assertTrue(in_array($node['id'], [1, 2, 9]), 'test foreach');
        }

        foreach($tree->getElementById(2) as $node){
            $this->assertTrue(in_array($node->getId(), [3, 4, 5]), 'test foreach');
        }

        foreach($tree->getElementById(6) as $node){
            $this->assertTrue(in_array($node->getId(), [8, 10]), 'test foreach');
        }
    }

}