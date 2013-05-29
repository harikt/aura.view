<?php
/**
 * 
 * This file is part of the Aura Project for PHP.
 * 
 * @package Aura.Html
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 */
namespace Aura\Html\Helper\Form;

/**
 * 
 * A series of HTML radio elements with the same name.
 * 
 * @package Aura.Html
 * 
 */
class Radios extends AbstractElement
{
    protected $radio;
    
    /**
     * 
     * Constructor.
     * 
     * @param InputChecked $input A checked-input helper for generating buttons.
     * 
     */
    public function __construct(Radio $radio)
    {
        $this->radio = $radio;
    }
    
    /**
     * 
     * Returns the HTML for the element.
     * 
     * @return string
     * 
     */
    protected function html()
    {
        $this->attribs['type'] = 'radio';
        $radio = $this->radio;
        $html = '';
        foreach ($options as $value => $label) {
            $this->attribs['value'] = $value;
            $this->attribs['label'] = $label;
            $html .= $radio($this->attribs, $this->value);
        }
        return $html;
    }
}