<?php


namespace HalloVerden\HttpExceptionsBundle\Interfaces\Services;


use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

interface ExceptionConverterServiceInterface {

  /**
   * @param \Throwable $throwable
   *
   * @return HttpExceptionInterface
   */
  public function createHttpExceptionFromThrowable(\Throwable $throwable): HttpExceptionInterface;
}
