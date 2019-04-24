<?php
# TreeTest.php
namespace j\tree\tests;

use j\db\Table;
use j\debug\Timer;
use j\tree\BaseTree;
use j\tree\BTree;
use j\tree\CounterTree;
use j\tree\DbTree;
use j\tree\Tree;
use j\tree\TreeInterface;

require __DIR__ . '/init.php';

/**
 * @param BaseTree|Tree $tree
 * @param $cats
 * @param $dataProvider
 */
function __count($tree, $cats, $dataProvider = null){
//    echo "Get top cats:\n";
//    $root = $tree->getElementById(0);
//    foreach($root as $item){
//        echo $item . "\n";
//    }

    $timer = new Timer();
    $timer->start();

    if($dataProvider){
        $tree->setSource(call_user_func($dataProvider));
    }

    echo "\n counter:\n";
    $countTree = new CounterTree($tree, $cats);
    foreach($countTree->getRoot() as $item){
        echo $item . "({$item['nums']})" . "\n";
    }

    echo "Times:" . $timer->stop() . "\n";
    echo "\n\n";
}

$table = Table::factory('gdclass');
$cats = getGdNumsMap();
$cids = $table->find([
    'classid' => array_keys($cats),
    '_fields' => ['id', 'classid'],
])->toArray('classid', 'id');

foreach($cats as $aid => $n){
    if(isset($cids[$aid])){
        $cid = $cids[$aid];
        $cats[$cid] = $n;
    }
    unset($cats[$aid]);
}

$dataProvider = function() use($table){
    return $table->find([
        '_fields' => ['id', 'name', 'pid'],
        'weblabel' => 1
    ]);
};

$treeDb = DbTree::getInstance();
$treeDb->setSource($table, ['weblabel' => 1]);

$BTree = BTree::getInstance();
$tree = Tree::getInstance();

__count($treeDb, $cats);
__count($tree, $cats, $dataProvider);
__count($BTree, $cats, $dataProvider);
