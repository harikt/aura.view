<?php
namespace aura\view\helper;

/**
 * Test class for Anchor.
 * Generated by PHPUnit on 2011-04-02 at 08:27:59.
 */
class AnchorTest extends \PHPUnit_Framework_TestCase
{
    public function test__invoke()
    {
        $href = '/path/to/script.php?foo=bar&zim=gir';
        $anchor = new Anchor;
        $actual = $anchor($href, '<this>');
        $expect = '<a href="/path/to/script.php?foo=bar&amp;zim=gir">&lt;this&gt;</a>';
        $this->assertSame($expect, $actual);
    }
}