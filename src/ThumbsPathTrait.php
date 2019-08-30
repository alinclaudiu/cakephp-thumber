<?php
/**
 * This file is part of cakephp-thumber.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Mirko Pagliai
 * @link        https://github.com/mirko-pagliai/cakephp-thumber
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 * @since       1.5.0
 */
namespace Thumber;

use Cake\Core\Plugin as CorePlugin;
use PhpThumber\ThumbsPathTrait as PhpThumberThumbsPathTrait;

/**
 * This trait provides some methods to get and resolve thumbnails paths.
 */
trait ThumbsPathTrait
{
    use PhpThumberThumbsPathTrait;

    /**
     * Internal method to resolve a relative path, returning a full path
     * @param string $path Partial path
     * @return string
     */
    protected function resolveFilePath($path)
    {
        //A relative path can be a file from `APP/webroot/img/` or a plugin
        if (!is_url($path) && !is_absolute($path)) {
            $pluginSplit = pluginSplit($path);
            $www = WWW_ROOT;
            if ($pluginSplit[0] && in_array($pluginSplit[0], CorePlugin::loaded())) {
                $www = add_slash_term(CorePlugin::path($pluginSplit[0])) . 'webroot';
                $path = $pluginSplit[1];
            }
            $path = add_slash_term($www) . 'img' . DS . $path;
        }

        return $path;
    }
}
