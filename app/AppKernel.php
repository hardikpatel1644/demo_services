<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel {

    public function registerBundles() {
        $bundles = array(
            // Symfony Bundles
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            
            // Doctrine bundles
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),

            // Core bundles
            new Ixoil\CoreBundle\IxoilCoreBundle(),
            
            // CMS and static pages bundles
            new Ixoil\CmsBundle\IxoilCmsBundle(),

            // Admin bundles
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Ixoil\AdminBundle\IxoilAdminBundle(),
            
            // User bundles
            new FOS\UserBundle\FOSUserBundle(),
            new Sonata\UserBundle\SonataUserBundle("FOSUserBundle"),
            new Ixoil\UserBundle\IxoilUserBundle(),
            
            // Account bundles
            new Ixoil\PurchaserBundle\IxoilPurchaserBundle(),
            // TODO: ProviderBundle
            // TODO: LogisticianBundle
            
            // Stock market bundles
            new Ixoil\StockMarketBundle\IxoilStockMarketBundle(),
            
            // Utility bundles
            new Ixoil\EmailBundle\IxoilEmailBundle(),
            new Ixoil\JVectorMapBundle\IxoilJVectorMapBundle(),
            new Ixoil\FileBundle\IxoilFileBundle(),
            
            // JMS Security bundles
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),

            // Sonata bundles
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\jQueryBundle\SonatajQueryBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\CacheBundle\SonataCacheBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
            
            // Misc vendor bundles
            new Ali\DatatableBundle\AliDatatableBundle(),
            new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
            new Craue\FormFlowBundle\CraueFormFlowBundle(),
            new Codingfogey\Bundle\FontAwesomeBundle\CodingfogeyFontAwesomeBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Shtumi\UsefulBundle\ShtumiUsefulBundle(),
            new WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Elao\WebProfilerExtraBundle\WebProfilerExtraBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader) {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }

}
