<?php

namespace j\tree\tool;

/**
 * Class Select
 * @package j\tree\tool
 */
class Select {
    use TraitAttrs;

    protected $pattern = "<select%s>\n%s</select>\n";
    protected $options = [];
    protected $defaultClass = '';

    function __construct() {
        $this->addNotEmptyKey(['maxlength']);
    }

    protected $choose = '';
    function setDefaultChoose($value){
        $this->choose = $value;
    }

    public function setOptions($value){
        $this->options = $value;
    }

    function __toString() {
        $options = $this->genOptions();
        $attrs = $this->asString();
        return sprintf($this->pattern, $attrs, $options);
    }

    protected function genOptions(){
        $options = $this->getAttr('options', [], true);
        if(!$options) {
            $options = $this->options;
        }

        $html = "";
        $select = false;
        $sel = $this->getAttr('value', '', true);

        if($this->choose){
            $select = ($sel === '') ? ' selected' : '';
            $html = "\t<option value='' {$select}>{$this->choose}</option>\n";
        }

        foreach($options as $key => $title){
            $select = !$select && ($sel == $key) ? ' selected="true"' : '';
            $html .= "\t<option value=\"{$key}\"{$select}>{$title}</option>\n";
        }

        return $html;
    }
}
