<?php

namespace pallo\web\mvc\view;

use pallo\library\mvc\exception\MvcException;
use pallo\library\mvc\view\View;
use pallo\library\template\Template;
use pallo\library\template\TemplateEngine;

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
     * Instance of the template engine
     * @var pallo\library\template\TemplateEngine
     */
    protected $templateEngine;

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
     * Sets the template engine for this template
     * @param pallo\library\template\TemplateEngine $templateEngine Instance of
     * the template engine
     * @return null
     */
    public function setTemplateEngine(TemplateEngine $templateEngine) {
        $this->templateEngine = $templateEngine;
    }

    /**
     * Gets the template engine from this template
     * @return pallo\library\template\TemplateEngine
     */
    public function getTemplateEngine() {
        return $this->templateEngine;
    }

    /**
     * Renders the output for this view
     * @param boolean $willReturnValue True to return the rendered view, false
     * to send it straight to the client
     * @return null|string Null when provided $willReturnValue is set to true, the
     * rendered output otherwise
     */
    public function render($willReturnValue = true) {
        if (!$this->templateEngine) {
            throw new MvcException("Could not render template view: no template engine set, invoke setTemplateEngine() first");
        }

        $output = $this->templateEngine->render($this->template);

        if ($willReturnValue) {
            return $output;
        }

        echo $output;
    }

}