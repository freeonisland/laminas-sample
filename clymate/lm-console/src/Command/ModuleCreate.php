<?php

namespace LmConsole\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModuleCreate extends Command
{
    protected static $defaultName = 'module:create';

    protected static $arguments = [
        '<module_name>'
    ];

    /**
     * OPTIONS
     * config_provider = true|false
     * config_in_config.php = true|false
     */

    /**
     * 
     */
    protected static $modules_dir = 'source/';

    protected function configure()
    {
        $this
            ->addArgument('module_name', InputArgument::REQUIRED, 'The name of new module to create.');

        $this
            ->setDescription('Create a bootstrap module')
            ->setHelp('This command allows you create a new module with bootstrap files and composer configuration...');
    }

    /**
     * 
     */
    function execute(InputInterface $input, OutputInterface $output): int
    {
        $dir = getcwd() . DIRECTORY_SEPARATOR;

        //valide modules directory
        $modules_path = $dir . self::$modules_dir;

        if (!file_exists($modules_path)) {
            trigger_error("Le répertoire de modules {$modules_path} n'existe pas.\n");
            return Command::FAILURE;
        }

        if (!$this->createDirectories($modules_path, $input)) {
            return Command::FAILURE;
        }
        
        return Command::SUCCESS;
    }

    protected function createDirectories(string $modules_path, InputInterface $input): bool
    {
        //create new module
        $new_module_path = $modules_path . DIRECTORY_SEPARATOR . ucfirst(filter_var($input->getArgument('module_name'), FILTER_SANITIZE_SPECIAL_CHARS));
        if (!file_exists($new_module_path)) {
            mkdir($new_module_path) or trigger_error("Impossible de créer le répertoire {$new_module_path}.\n", E_USER_WARNING);
        }

        //create new module subdirs
        $view_dir = $new_module_path . DIRECTORY_SEPARATOR . 'view';
        mkdir($view_dir) or trigger_error("Impossible de créer le répertoire {$view_dir}.\n", E_USER_WARNING);

        $config_dir = $new_module_path . DIRECTORY_SEPARATOR . 'config';
        mkdir($config_dir) or trigger_error("Impossible de créer le répertoire {$config_dir}.\n", E_USER_WARNING);

        $src_dir = $new_module_path . DIRECTORY_SEPARATOR . 'src';
        mkdir($src_dir) or trigger_error("Impossible de créer le répertoire {$src_dir}.\n", E_USER_WARNING);

        $test_dir = $new_module_path . DIRECTORY_SEPARATOR . 'test';
        mkdir($test_dir) or trigger_error("Impossible de créer le répertoire {$test_dir}.\n", E_USER_WARNING);

        return true;
    }

    protected function createFiles(string $modules_path, InputInterface $input): bool
    {

    }
}