<?php

namespace Naldz\Bundle\DsnParserBundle\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Naldz\Bundle\DsnParserBundle\Tests\Helper\App\AppKernel;


class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    protected $appRoot;
    protected $kernel;
    protected $application;
    protected $commandExecutor;
    protected $env;
    protected $patchDir;

    public function setUp()
    {
        $this->kernel = new AppKernel($this->env, true);
        $this->appRoot = __DIR__.'/../Helper/App';
        //boot the kernel
        $this->kernel->boot();

        //remove the cache files from the app
        $this->fs = new FileSystem();
        $this->fs->remove(array($this->appRoot.'/cache', $this->appRoot.'/logs'));

    }

    public function testServicesAreDefined()
    {
        $container = $this->kernel->getContainer();
        $this->assertNotNull($container->get('naldz.dsnparser.driver.mysql'));
        $this->assertNotNull($container->get('naldz.dsnparser.driver.sqlite'));
        $this->assertNotNull($container->get('naldz.dsnparser.parser'));
    }
}