<?php namespace App\View\Compilers;

use Illuminate\Container\Container;
use Illuminate\View\Compilers\ComponentTagCompiler as Compiler;
use InvalidArgumentException;

class ComponentTagCompiler extends Compiler
{
    protected function componentClass(string $component)
    {
        if (isset($this->aliases[$component])) {
            return $this->aliases[$component];
        }

        if (Container::getInstance()->make('view')->exists($view = "_components.{$component}")) {
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