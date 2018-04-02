<?php
/*
 * (c) 2018 dazz <dazz@c-base.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException;


class ExceptionListener
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $content = [
            'status' => 0,
        ];
        $response = new JsonResponse();

        $exception = $event->getException();

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());

            $content['status'] = $exception->getStatusCode();
            $content['error'] = $exception->getMessage();

            $this->logger->debug($content['error']);
        } else if ($this->isUnauthorized($exception)) {
            $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
            $content['status'] = Response::HTTP_UNAUTHORIZED;
            $content['error'] = 'Unauthorized';

            $this->logger->info($content['error']);
        } else {
            $content['status'] = Response::HTTP_INTERNAL_SERVER_ERROR;
            $content['error'] = 'Server Error';
            $this->logger->error($content['error'], $event->getException()->getTrace());
        }

        $response->setContent(json_encode($content));
        $response->headers->add(['CONTENT_TYPE' => 'application/json']);


        $event->setResponse($response);
    }

    /**
     * @param \Exception $exception
     * @return bool
     */
    private function isUnauthorized($exception): bool
    {
        return (
            $exception instanceof AccessDeniedException ||
            $exception instanceof InsufficientAuthenticationException ||
            $exception instanceof BadCredentialsException
        );
    }
}
