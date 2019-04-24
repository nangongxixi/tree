<?php

namespace j\tree;

/**
 * Interface NodeInterface
 * @package j\tree
 */
interface NodeInterface extends \ArrayAccess {
    /**
     * @param bool $isTop
     * @return NodeInterface
     */
    function getParent($isTop = false);

    /**
     * @return bool
     */
    function hasParent();

    /**
     * @return NodeInterface[]
     */
    function getChild();

    /**
     * @return bool
     */
    function hasChild();

    /**
     * @param bool $self
     * @return int[]|string[]
     */
    function getChildIdentifying($self = false);

    /**
     * @param NodeInterface $node
     * @return bool
     */
    function isContain(NodeInterface $node);

    /**
     * @return int
     */
    function getDeep();

    /**
     * @param $key
     * @param null $def
     * @return mixed
     */
    function getProp($key, $def = null);
    function setProp($key, $value = null);
    function getId();
    function getName($full = false, $separator = ' > ');
    function __toString();

}