<?php namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Filesystem\Filesystem;
use Philo\Blade\Blade;
use Illuminate\Support\Str;

class Generator extends Command
{
    private $output;
    private $input;
    /**
     * @var Filesystem
     **/
    private $filesystem;


    protected function configure()
    {
        $this
            ->setName('b2html')
            ->setDescription('blade generate static html')
            ->setHelp('blade generate static html')
            ->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'generate static html output path', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filesystem = new Filesystem();
        $this->output = $output;
        $this->input = $input;
        $this->filesystem = $filesystem;

        $root = dirname(dirname(__DIR__));

        $target = $this->getTargetPath($root);
        $this->info("target dir :" . $target);
        if (!$filesystem->isDirectory($target)) {
            $this->info("make target dir success.");
            $filesystem->makeDirectory($target, 0777, true);
        }
        $this->copyPublicAllFiles($root, $target);

        $this->info("\nGenerator html for blade.");

        $this->generatorHtml($root, $target);
    }

    private function generatorHtml($root, $path)
    {
        $this->info("start generate html files to target dir.");

        $views = $this->getPath($root . "/resources/views");
        $cache = $this->getPath($root . '/app/cache');
        $blade = new Blade($views, $cache);

        $files = $this->filesystem->allFiles($views);
        $files = $this->ignore($root, $views, $files);
        $count = count($files);

        $progressBar = new ProgressBar($this->output, $count);
        $progressBar->setFormat('debug');
        $progressBar->start();
        $progressBar->finish();
        foreach ($files as $file) {
            $target = $this->path_replace($views, $path, $file);
            $file = str_replace([$this->getPath($views . "/"), ".blade.php"], "", $file);
            $html = $blade->view()->make($file)->render();
            $this->generate($target, $html);
            $progressBar->advance();
        }
        $progressBar->finish();
    }

    private function ignore($root, $views, $files)
    {
        $allfiles = [];
        $config = require $root . '/app/config.php';
        $ignores = $config['ignore'];
        foreach ($files as $file) {
            $is_ignore = false;
            foreach ($ignores as $ignore) {
                if (Str::is($this->getPath($views . '/' . trim(trim($ignore), '/')), $file)) {
                    $is_ignore = true;
                }
            }
            if (!$is_ignore) {
                $allfiles[] = $file;
            }
        }
        return $allfiles;
    }

    private function generate($target, $html)
    {
        $this->makeDir($target);
        $target = str_replace(".blade.php", ".html", $target);
        $this->filesystem->put($target, $html);
    }

    private function copyPublicAllFiles($root, $path)
    {
        $this->info("start copy public files to target dir . ");

        $public = $this->getPath($root . '/public');
        $files = $this->filesystem->allFiles($public);
        $count = count($files);

        $progressBar = new ProgressBar($this->output, $count);
        $progressBar->setFormat('debug');
        $progressBar->start();
        $progressBar->finish();
        foreach ($files as $file) {
            $target = $this->path_replace($public, $path, $file);
            $this->copy($this->getPath($file), $this->getPath($target));
            $progressBar->advance();
        }
        $progressBar->finish();
    }

    private function copy($file, $target)
    {
        $this->makeDir($target);
        $this->filesystem->copy($file, $target);
    }

    private function makeDir($target)
    {
        $path = pathinfo($target);
        if (!$this->filesystem->isDirectory($path['dirname'])) {
            $this->filesystem->makeDirectory($path['dirname'], 0777, true);
        }
    }

    private function path_replace($search, $path, $string)
    {
        return str_replace($search, $path, $string);
    }

    private function getTargetPath($root)
    {
        $target = $this->input->hasOption("output") && $this->input->getOption("output") != ""
            ? $this->input->getOption("output")
            : $root . "/html";

        return $this->getPath($target);
    }

    private function getPath($path)
    {
        return windows_os() ? str_replace('/', '\\', $path) : $path;
    }

    private function info($msg)
    {
        $msg = sprintf("<info>%s</info>", OutputFormatter::escape($msg));
        $this->output->writeln($msg);
    }
}