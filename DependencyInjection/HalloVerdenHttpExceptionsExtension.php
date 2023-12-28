<?php


namespace HalloVerden\HttpExceptionsBundle\DependencyInjection;


use HalloVerden\HttpExceptionsBundle\Interfaces\Services\ExceptionLogServiceInterface;
use HalloVerden\HttpExceptionsBundle\Services\ExceptionLogService;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class HalloVerdenHttpExceptionsExtension extends ConfigurableExtension {

  /**
   * @inheritDoc
   * @throws \Exception
   */
  protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void {
    $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('services.yaml');

    $exceptionLog = $container->getDefinition(ExceptionLogServiceInterface::class);
    if ($exceptionLog->getClass() === ExceptionLogService::class) {
      $exceptionLog->setArgument('$useFlattenException', $mergedConfig['exception_log']['use_flatten_exception']);
    }
  }
}
