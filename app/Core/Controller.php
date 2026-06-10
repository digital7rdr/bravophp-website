<?php

declare(strict_types=1);

namespace App\Core;

class Controller
{
    /**
     * @param array<string, mixed> $data
     */
    public function render(string $view, array $data = [], string $layout = 'site'): void
    {
        $layoutName = $layout;
        extract($data, EXTR_SKIP);

        ob_start();
        require \base_path('resources/views/' . $view . '.php');
        $content = ob_get_clean();

        require \base_path('resources/views/layouts/' . $layoutName . '.php');
    }
}
