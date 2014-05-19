<?php
/**
 * 
 * This file is part of Aura for PHP.
 * 
 * @package Aura.View
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 */
namespace Aura\View;

/**
 * 
 * An abstract TemplateView/TwoStepView pattern implementation. We use an
 * abstract so that the extended "real" View class does not have access to the
 * private support properties herein.
 * 
 * @package Aura.View
 * 
 */
abstract class AbstractView
{
    /**
     * 
     * The content to be placed into the layout.
     * 
     * @var string
     * 
     */
    private $content;

    /**
     * 
     * Data assigned to the template.
     * 
     * @var object
     * 
     */
    private $data;

    /**
     * 
     * An aribtrary object for helpers.
     * 
     * @var object
     * 
     */
    private $helpers;

    /**
     * 
     * A collection point for section content.
     * 
     * @var array
     * 
     */
    private $section;

    /**
     * 
     * A stack of section names currently being captured.
     * 
     * @var array
     * 
     */
    private $capture;

    /**
     * 
     * The name of the layout template in the layout template registry.
     * 
     * @var string
     * 
     */
    private $layout;

    /**
     * 
     * The layout template registry.
     * 
     * @var TemplateRegistry
     * 
     */
    private $layout_registry;

    /**
     * 
     * The name of the view template in the view template registry.
     * 
     * @var string
     * 
     */
    private $view;

    /**
     * 
     * The view template registry.
     * 
     * @var TemplateRegistry
     * 
     */
    private $view_registry;

    /**
     * 
     * A template registry.
     * 
     * @var TemplateRegistry
     * 
     */
    private $template_registry;

    /**
     * 
     * Constructor.
     * 
     * @param TemplateRegistry $view_registry A registry for view templates.
     * 
     * @param TemplateRegistry $layout_registry A registry for layout templates.
     * 
     * @param object $helpers An arbitrary helper object.
     * 
     */
    public function __construct(
        TemplateRegistry $view_registry,
        TemplateRegistry $layout_registry,
        $helpers = null
    ) {
        $this->data = (object) array();
        $this->view_registry = $view_registry;
        $this->layout_registry = $layout_registry;
        if ($helpers && ! is_object($helpers)) {
            throw new Exception\InvalidHelpersObject;
        }
        $this->helpers = $helpers;
    }
    
    /**
     * 
     * Magic read access to template variables.
     * 
     * @param string $key The template variable name.
     * 
     * @return mixed
     * 
     */
    public function __get($key)
    {
        return $this->data->$key;
    }

    /**
     * 
     * Magic write access to template variables.
     * 
     * @param string $key The template variable name.
     * 
     * @param string $val The template variable value.
     * 
     * @return mixed
     * 
     */
    public function __set($key, $val)
    {
        $this->data->$key = $val;
    }

    /**
     * 
     * Magic isset() for template variables.
     * 
     * @param string $key The template variable name.
     * 
     * @return bool
     * 
     */
    public function __isset($key)
    {
        return isset($this->data->$key);
    }

    /**
     * 
     * Magic unset() for template variables.
     * 
     * @param string $key The template variable name.
     * 
     * @return null
     * 
     */
    public function __unset($key)
    {
        unset($this->data->$key);
    }

    /**
     * 
     * Magic call to expose helper object methods as template methods.
     * 
     * @param string $name The helper object method name.
     * 
     * @param array $args The arguments to pass to the helper.
     * 
     * @return mixed
     * 
     */
    public function __call($name, $args)
    {
        return call_user_func_array(array($this->helpers, $name), $args);
    }

    /**
     * 
     * Sets the content to be used in the layout.
     * 
     * @param string $content The content to be used in the layout.
     * 
     * @return void
     * 
     */
    protected function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * 
     * Gets the content to be used in the layout.
     * 
     * @return string
     * 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 
     * Sets the data object.
     * 
     * @param array|object $data An array or object where the keys or properties
     * are variable names, and the corresponding values are the variable values.
     * (This param is cast to an object.)
     * 
     * @return null
     * 
     */
    public function setData($data)
    {
        $this->data = (object) $data;
    }

    /**
     * 
     * Gets the data object.
     * 
     * @return object
     * 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 
     * Gets the arbitrary object for helpers.
     * 
     * @return object
     * 
     */
    public function getHelpers()
    {
        return $this->helpers;
    }

    /**
     * 
     * Sets the name of the layout template to render.
     * 
     * @param string $layout The name of the layout template to render.
     * 
     * @return null
     * 
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * 
     * Gets the name of the layout template to be rendered.
     * 
     * @return string
     * 
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * 
     * Gets the layout template registry.
     * 
     * @return TemplateRegistry
     * 
     */
    public function getLayoutRegistry()
    {
        return $this->layout_registry;
    }
    
    /**
     * 
     * Sets the name of the view template to render.
     * 
     * @param string $view The name of the view template to render.
     * 
     * @return null
     * 
     */
    public function setView($view)
    {
        $this->view = $view;
    }

    /**
     * 
     * Gets the name of the view template to be rendered.
     * 
     * @return string
     * 
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * 
     * Gets the view template registry.
     * 
     * @return TemplateRegistry
     * 
     */
    public function getViewRegistry()
    {
        return $this->view_registry;
    }

    /**
     * 
     * Sets the template registry.
     * 
     * @param TemplateRegistry $template_registry The template registry.
     * 
     * @return null
     * 
     */
    protected function setTemplateRegistry(TemplateRegistry $template_registry)
    {
        $this->template_registry = $template_registry;
    }

    /**
     * 
     * Gets a template from the registry and binds $this to it.
     * 
     * @param string $name The template name.
     * 
     * @return Closure
     * 
     */
    protected function getTemplate($name)
    {
        $tmpl = $this->template_registry->get($name);
        return $tmpl->bindTo($this, get_class($this));
    }

    protected function beginSection($name)
    {
        $this->capture[] = $name;
        ob_start();
    }

    protected function endSection()
    {
        $body = ob_get_clean();
        $name = array_pop($this->capture);
        $this->setSection($name, $body);
    }

    protected function setSection($name, $body)
    {
        $this->section[$name] = $body;
    }

    protected function getSection($name)
    {
        return $this->section[$name];
    }

    protected function hasSection($name)
    {
        return isset($this->section[$name]);
    }
}