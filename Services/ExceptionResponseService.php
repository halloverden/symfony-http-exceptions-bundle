<?php


namespace HalloVerden\HttpExceptionsBundle\Services;


use HalloVerden\HttpExceptions\DataExceptionInterface;
use HalloVerden\HttpExceptionsBundle\Helpers\FlattenExceptionHelper;
use HalloVerden\HttpExceptionsBundle\Interfaces\Services\ExceptionResponseServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionResponseService implements ExceptionResponseServiceInterface {

  /**
   * @var bool
   */
  private $debug;

  /**
   * ExceptionResponseService constructor.
   *
   * @param bool $debug
   */
  public function __construct(bool $debug = false) {
    $this->debug = $debug;
  }

  /**
   * @param HttpExceptionInterface $exception
   *
   * @return Response
   */
  public function createResponseFromHttpException(HttpExceptionInterface $exception): Response {
    // Note: Encoding options needs to be set before data
    return (new JsonResponse(null, $exception->getStatusCode(), $exception->getHeaders()))
      ->setEncodingOptions(JsonResponse::DEFAULT_ENCODING_OPTIONS | JSON_INVALID_UTF8_IGNORE)
      ->setData($this->getData($exception));
  }

  /**
   * @param HttpExceptionInterface $exception
   *
   * @return array
   */
  protected function getData(HttpExceptionInterface $exception): array {
    $data = null;

    if ($exception instanceof DataExceptionInterface) {
      $data = $exception->getData();
    }

    if (!$data) {
      $data = [
        'error' => $exception->getMessage()
      ];
    }

    if ($this->debug) {
      $data['debug'] = FlattenExceptionHelper::createFromThrowable($exception)->toArray();
    }

    return $data;
  }

}
