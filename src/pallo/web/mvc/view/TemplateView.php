<?php

namespace pallo\web\mvc\view;

use pallo\library\mvc\exception\MvcException;
use pallo\library\mvc\view\View;
use pallo\library\template\Template;
use pallo\library\template\TemplateFacade;

/**
 * View for a template
 */
class TemplateView implements View {

    /**
     * Instance of the template
     * @var pallo\library\template\Template
     */
    protected $template;

    /**
     * Instance of the template facade
     * @var pallo\library\template\TemplateFacade
     */
    protected $templateFacade;

    /**
     * Constructs a new template view
     * @param pallo\library\template\Template $template Instance of the
     * template to render
     * @return null
     */
    public function __construct(Template $template) {
        $this->template = $template;
    }

    /**
     * Gets the template of this view
     * @return pallo\library\template\Template
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * Sets the template facade
     * @param pallo\library\template\TemplateFacade $templateFacade Instance of
     * the template facade
     * @return null
     */
    public function setTemplateFacade(TemplateFacade $templateFacade) {
        $this->templateFacade = $templateFacade;
    }

    /**
     * Gets the template facade
     * @return pallo\library\template\TemplateFacade
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

        $output = $this->templateFacade->render($this->template);

        if ($willReturnValue) {
            return $output;
        }

        echo $output;
    }

}