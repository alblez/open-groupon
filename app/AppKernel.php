<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JavierEguiluz\Bundle\EasyAdminBundle\EasyAdminBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new AppBundle\AppBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
<<<<<<< HEAD
        // Si tu file YAML contiene code PHP, utiliza el siguiente code:
        //
        // use Symfony\Component\Yaml\Yaml;
        //
        // Yaml::setPhpParsing(true);
        // $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
        // Yaml::setPhpParsing(false);

||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
        // Si tu file YAML contiene code PHP, utiliza el siguiente code:
        //
        // use Symfony\Component\Yaml\Yaml;
        //
        // Yaml::setPhpParsing(true);
        // $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
        // Yaml::setPhpParsing(false);

=======
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
