<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeCrud extends Command
{
    protected $signature = 'make:crud {name : Nama resource, mis. Category}';

    protected $description = 'Generate CRUD lengkap (model, migrasi, controller, view) untuk sebuah resource';

    public function handle(): int
    {
        $model = Str::studly($this->argument('name'));

        if ($model === '') {
            $this->error('Nama resource tidak valid.');

            return self::FAILURE;
        }

        $modelVar = Str::camel($model);

        $replace = [
            '__MODEL__' => $model,
            '__MODEL_VAR__' => $modelVar,
            '__MODEL_VAR_PLURAL__' => Str::plural($modelVar),
            '__MODEL_PLURAL__' => Str::plural($model),
            '__TABLE__' => Str::snake(Str::pluralStudly($model)),
            '__VIEW__' => Str::kebab($model),
            '__ROUTE__' => Str::kebab($model),
            '__CONTROLLER__' => $model.'Controller',
        ];

        $stubDir = base_path('stubs/crud');

        $files = [
            $stubDir.'/model.stub' => app_path("Models/{$model}.php"),
            $stubDir.'/migration.stub' => database_path('migrations/'.now()->format('Y_m_d_His')."_create_{$replace['__TABLE__']}_table.php"),
            $stubDir.'/controller.stub' => app_path("Http/Controllers/{$model}Controller.php"),
            $stubDir.'/index.stub' => resource_path('views/'.$replace['__VIEW__'].'/index.blade.php'),
            $stubDir.'/create.stub' => resource_path('views/'.$replace['__VIEW__'].'/create.blade.php'),
            $stubDir.'/edit.stub' => resource_path('views/'.$replace['__VIEW__'].'/edit.blade.php'),
        ];

        foreach ($files as $stub => $target) {
            if (! File::exists($stub)) {
                $this->error("Stub tidak ditemukan: {$stub}");

                return self::FAILURE;
            }

            File::ensureDirectoryExists(dirname($target));
            $content = str_replace(array_keys($replace), array_values($replace), File::get($stub));
            File::put($target, $content);
            $this->line('  <info>Created</info> '.Str::after($target, base_path().DIRECTORY_SEPARATOR));
        }

        $this->newLine();
        $this->info("CRUD untuk [{$model}] berhasil dibuat.");
        $this->warn('Tambahkan route berikut ke routes/web.php (di dalam group auth):');
        $this->newLine();
        $this->line($this->routeSnippet($replace['__ROUTE__'], $replace['__CONTROLLER__']));

        return self::SUCCESS;
    }

    private function routeSnippet(string $route, string $controller): string
    {
        return <<<PHP
        Route::get('/{$route}', [{$controller}::class, 'index'])->name('{$route}.index');
        Route::get('/{$route}/create', [{$controller}::class, 'create'])->name('{$route}.create');
        Route::post('/{$route}/store', [{$controller}::class, 'store'])->name('{$route}.store');
        Route::get('/{$route}/edit/{id}', [{$controller}::class, 'edit'])->name('{$route}.edit');
        Route::post('/{$route}/update/{id}', [{$controller}::class, 'update'])->name('{$route}.update');
        Route::delete('/{$route}/delete/{id}', [{$controller}::class, 'destroy'])->name('{$route}.delete');
        PHP;
    }
}
