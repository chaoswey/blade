<?php namespace App\Compilers;

use Illuminate\Container\Container;
use Illuminate\Support\Arr;
use Illuminate\View\Compilers\ComponentTagCompiler as Compiler;
use InvalidArgumentException;


class ComponentTagCompiler extends Compiler
{
    /**
     * Get the component class for a given component alias.
     *
     * @param  string  $component
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function componentClass(string $component)
    {
        $app = Container::getInstance();
        $viewFactory = $app->make('view');

        if (isset($this->aliases[$component])) {
            if (class_exists($alias = $this->aliases[$component])) {
                return $alias;
            }

            if ($viewFactory->exists($alias)) {
                return $alias;
            }

            throw new InvalidArgumentException(
                "Unable to locate class or view [{$alias}] for component [{$component}]."
            );
        }

        $config = $app->get('app_config');

        if ($viewFactory->exists($view = $this->guessView($component, $config))) {
            return $view;
        }

        if ($view = $this->existsComponents($component, $config)) {
            return $view;
        }

        throw new InvalidArgumentException(
            "Unable to locate a class or view for component [{$component}]."
        );
    }

    public function existsComponents($component, $config)
    {
        $components = Arr::get($config, 'components');

        $data = array_filter($components, function ($item) use ($component) {
            return preg_match("/^{$item}/", $component);
        });

        return count($data) > 0 ? $component : false;
    }

    public function guessView(string $component, $config)
    {
        $guess = Arr::get($config, 'guess');
        $component = explode('.', $component);
        array_splice($component, -1, 0, $guess);
        return implode('.', $component);
    }
}