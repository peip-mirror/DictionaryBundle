<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\Dictionary\Collection;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DictionaryRegistrationPass implements CompilerPassInterface
{
    const TAG_DICTIONARY = 'knp_dictionary.dictionary';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $dictionaries = $container->getDefinition(Collection::class);
        $services     = $container->findTaggedServiceIds(self::TAG_DICTIONARY);

        foreach (array_keys($services) as $id) {
            $dictionaries->addMethodCall('add', [new Reference($id)]);
        }
    }
}
