<?php


namespace HalloVerden\HttpExceptionsBundle\Helpers;


use Symfony\Component\ErrorHandler\Exception\FlattenException;

/**
 * Class FlattenExceptionHelper
 *
 * Holds a copy of flatten exception to avoid running create more than once.
 *
 * @package HalloVerden\HttpExceptionsBundle\Helpers
 */
class FlattenExceptionHelper extends FlattenException {

  /**
   * @var array<int, FlattenExceptionHelper>
   */
  private static array $exceptions = [];

  /**
   * @inheritDoc
   */
  public static function createFromThrowable(\Throwable $exception, int $statusCode = null, array $headers = []): static {
    $id = \spl_object_id($exception);

    if (isset(static::$exceptions[$id])) {
      return static::$exceptions[$id];
    }

    return static::$exceptions[$id] = parent::createFromThrowable($exception, $statusCode, $headers);
  }

}
