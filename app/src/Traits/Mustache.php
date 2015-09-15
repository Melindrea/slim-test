<?php

namespace Lees\Traits;

use Underscore\Types\Strings;

trait Mustache
{
    protected function renderMustache(\Slim\App $app, $class, $template = null)
    {
        if ($template === null) {
            $template = explode('\\', get_class($class));
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

        return $app->view->render($template, $class);
    }
}
