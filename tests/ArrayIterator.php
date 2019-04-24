<?php
# ArrayIterator.php

/**
 * User: Administrator
 * Date: 2017/4/11
 * Time: 13:19
 */

$array = array(
    array(
        array(
            array(
                'leaf-0-0-0-0',
                'leaf-0-0-0-1'
            ),
            'leaf-0-0-0'
        ),
        array(
            array(
                'leaf-0-1-0-0',
                'leaf-0-1-0-1'
            ),
            'leaf-0-1-0'
        ),
        'leaf-0-0'
    )
);

$iterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator($array),
    RecursiveIteratorIterator::SELF_FIRST

);
foreach ($iterator as $key => $leaf) {
    echo "$key => ", PHP_EOL;
    var_dump($leaf);
}