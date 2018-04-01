<?php
/*
 * (c) 2018 dazz <dazz@c-base.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Security\Factory;

use App\Security\Authentication\LdapBindAuthenticationProvider;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\JsonLoginFactory;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class JsonLoginLdapBindFactory extends JsonLoginFactory
{

    public function addConfiguration(NodeDefinition $node)
    {
        parent::addConfiguration($node);

        $node
            ->children()
                ->scalarNode('service')->defaultValue('ldap')->end()
                ->scalarNode('query_string')->isRequired()->example('uid={username},dn=example,dc=org')->end()
                ->booleanNode('hide_user_not_found')->defaultTrue()->end()
            ->end()
        ;
    }

    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {
        $provider = 'security.authentication.provider.ldap_bind.'.$id;
        $container
            ->setDefinition($provider, new ChildDefinition(LdapBindAuthenticationProvider::class))
            ->setArgument(0, $id)
            ->setArgument(1, new Reference($config['service']))
            ->setArgument(2, $config['query_string'])
            ->setArgument(3, $config['hide_user_not_found'])
        ;
        return $provider;
    }

    public function getKey()
    {
        return 'json-login-ldap-bind';
    }
}
