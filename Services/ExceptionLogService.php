<?php


namespace HalloVerden\HttpExceptionsBundle\Services;


use HalloVerden\HttpExceptionsBundle\Helpers\FlattenExceptionHelper;
use HalloVerden\HttpExceptionsBundle\Interfaces\Services\ExceptionLogServiceInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionLogService implements ExceptionLogServiceInterface {
  use LoggerAwareTrait;

  const MESSAGE_ERROR = 'InternalServerError';
  const MESSAGE_INFO = 'Exception was thrown';

  /**
   * @param HttpExceptionInterface $exception
   */
  public function logHttpException(HttpExceptionInterface $exception): void {
    if (!$this->logger) {
      return;
    }

    $context = FlattenExceptionHelper::createFromThrowable($exception)->toArray();
    if ($exception->getStatusCode() >= 500) {
      $this->logger->error(self::MESSAGE_ERROR, $context);
    } else {
      $this->logger->info(self::MESSAGE_INFO, $context);
    }
  }

}
