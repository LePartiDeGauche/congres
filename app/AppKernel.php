<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // Default Symfony install
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),

            // FOSUserBundle
            new FOS\UserBundle\FOSUserBundle(),

            // Sonata Admin
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),

            // Knp
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),

            // PayBox
            new Lexik\Bundle\PayboxBundle\LexikPayboxBundle(),

            new PUGX\AutocompleterBundle\PUGXAutocompleterBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),

            // Our app
            new AppBundle\AppBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Alex\DoctrineExtraBundle\AlexDoctrineExtraBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }

    public function getCacheDir() {
        if (!empty($this->getEnvParameters()['kernel.cache_dir'])) {
            return $this->getEnvParameters()['kernel.cache_dir'].'/'.$this->environment;
        } else {
            return parent::getCacheDir();
        }
    }

    public function getLogDir()
    {
        if (!empty($this->getEnvParameters()['kernel.logs_dir'])) {
            return $this->getEnvParameters()['kernel.logs_dir'].'/'.$this->environment;
        } else {
            return parent::getLogDir();
        }
    }
}
