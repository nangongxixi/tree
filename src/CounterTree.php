<?php

namespace j\tree;

/**
 * Class CounterTree
 * @package j\tree
 */
class CounterTree extends Tree{

    /**
     * @var Tree
     */
    protected $sourceTree;

    /**
     * @param TreeInterface $tree
     * @param array $counter
     */
    function __construct($tree, $counter){
        parent::__construct();
        $this->sourceTree = $tree;
        $this->setSource($counter);
    }

    /**
     * @param mixed $cats
     * @param bool $isAssoc
     */
    function setSource($cats, $isAssoc = false){
        $nameKey = $this->nameKey;
        $pidKey = $this->pidKey;

        $tree = $this->sourceTree;
        $map = array();
        foreach ($cats as $cid => $n) {
            /** @var Node $node */
            $node = $tree->getElementById($cid);
            if(!$node){
                continue;
            }

            $parent = $node->getParent();
            $parent = $parent ?: $tree->getRoot();
            $map[$cid] = array(
                $nameKey => $node->getName(),
                $pidKey =>  $parent->getId(),
                'nums' => $n
            );

            $parents = $node->getParents();
            if($parents){
                foreach ($parents as $node) {
                    $id = $node->getId();
                    //if(!isset($cats[$id]) && !isset($map[$id])){
                    if(!isset($map[$id])){
                        // id不在统计中
                        // map中没有设置
                        $parent = $node->getParent();
                        $parent = $parent ?: $tree->getRoot();
                        $map[$id] = array(
                            $nameKey => $node->getName(),
                            $pidKey => $parent->getId(),
                            'nums' => 0
                        );
                    }
                    $map[$id]['nums'] += $n;
                }
            } elseif(!isset($map[$cid][$pidKey]) || !$map[$cid][$pidKey]){
                // 非顶级类别, 又没有父类
                unset($map[$cid]);
            }
        }

        parent::setSource($map, true);
    }

    /**
     * @return array
     */
    function getTops() {
        $cats = [];
        foreach($this->getRoot() as $node){
            $cats[] = [
                'id' => $node->id,
                'name' => $node->name,
                'nums' => $node->nums
            ];
        }
        return $cats;
    }
}