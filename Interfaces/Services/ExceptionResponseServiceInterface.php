<?php


namespace HalloVerden\HttpExceptionsBundle\Interfaces\Services;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

interface ExceptionResponseServiceInterface {

  /**
   * @param HttpExceptionInterface $exception
   *
   * @return Response
   */
  public function createResponseFromHttpException(HttpExceptionInterface $exception): Response;
}
