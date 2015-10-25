<?php

namespace FreezyBee\MojeId\DI;

use FreezyBee\MojeId\Attributes;
use FreezyBee\MojeId\Policy;
use Nette\DI\CompilerExtension;
use Nette\Utils\AssertionException;
use Nette\Utils\Validators;

/**
 * Class MojeIdExtension
 * @package FreezyBee\MojeId\DI
 */
class MojeIdExtension extends CompilerExtension
{
    private $defaults = [
        'serverUrl' => 'https://mojeid.cz/',
        'policy' => [],
        'fieldsType' => 'simple',
        'debugger' => '%debugMode%',
        'tempDir' => '%tempDir%'
    ];

    public function loadConfiguration()
    {
        $config = $this->getConfig($this->defaults);

        // serverUrl
        Validators::assert($config['serverUrl'], 'url', 'MojeId - Endpoint');
        $config['serverUrl'] = trim($config['serverUrl'], '/') . '/';

        // policy - pape
        Validators::assert($config['policy'], 'array', 'MojeId - Policy');
        $tmpPape = [];
        if (count($config['policy'])) {
            foreach ($config['policy'] as $policy) {
                if (!array_key_exists($policy, Policy::$pape)) {
                    throw new AssertionException('MojeId - Wrong policy pape value given - allowed only [' . implode(', ', array_keys(Policy::$pape)) . ']');
                } else {
                    $tmpPape[] = Policy::$pape[$policy];
                }
            }
            $config['policy'] = $tmpPape;
        } else {
            $config['policy'] = [Policy::$pape[Policy::PASSWORD]];
        }

        // fieldsType - simple or full
        Validators::assert($config['fieldsType'], 'string', 'MojeId - FieldsType');
        if (!in_array($config['fieldsType'], [Attributes::FULL, Attributes::SIMPLE])) {
            throw new AssertionException('MojeId - Wrong fieldsType given');
        }

        $builder = $this->getContainerBuilder();

        $mojeId = $builder->addDefinition($this->prefix('mojeId'))
            ->setClass('FreezyBee\MojeId\MojeId')
            ->setArguments([$config]);

        if ($config['debugger']) {
            $builder->addDefinition($this->prefix('panel'))
                ->setClass('FreezyBee\MojeId\Diagnostics\Panel')
                ->setInject(false);
            $mojeId->addSetup($this->prefix('@panel') . '::register', ['@self']);
        }
    }
}
