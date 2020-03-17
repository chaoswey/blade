<?php namespace App\View\Compilers;

use Illuminate\Container\Container;
use Illuminate\Support\Arr;
use Illuminate\View\Compilers\ComponentTagCompiler as Compiler;
use InvalidArgumentException;

class ComponentTagCompiler extends Compiler
{
    protected function componentClass(string $component)
    {
        if (isset($this->aliases[$component])) {
            return $this->aliases[$component];
        }

        $config = Container::getInstance()->get('app_config');
        $path = Arr::get($config, 'components');
        if (Container::getInstance()->make('view')->exists($view = "{$path}.{$component}")) {
            return $view;
        }

        throw new InvalidArgumentException(
            "Unable to locate a class or view for component [{$component}]."
        );
    }

    public function compileTags(string $value)
    {
        $value = $this->compileSelfClosingTags($value);
        $value = $this->compileOpeningTags($value);
        $value = $this->compileClosingTags($value);

        return $value;
    }
}