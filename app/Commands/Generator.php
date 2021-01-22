<?php namespace App\Commands;

use App\Builders\Blade;
use App\Component\Url;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

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
        $this->setName('b2html')
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

        $root = dirname(__DIR__, 2);

        $target = $this->getTargetPath($root);
        $this->info("target dir :" . $target);
        if (!$filesystem->isDirectory($target)) {
            try {
                $filesystem->makeDirectory($target, 0777, true);
            } catch (\Exception $e) {
                $this->error("make target dir fail. error msg:" . $e->getMessage());
            }
        }

        $this->clearTargetDir($target);

        $this->copyPublicAllFiles($root, $target);

        $this->info("\nGenerator html for blade.");

        $this->replaceUrl();

        $this->generatorHtml($root, $target);
    }

    private function clearTargetDir($target)
    {
        $helper = $this->getHelper('question');

        $question = new ConfirmationQuestion('Clear Target Dir ? [yes,default: no] ', false);

        if ($helper->ask($this->input, $this->output, $question)) {
            $this->filesystem->cleanDirectory($target);
        }
    }

    private function replaceUrl()
    {
        $helper = $this->getHelper('question');

        $question = new Question('Enter new URL  [http://www.example.com]: ');

        $base_url = $helper->ask($this->input, $this->output, $question);

        Url::setInstance($base_url);

        $this->info("new URL: " . $base_url);
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
            $html = $blade->make($file)->render();
            $this->generate($target, $html);
            $progressBar->advance();
        }
        $progressBar->finish();
    }

    private function ignore($root, $views, $files)
    {
        //TODO 跳脫
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

    /**
     * @param $target
     * @throws \Exception
     */
    private function makeDir($target)
    {
        $path = pathinfo($target);
        if (!$this->filesystem->isDirectory($path['dirname'])) {
            try {
                $this->filesystem->makeDirectory($path['dirname'], 0777, true);
            } catch (\Exception $e) {
                $this->error("make target dir fail. error msg:" . $e->getMessage());
                throw new \Exception($e->getMessage());
            }
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

    private function error($msg)
    {
        $msg = sprintf("<error>%s</error>", OutputFormatter::escape($msg));
        $this->output->writeln($msg);
    }
}