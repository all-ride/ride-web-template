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
    public function renderAction(TemplateFacade $templateFacade, $resource) {
        $template = $templateFacade->createTemplate($resource);

        $view = new TemplateView($template);
        $view->setTemplateFacade($templateFacade);

        $this->response->setView($view);
    }

}