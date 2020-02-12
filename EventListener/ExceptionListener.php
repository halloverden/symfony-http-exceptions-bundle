<?php


namespace HalloVerden\HttpExceptionsBundle\EventListener;

use HalloVerden\HttpExceptionsBundle\Interfaces\Services\ExceptionConverterServiceInterface;
use HalloVerden\HttpExceptionsBundle\Interfaces\Services\ExceptionLogServiceInterface;
use HalloVerden\HttpExceptionsBundle\Interfaces\Services\ExceptionResponseServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionListener implements EventSubscriberInterface {

  /**
   * @var ExceptionConverterServiceInterface
   */
  private $exceptionConverterService;

  /**
   * @var ExceptionLogServiceInterface
   */
  private $logExceptionService;

  /**
   * @var ExceptionResponseServiceInterface
   */
  private $exceptionResponseService;

  /**
   * ExceptionListener constructor.
   *
   * @param ExceptionConverterServiceInterface $exceptionConverterService
   * @param ExceptionLogServiceInterface       $logExceptionService
   * @param ExceptionResponseServiceInterface  $exceptionResponseService
   */
  public function __construct(ExceptionConverterServiceInterface $exceptionConverterService,
                              ExceptionLogServiceInterface $logExceptionService,
                              ExceptionResponseServiceInterface $exceptionResponseService) {
    $this->exceptionConverterService = $exceptionConverterService;
    $this->logExceptionService = $logExceptionService;
    $this->exceptionResponseService = $exceptionResponseService;
  }

  /**
   * @param ExceptionEvent $event
   */
  public function convertKernelException(ExceptionEvent $event) {
    $throwable = $event->getThrowable();

    if (!$throwable instanceof HttpExceptionInterface) {
      $event->setThrowable($this->exceptionConverterService->createHttpExceptionFromThrowable($event->getThrowable()));
    }
  }

  /**
   * @param ExceptionEvent $event
   */
  public function logKernelException(ExceptionEvent $event) {
    $exception = $event->getThrowable();
    if (!$exception instanceof HttpExceptionInterface) {
      return;
    }

    $this->logExceptionService->logHttpException($exception);
  }


  /**
   * @param ExceptionEvent $event
   */
  public function onKernelException(ExceptionEvent $event) {
    $exception = $event->getThrowable();
    if (!$exception instanceof HttpExceptionInterface) {
      return;
    }

    $event->setResponse($this->exceptionResponseService->createResponseFromHttpException($exception));
  }

  /**
   * @inheritDoc
   */
  public static function getSubscribedEvents() {
    return array(
      KernelEvents::EXCEPTION => [
        ['convertKernelException', -1],
        ['logKernelException', -3],
        ['onKernelException', -5]
      ],
    );
  }
}
