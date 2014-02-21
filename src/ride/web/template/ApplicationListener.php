<?php

namespace ride\web\template;

use ride\library\config\Config;
use ride\library\dependency\DependencyInjector;
use ride\library\event\Event;

use ride\web\mvc\view\TemplateView;

/**
 * Event listeners for the ride-web-template module
 */
class ApplicationListener {

    /**
     * Event listener to inject the template engine in the template view of the
     * response
     * @param ride\library\event\Event $event
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

        $templateFacade = $dependencyInjector->get('ride\\library\\template\\TemplateFacade');

        $view->setTemplateFacade($templateFacade);
    }

}