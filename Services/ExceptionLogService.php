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

  private bool $useFlattenException;

  /**
   * ExceptionLogService constructor.
   */
  public function __construct(bool $useFlattenException = true) {
    $this->useFlattenException = $useFlattenException;
  }

  /**
   * @param HttpExceptionInterface $exception
   */
  public function logHttpException(HttpExceptionInterface $exception): void {
    if (!$this->logger) {
      return;
    }

    $context = $this->createContext($exception);

    if ($exception->getStatusCode() >= 500) {
      $this->logger->error(self::MESSAGE_ERROR, $context);
    } else {
      $this->logger->info(self::MESSAGE_INFO, $context);
    }
  }

  /**
   * @param HttpExceptionInterface $exception
   *
   * @return array
   */
  protected function createContext(HttpExceptionInterface $exception): array {
    if ($this->useFlattenException) {
      return FlattenExceptionHelper::createFromThrowable($exception)->toArray();
    }

    return ['httpException' => $exception];
  }

}
