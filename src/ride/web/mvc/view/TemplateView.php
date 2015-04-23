<?php

namespace ride\web\mvc\view;

use ride\library\mvc\exception\MvcException;
use ride\library\mvc\view\AbstractHtmlView;
use ride\library\template\Template;
use ride\library\template\TemplateFacade;

/**
 * View for a template
 */
class TemplateView extends AbstractHtmlView {

    /**
     * Instance of the template
     * @var ride\library\template\Template
     */
    protected $template;

    /**
     * Instance of the template facade
     * @var ride\library\template\TemplateFacade
     */
    protected $templateFacade;

    /**
     * Constructs a new template view
     * @param ride\library\template\Template $template Instance of the
     * template to render
     * @return null
     */
    public function __construct(Template $template) {
        $this->template = $template;
    }

    /**
     * Gets the template of this view
     * @return ride\library\template\Template
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * Sets the template facade
     * @param ride\library\template\TemplateFacade $templateFacade Instance of
     * the template facade
     * @return null
     */
    public function setTemplateFacade(TemplateFacade $templateFacade) {
        $this->templateFacade = $templateFacade;
    }

    /**
     * Gets the template facade
     * @return ride\library\template\TemplateFacade
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

}
