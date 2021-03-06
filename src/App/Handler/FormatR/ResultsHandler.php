<?php

declare(strict_types=1);

namespace App\Handler\FormatR;

use App\Reader\FormatR\Result;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class ResultsHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $year = $request->getAttribute('year');
        $type = $request->getAttribute('type');

        $params = $request->getQueryParams();
        $test = isset($params['test']);
        $final = $test && isset($params['final']);

        $result = new Result(intval($year), $type, $test, $final);

        $results = $result->getResults();

        return new JsonResponse($results, 200, [
            'Cache-Control' => 'max-age=300, public',
        ]);
    }
}
