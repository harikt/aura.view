<?php
namespace aura\view\helper;
use aura\view\Helper;

/**
 * 
 * Helper for <a ... /> tags.
 * 
 */
class AnchorRaw extends AbstractHelper
{
    /**
     * 
     * Returns an anchor tag but does not escape the text; suitable for
     * wrapping an anchor around other HTML, such as an image.
     * 
     * @param string $href The anchor href specification.
     * 
     * @param string $text The text for the anchor.
     * 
     * @param array $attribs Attributes for the anchor.
     * 
     * @return string
     * 
     */
    public function __invoke($href, $text, array $attribs = array())
    {
        // escape the href, but *not* the text
        $href = $this->escape($href);
        
        // make sure we don't overwrite the href attribute
        unset($attribs['href']);
        $attr = $this->attribs($attribs);
        
        // build text and return
        return "<a href=\"$href\"$attr>$text</a>";
    }
}