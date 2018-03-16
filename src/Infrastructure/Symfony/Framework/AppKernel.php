<?php

/*
 * This file is part of the Php DDD Standard project.
 *
 * Copyright (c) 2017-present-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Session\Infrastructure\Symfony\Framework;

use BenGorUser\DoctrineORMBridgeBundle\DoctrineORMBridgeBundle;
use BenGorUser\SimpleBusBridgeBundle\SimpleBusBridgeBundle;
use BenGorUser\SimpleBusBridgeBundle\SimpleBusDoctrineORMBridgeBundle;
use BenGorUser\SwiftMailerBridgeBundle\SwiftMailerBridgeBundle;
use BenGorUser\SymfonyRoutingBridgeBundle\SymfonyRoutingBridgeBundle;
use BenGorUser\SymfonySecurityBridgeBundle\SymfonySecurityBridgeBundle;
use BenGorUser\TwigBridgeBundle\TwigBridgeBundle;
use BenGorUser\UserBundle\BenGorUserBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle;
use Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle;
use LIN3S\Distribution\Php\Symfony\Lin3sDistributionBundle;
use LIN3S\SharedKernel\Infrastructure\Symfony\Bundle\Lin3sSharedKernelBundle;
use Sensio\Bundle\DistributionBundle\SensioDistributionBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use SimpleBus\SymfonyBridge\SimpleBusCommandBusBundle;
use SimpleBus\SymfonyBridge\SimpleBusEventBusBundle;
use SmartCore\Bundle\AcceleratorCacheBundle\AcceleratorCacheBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\Bundle\WebServerBundle\WebServerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles() : array
    {
        $bundles = array(
            new AcceleratorCacheBundle(),
            new DoctrineMigrationsBundle(),
            new DoctrineBundle(),
            new FrameworkBundle(),
            new Lin3sDistributionBundle(),
            new MonologBundle(),
            new SecurityBundle(),
            new SensioFrameworkExtraBundle(),
            new SwiftmailerBundle(),
            new TwigBundle(),

            new TwigBridgeBundle(),
            new SymfonyRoutingBridgeBundle(),
            new SymfonySecurityBridgeBundle(),
            new SwiftMailerBridgeBundle(),
            new DoctrineORMBridgeBundle(),
            new SimpleBusBridgeBundle(),
            new SimpleBusDoctrineORMBridgeBundle(),

            // User bundle
            new BenGorUserBundle(),
            new Lin3sSharedKernelBundle(),
            new SimpleBusCommandBusBundle(),
            new SimpleBusEventBusBundle(),
            new LexikJWTAuthenticationBundle()
        );

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new DebugBundle();
            $bundles[] = new WebProfilerBundle();
            $bundles[] = new SensioDistributionBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new WebServerBundle();
            }
        }

        return $bundles;
    }

    public function getRootDir() : string
    {
        return __DIR__;
    }

    public function getCacheDir() : string
    {
        return dirname(__DIR__) . '/../../../var/cache/' . $this->getEnvironment();
    }

    public function getLogDir() : string
    {
        return dirname(__DIR__) . '/../../../var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader) : void
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
