<?php

namespace App\Console\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:interface')]

class MakeInterfaces extends GeneratorCommand
{
    use CreatesMatchingTest;
     /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:interface';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'make:interface';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create interface';

    protected $type = 'Interface';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }

        if ($this->option('repository')) {
            $this->createRepository();
        }

    }

    protected function createRepository()
    {
        $repository = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('make:repository', array_filter([
            'name' => "{$modelName}Repository",
            /* '--model' => $this->option('resource') || $this->option('api') ? $modelName : null,
            '--api' => $this->option('api'),
            '--requests' => $this->option('requests') || $this->option('all'), */
        ]));
    }



    protected function getStub(){
        return base_path('stubs/interface.stub');
    }

    protected function getDefaultNamespace($rootNamespace){
        return $rootNamespace . '\Interfaces';
    }

    protected function replaceClass($stub, $name){
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace('{{interface_name}}', $class, $stub);
    }

    protected function getOptions()
    {
        return [
            ['repository', 'r', InputOption::VALUE_NONE, 'Generate repository to a interface'],
        ];
    }

}
