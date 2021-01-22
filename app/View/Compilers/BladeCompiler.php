<?php namespace App\View\Compilers;

use Illuminate\View\Compilers\BladeCompiler as Compiler;

class BladeCompiler extends Compiler
{
    /**
     * Compile the component tags.
     *
     * @param string $value
     * @return string
     */
    protected function compileComponentTags($value): string
    {
        if (!$this->compilesComponentTags) {
            return $value;
        }

        return (new ComponentTagCompiler(
            $this->classComponentAliases
        ))->compile($value);
    }

}