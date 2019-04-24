<?php

namespace j\tree;

/**
 * Interface InterfaceTree
 * @package j\tree
 */
interface TreeInterface {
    /**
     * @param $id
     * @return NodeInterface|Node
     */
    function getElementById($id);

    /**
     * @return NodeInterface
     */
    function getRoot();

    /**
     * @param $id
     * @return NodeInterface|null
     */
    function getParent($id);

    /**
     * @param $id
     * @param int $maxLevel
     * @param bool $self
     * @return NodeInterface[]|array
     */
    function getParents($id, $self = false, $maxLevel = 5);

    /**
     * @param $id
     * @return NodeInterface[]|array
     */
    function getChild($id);

    /**
     * @param int $id
     * @param bool $self
     * @param int $maxLevel
     * @return int[]|string[]
     */
    function getChildIdentifying($id, $self = false, $maxLevel = 5);

    /**
     * @param $id
     * @return bool
     */
    function hasChild($id);

    /**
     * @param mixed $id
     * @return int
     */
    function getDeep($id);
}