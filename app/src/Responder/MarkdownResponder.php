<?php

namespace Lees\Responder;

use Lees\Library;

class MarkdownResponder extends MustacheResponder
{
    public function __construct(
        \Slim\App $app,
        \Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response,
        $pageName = null
    ) {
        $content = sprintf('Fake 404. Please fix this. Page: %s', $request->getRequestTarget());

        $realPageName = realpath(
            sprintf(
                '%spages/%s%s',
                CONTENT_PATH,
                $pageName,
                VIEW_EXT
            )
        );
        if ($pageName && file_exists($realPageName) && is_file($realPageName)) {
                $loadedPage = new \FrontMatter($realPageName);

                $content = Library\Markdown::transform(
                    $loadedPage->fetch('content')
                );
        }

        parent::__construct($app, $request, $response, $content);
    }
}
