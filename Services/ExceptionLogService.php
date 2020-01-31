<?php


namespace HalloVerden\HttpExceptionsBundle\Services;


use HalloVerden\HttpExceptionsBundle\Helpers\FlattenExceptionHelper;
use HalloVerden\HttpExceptionsBundle\Interfaces\Services\ExceptionLogServiceInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionLogService implements ExceptionLogServiceInterface {
  use LoggerAwareTrait;

  /**
   * @param HttpExceptionInterface $exception
   */
  public function logHttpException(HttpExceptionInterface $exception): void {
    if (!$this->logger) {
      return;
    }

    $context = FlattenExceptionHelper::createFromThrowable($exception)->toArray();
    if ($exception->getStatusCode() >= 500) {
      $this->logger->error("InternalServerError", $context);
    } else {
      $this->logger->info("Exception was thrown", $context);
    }
  }

}
