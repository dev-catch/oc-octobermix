<?php namespace DevCatch\OctoberMix;

use Cms\Classes\Theme;
use Illuminate\Support\Facades\URL;
use System\Classes\PluginBase;

/**
 * OctoberMix Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'OctoberMix',
            'description' => 'Integrate Laravel Mix with OctoberCMS',
            'author' => 'DevCatch',
            'icon' => 'icon-flask'
        ];
    }

    public function registerMarkupTags()
    {
        return [
            'filters' => [
                'mix' => [$this, 'getMixAsset']
            ]
        ];
    }

    public function getMixAsset($assetKey, $manifest_path = null)
    {
        $theme = Theme::getActiveTheme()->getDirName();

        if (!$manifest_path) {
            $manifest_path = themes_path($theme);
        }

        $manifest = json_decode(file_get_contents("$manifest_path/mix-manifest.json"));

        $asset = $manifest->$assetKey;

        if (!$asset) {
            return null;
        }

        $asset = ltrim($asset, '/');

        return URL::to("/themes/$theme/$asset");
    }
}
