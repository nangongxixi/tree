<?php

namespace j\tree\render;

use j\tree\NodeInterface;

/**
 * Class MSelect
 * @package j\tree\render
 */
class MSelect extends BaseRender {
    static $i = 0;

    public $nk = 'name';
    public $pk = 'pid';
    public $className = 'TSelect';
    public $loadName = 'jc001/region';

    public $webUrl;
    public $file;
    public $useFile = false;
    public $mul = false;

    public $name = 'cid';
    public $value = '';
    public $args = array();
    public $pcid = 0;
    public $varName;

    /**
     * put your comment there...
     *
     */
    function __construct() {
        $this->varName = 'cat' . self::$i++;
    }

    private function getJsContent($write = false){
        $pk = $this->pk;
        $nk = $this->nk;
        $className = $this->className;

        $cats = array();
        Render::traveCallback($this->data, function(NodeInterface $item) use($pk, $nk, & $cats){
            if($item->getId() == $this->pcid){
                return;
            }
            $parent = $item->getParent();
            $pid = $parent ? $parent->getId() : 0;
            $pid = $pid == $this->pcid ? 0 : $pid;
            $cats[$item->getId()] = array(
                $pk => $pid,
                $nk => $item->getName()
            );
        });

        $jsFileContent = "\n
var {$className} = Class.create();
window['{$className}'] = $className;
{$className}.CATS = " . json_encode($cats) . ";

(function(){
    var tree = {};
    var pid;
    var cats = {$className}.CATS;
    var map = {};
    var acdata = [];

    for(var cid in cats){
        pid = cats[cid]['{$pk}'];
        if(typeof(tree[pid]) != 'object'){
            tree[pid] = [];
        }
        tree[pid].push(cid);
        map[cid] = pid;
        acdata.push({'id' : cid, 'name' : cats[cid]['{$nk}']});
    }

    {$className}.pk = '" . $pk . "';
    {$className}.nk = '" . $nk . "';

    {$className}.TREE = tree;
    {$className}.MAP = map;
    {$className}.ACDATE = acdata;
})();

Object.extend({$className}.prototype, MSelect.prototype);
Object.extend({$className}.prototype, {
    init : function(){
        this.pk_name = '" . $pk . "';
        this.nk_name = '" . $nk . "';
        this.cats = {$className}.CATS;
        this.tree = {$className}.TREE;
        this.map = {$className}.MAP;
        this.acdata = {$className}.ACDATE;
    }
});
";
        if($write){
            file_put_contents($this->file, $jsFileContent);
        }

        return $jsFileContent;
    }

    /**
     * put your comment there...
     *
     */
    public function clearCache(){
        if(file_exists($this->file)){
            @unlink($this->file);
        }
    }

    public function mkJsFile() {
        $this->getJsContent(true);
    }

    public function create($name, $value = ''){
        $this->name = $name;
        $this->value = $value;
        return $this;
    }

    static $counter = 0;
    public function __toString(){
        $wrapId = 'jcSelect_' . self::$counter++;
        return <<<END
<span id="{$wrapId}"></span>
<script type="text/javascript">
require(['{$this->loadName}'], function(){
    var {$this->varName} = new {$this->className}('{$this->name}');
    {$this->onchange}
    {$this->varName}.setWrap($('#{$wrapId}'));
    {$this->varName}.render('{$this->value}', {$this->length});
});
</script>\n

END;
    }

    /**
     * @var string
     */
    protected $onchange = '';
    function onchnage($callback){
        $this->onchange = "{$this->varName}.onchange = ({$callback});\n";
        return $this;
    }

    protected $length = 1;
    function length($length){
        $this->length = intval($length);
        return $this;
    }
}