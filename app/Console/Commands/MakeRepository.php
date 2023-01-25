<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\File;
class MakeRepository extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make repository';

    protected $type = 'class';

    protected function getStub(){
        return base_path('stubs/repository.stub');
    }

    protected function getDefaultNamespace($rootNamespace){
        return $rootNamespace . '\Repositories';
    }

    protected function replaceClass($stub, $name){
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        $interface= preg_replace('/Repository$/', '',$class);
        return str_replace(['{{class_name}}','{{interface_name}}'], [$class,$interface], $stub);
    }




}
