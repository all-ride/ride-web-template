<?php

namespace ride\web\mvc\view;

use ride\library\mvc\exception\MvcException;
use ride\library\mvc\view\HtmlView;
use ride\library\template\Template;
use ride\library\template\TemplateFacade;

/**
 * View for a template
 */
class TemplateView implements HtmlView {

    /**
     * Instance of the template
     * @var \ride\library\template\Template
     */
    protected $template;

    /**
     * Instance of the template facade
     * @var \ride\library\template\TemplateFacade
     */
    protected $templateFacade;

    /**
     * Javascripts added to the view
     * @var array
     */
    protected $javascripts;

    /**
     * Inline javascripts added to the view
     * @var array
     */
    protected $inlineJavascripts;

    /**
     * Styles added to the view
     * @var array
     */
    protected $styles;

    /**
     * Constructs a new template view
     * @param \ride\library\template\Template $template Instance of the
     * template to render
     * @return null
     */
    public function __construct(Template $template) {
        $this->template = $template;
        $this->javascripts = array();
        $this->inlineJavascripts = array();
        $this->styles = array();
    }

    /**
     * Gets the template of this view
     * @return \ride\library\template\Template
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * Sets the template facade
     * @param \ride\library\template\TemplateFacade $templateFacade Instance of
     * the template facade
     * @return null
     */
    public function setTemplateFacade(TemplateFacade $templateFacade) {
        $this->templateFacade = $templateFacade;
    }

    /**
     * Gets the template facade
     * @return \ride\library\template\TemplateFacade
     */
    public function getTemplateFacade() {
        return $this->templateFacade;
    }

    /**
     * Renders the output for this view
     * @param boolean $willReturnValue True to return the rendered view, false
     * to send it straight to the client
     * @return null|string Null when provided $willReturnValue is set to true, the
     * rendered output otherwise
     */
    public function render($willReturnValue = true) {
        if (!$this->templateFacade) {
            throw new MvcException("Could not render template view: template facade not set, invoke setTemplateFacade() first");
        }

        $this->setResources();

        $output = $this->templateFacade->render($this->template);

        if ($willReturnValue) {
            return $output;
        }

        echo $output;
    }

    /**
     * Sets the javascripts and styles to the template app variable
     * @return null
     */
    protected function setResources() {
        if (!$this->javascripts && !$this->inlineJavascripts && !$this->styles) {
            return;
        }

        $app = $this->template->get('app', array());

        // merge javascripts
        if ($this->javascripts) {
            if (!isset($app['javascripts'])) {
                $app['javascripts'] = array();
            }
            foreach ($this->javascripts as $javascript => $null) {
                $app['javascripts'][$javascript] = true;
            }
        }

        // merge inline javascripts
        if ($this->inlineJavascripts) {
            if (!isset($app['inlineJavascripts'])) {
                $app['inlineJavascripts'] = array();
            }
            foreach ($this->inlineJavascripts as $inlineJavascript) {
                $app['inlineJavascripts'][] = $inlineJavascript;
            }
        }

        // merge styles
        if ($this->styles) {
            if (!isset($app['styles'])) {
                $app['styles'] = array();
            }
            foreach ($this->styles as $style => $null) {
                $app['styles'][$style] = true;
            }
        }

        $this->template->set('app', $app);
    }

    /**
     * Merges the javascripts and styles to this view
     * @param \ride\library\mvc\view\HtmlView $view
     * @return null
     */
    public function mergeResources(HtmlView $view) {
        $javascripts = $view->getJavascripts();
        foreach ($javascripts as $javascript) {
            $this->addJavascript($javascript);
        }

        $inlineJavascripts = $view->getInlineJavascripts();
        foreach ($inlineJavascripts as $inlineJavascript) {
            $this->addInlineJavascript($inlineJavascript);
        }

        $styles = $view->getStyles();
        foreach ($styles as $style) {
            $this->addStyle($style);
        }
    }

    /**
     * Adds a javascript file to this view
     * @param string $file Reference to a javascript file. This can be a
     * absolute URL or relative URL to the base URL
     * @return null
     */
    public function addJavascript($file) {
        $this->javascripts[$file] = true;
    }

    /**
     * Gets all the javascript files which are added to this view
     * @return array
    */
    public function getJavascripts() {
        return array_keys($this->javascripts);
    }

    /**
     * Removes a javascript file from this view
     * @param string $file Reference to the javascript file
     * @return boolean True when the javascript has been removed, false
     * otherwise
     * @see addJavascript
     */
    public function removeJavascript($file) {
        if (!isset($this->javascripts[$file])) {
            return false;
        }

        unset($this->javascripts[$file]);

        return true;
    }

    /**
     * Adds a inline javascript to this view
     * @param string $script Javascript code to add
     * @return null
     */
    public function addInlineJavascript($script) {
        $this->inlineJavascripts[] = $script;
    }

    /**
     * Gets all the inline javascripts
     * @return array
    */
    public function getInlineJavascripts() {
        return $this->inlineJavascripts;
    }

    /**
     * Removes a inline javascript from this view
     * @param string $script Javascript code to remove
     * @return boolean True if the script is found and removed, false otherwise
     * @see addInlineJavascript
    */
    public function removeInlineJavascript($script) {
        foreach ($this->inlineJavascripts as $index => $inlineJavascript) {
            if ($inlineJavascript == $script) {
                unset($this->inlineJavascripts[$index]);

                return true;
            }
        }

        return false;
    }

    /**
     * Adds a stylesheet file to this view
     * @param string $file Reference to a CSS file. This can be a absolute URL
     * or a relative URL to the base URL
     * @return null
     */
    public function addStyle($file) {
        $this->styles[$file] = true;
    }

    /**
     * Gets all the stylesheets which are added to this view
     * @return array
     */
    public function getStyles() {
        return array_keys($this->styles);
    }

    /**
     * Removes a stylesheet file from this view
     * @param string $file Reference to the css file
     * @return null
     * @see addStyle
     */
    public function removeStyle($file) {
        if (!isset($this->styles[$file])) {
            return false;
        }

        unset($this->styles[$file]);

        return true;
    }

}