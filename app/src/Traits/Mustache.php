<?php
/**
 * src/Traits/Mustache.php
 *
 * Contains the Trait Mustache
 *
 * @package Lees
 * @author Marie Hogebrandt <iam@mariehogebrandt.se>
 * @copyright 2014-2015 Lokal E-handel
 */

namespace Lees\Traits;
use Underscore\Types\Strings;

/** Adds protected method `renderMustache` */
trait Mustache
{
  /**
    * Renders a Mustache template based on a given ViewModel, or template
    *
    * @param \Slim\App $app The current instance of the App
    * @param Object $viewModel Class to find template-name
    * @param string $template Optional, explicitely set template
    *
    * @return string
    */
    protected function renderMustache(\Slim\App $app, $viewModel, $template = null)
    {
        if ($template === null) {
            $template = explode('\\', get_class($viewModel));
            array_shift($template);
            array_shift($template);
            $template = array_map(
                function ($item) {
                    return Strings::slugify(Strings::toSnakeCase($item));
                },
                $template
            );
            $template = implode('/', $template);
        }

        return $app->view->render($template, $viewModel);
    }
}
