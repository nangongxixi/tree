<?php

namespace j\tree\render;

use j\tree\Node;
use j\tree\tool\Select as HtmlSelect;

/**
 * Class Select
 * @package j\tree\render
 */
class Select extends BaseRender{
    protected $name;
    protected $value;
    protected $params = array();
    public $elementClass = 'j\\tree\\tool\\Select';

    public function create($name, $value = '', $params = array()){
        $this->name = $name;
        $this->value = $value;
        $this->params = $params;
        return $this;
    }

    protected $element;

    public function getElement(){
        if(isset($this->element)){
            return $this->element;
        }

        /** @var HtmlSelect $input */
        $input = new $this->elementClass();
        $input->setAttr([
            'name' => $this->name,
            'value' => $this->value,
        ]);
        $this->element = $input;
        return $input;
    }

    function toString() {
        $values = array();
        Render::traveCallback($this->data, function(Node $item) use(& $values){
            if($item->id <= 0){
                return;
            }
            $values[$item->id] = array(
                $item->getName(),
                $item->getDeep()
            );
        });

        $separator = isset($this->params['separator']) ? $this->params['separator'] : '' ;
        if(!$separator){
            $separator = '&nbsp;';
        };

        $select = array();
        foreach ($values as $cid => $item) {
            $space = str_repeat($separator, 2 * ($item[1]));
            $select[$cid] = $space . $item[0];
        }
        $input = $this->getElement();
        $input->setOptions($select);
        return $input . '';
    }

    function __toString(){
        return $this->toString();
    }
}
