<?php


namespace HalloVerden\HttpExceptionsBundle\Services;


use HalloVerden\HttpExceptions\Http\HttpException;
use HalloVerden\HttpExceptions\InternalServerErrorException;
use HalloVerden\HttpExceptionsBundle\Interfaces\Services\ExceptionConverterServiceInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionConverterService implements ExceptionConverterServiceInterface {
  const ERROR_UNKNOWN = 'UNKNOWN_ERROR';

  /**
   * @param \Throwable $throwable
   *
   * @return HttpExceptionInterface
   */
  public function createHttpExceptionFromThrowable(\Throwable $throwable): HttpExceptionInterface {
    if ($throwable instanceof HttpException) {
      return $throwable;
    }

    return new InternalServerErrorException(self::ERROR_UNKNOWN, $throwable);
  }

}
