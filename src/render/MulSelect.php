<?php

namespace j\tree\render;

/**
 * Class MulSelect
 * @package j\tree\render
 */
class MulSelect extends MSelect {

    protected $load = array('<script type="text/javascript">jc001.load("mselect.mul")</script>');

    /**
     * @return string
     */
    public function __toString(){
        $value = $this->value;

        if(!$value){
            $value = array();
        }elseif(is_string($value)){
            $value = explode(',', $value);
        }elseif(!is_array($value)){
            $value = array($value);
        }
        $value = json_encode(array_values($value));


        $params = $this->args;
        if(!isset($params['maxSel'])){
            $params['maxSel'] = 4;
        }
        $args = json_encode($params);
        // js
    return <<<ST
<script type="text/javascript">
var {$this->varName} = new MSelectMul({$this->className});
{$this->varName}.render('{$this->name}', {$value}, {$args});
</script>\n
ST;
    }
}
