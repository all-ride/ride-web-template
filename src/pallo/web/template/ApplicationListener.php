<?php

namespace pallo\web\template;

use pallo\library\config\Config;
use pallo\library\dependency\DependencyInjector;
use pallo\library\event\Event;

use pallo\web\mvc\view\TemplateView;

/**
 * Event listeners for the pallo-web-template module
 */
class ApplicationListener {

    /**
     * Event listener to inject the template engine in the template view of the
     * response
     * @param pallo\library\event\Event $event
     * @return null
     */
    public function injectTemplateEngine(Event $event, Config $config, DependencyInjector $dependencyInjector) {
        $web = $event->getArgument('web');
        $response = $web->getResponse();
        if (!$response) {
            return;
        }

        $view = $response->getView();
        if (!$view instanceof TemplateView || $view->getTemplateFacade()) {
            return;
        }

        $templateFacade = $dependencyInjector->get('pallo\\library\\template\\TemplateFacade');

        $view->setTemplateFacade($templateFacade);
    }

}