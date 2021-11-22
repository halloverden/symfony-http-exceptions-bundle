<?php

namespace HalloVerden\HttpExceptionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package HalloVerden\HttpExceptionsBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface {

  /**
   * @inheritDoc
   */
  public function getConfigTreeBuilder(): TreeBuilder {
    $treeBuilder = new TreeBuilder('hallo_verden_http_exceptions');

    $treeBuilder->getRootNode()
      ->addDefaultChildrenIfNoneSet()
      ->children()
        ->arrayNode('exception_log')
          ->children()
            ->booleanNode('use_flatten_exception')->defaultTrue()->end()
          ->end()
        ->end()
      ->end();

    return $treeBuilder;
  }

}
