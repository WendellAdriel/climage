<?php

declare(strict_types=1);

namespace App\Command;

use App\Support\ImageInfo;
use Minicli\Command\CommandController;
use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Terminal;
use Termwind\ValueObjects\Style;

abstract class BaseController extends CommandController
{
    protected function buildQuestion(string $question): string
    {
        return <<<HTML
            <div class="py-2">
                <div class="px-1 bg-purple-600">CLImage</div>
                <em class="ml-1">
                  {$question}
                </em>
            </div>
        HTML;
    }

    protected function successMessage(string $message): void
    {
        $this->render(<<<HTML
            <div class="py-2">
                <div class="px-1 bg-green-600">SUCCESS</div>
                <em class="ml-1">
                  {$message}
                </em>
            </div>
        HTML);
    }

    protected function printImageInfo(ImageInfo $imageInfo): void
    {
        $this->view('table', [
            'headers' => ['FILENAME', 'WIDTH', 'HEIGHT'],
            'rows' => [[$imageInfo->filename, "{$imageInfo->width} px", "{$imageInfo->height} px"]],
        ]);
    }

    protected function render(string $content, int $options = OutputInterface::OUTPUT_NORMAL): void
    {
        $this->getApp()->termwind->render($content, $options);
    }

    protected function style(string $name, Closure $callback = null): Style
    {
        return $this->getApp()->termwind->style($name, $callback);
    }

    protected function terminal(): Terminal
    {
        return $this->getApp()->termwind->terminal();
    }

    protected function ask(string $question, iterable $autocomplete = null): mixed
    {
        return $this->getApp()->termwind->ask($question, $autocomplete);
    }

    protected function view(string $template, array $data = []): void
    {
        $app = $this->getApp();

        $app->termwind->render($app->plates->view($template, $data));
    }
}
