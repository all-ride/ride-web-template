<?php

namespace pallo\web\mvc\controller;

use pallo\web\mvc\view\TemplateView;

/**
 * Controller to render a template
 */
class TemplateController extends AbstractController {

    /**
     * Action to render a template
     * @param string $resource Resource of the template
     * @return null
     */
    public function renderAction($resource) {
        $templateEngineId = $this->config->get('template.engine');
        $templateEngine = $this->dependencyInjector->get('pallo\\library\\template\\TemplateEngine', $templateEngineId);

        $template = $templateEngine->createTemplate($resource);

        $view = new TemplateView($template);
        $view->setTemplateEngine($templateEngine);

        $this->response->setView($view);
    }

}