<?php namespace App\View\Compilers;

use Illuminate\Container\Container;
use Illuminate\Support\Arr;
use Illuminate\View\Compilers\ComponentTagCompiler as Compiler;
use InvalidArgumentException;

class ComponentTagCompiler extends Compiler
{
    public function componentClass(string $component): ?string
    {
        if (isset($this->aliases[$component])) {
            return $this->aliases[$component];
        }

        $config = Container::getInstance()->get('app_config');
        $paths = Arr::get($config, 'components');

        foreach($paths as $path){
            if (Container::getInstance()->make('view')->exists($view = "{$path}.{$component}")) {
                return $view;
            }
        }

        throw new InvalidArgumentException(
            "Unable to locate a class or view for component [{$component}]."
        );
    }

    public function compileTags(string $value): string
    {
        $value = $this->compileSelfClosingTags($value);
        $value = $this->compileOpeningTags($value);
        $value = $this->compileClosingTags($value);

        return $value;
    }
}