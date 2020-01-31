<?php


namespace HalloVerden\HttpExceptionsBundle\Interfaces\Services;


use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

interface ExceptionLogServiceInterface {

  /**
   * @param HttpExceptionInterface $exception
   */
  public function logHttpException(HttpExceptionInterface $exception): void;
}
