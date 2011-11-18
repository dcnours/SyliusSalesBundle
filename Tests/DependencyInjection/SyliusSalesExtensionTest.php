<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SalesBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Sylius\Bundle\SalesBundle\DependencyInjection\SyliusSalesExtension;
use Symfony\Component\Yaml\Parser;

class SyliusSalesExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testUserLoadThrowsExceptionUnlessDriverSet()
    {
        $loader = new SyliusSalesExtension();
        $config = $this->getEmptyConfig();
        unset($config['driver']);
        $loader->load(array($config), new ContainerBuilder());
    }
    
    /**
    * @expectedException \InvalidArgumentException
    */
    public function testUserLoadThrowsExceptionUnlessDriverIsValid()
    {
        $loader = new SyliusSalesExtension();
        $config = $this->getEmptyConfig();
        $config['driver'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }
    
    /**
    * @expectedException \InvalidArgumentException
    */
    public function testUserLoadThrowsExceptionUnlessEngineIsValid()
    {
        $loader = new SyliusSalesExtension();
        $config = $this->getEmptyConfig();
        $config['engine'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }
    
    /**
    * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
    */
    public function testUserLoadThrowsExceptionUnlessOrderModelClassSet()
    {
        $loader = new SyliusSalesExtension();
        $config = $this->getEmptyConfig();
        unset($config['classes']['model']['order']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * getEmptyConfig
     *
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml = <<<EOF
driver: ORM
classes:
    model:
        order: Sylius\Bundle\SalesBundle\Entity\DefaultOrder
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }
}