<?php

namespace App\Services;

use App\Models\Snapshot;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Renderer\RendererConstant;

class DiffService
{
    public array $differOptions;
    public array $rendererOptions;

    public function __construct()
    {
        $this->differOptions = [
            'context' => 3,
            'ignoreCase' => true,
            'ignoreWhitespace' => true,
        ];
        $this->rendererOptions = [
            'detailLevel' => 'word',
            'language' => 'eng',
            'lineNumbers' => true,
            'separateBlock' => true,
            'showHeader' => true,
            'spacesToNbsp' => true,
            'tabSize' => 4,
            'mergeThreshold' => 0.8,
            'cliColorization' => RendererConstant::CLI_COLOR_AUTO,
            'outputTagAsString' => false,
            'jsonEncodeFlags' => \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE,
            'wordGlues' => [' ', '-'],
            'resultForIdenticals' => 'No differences found',
            'wrapperClasses' => ['diff-wrapper'],
        ];
    }

    public function calculate(
        string $old,
        string $new,
        string $method = 'SideBySide',
        ?array $differOptions = null,
        ?array $rendererOptions = null
    ): string {
        if ($differOptions == null) $differOptions = $this->differOptions;
        if ($rendererOptions == null) $rendererOptions = $this->rendererOptions;
        return DiffHelper::calculate($old, $new, $method, $differOptions, $rendererOptions);
    }

    public function diffSnapshots(?Collection $snapshots = null): array
    {
        $diff['new'] = $diff['old'] = $diff['diff'] = null;
        $count_snapshots = $snapshots->count();
        if ($count_snapshots == 0) return $diff;

        $diff['new'] = $snapshots->get(0);
        if ($count_snapshots == 1) return $diff;

        $diff['old'] = $snapshots->get(1);
        $diff['diff'] = (new DiffService())->calculate($diff['old']->data, $diff['new']->data);
        return $diff;
    }


}
