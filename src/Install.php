<?php

declare(strict_types=1);

namespace gaia\nat;

use mon\util\File;
use support\Plugin;
use mon\util\Common;

/**
 * Gaia框架安装驱动
 * 
 * @author Mon <985558837@qq.com>
 * @version 1.0.0
 */
class Install
{
    /**
     * 标志为Gaia的驱动
     */
    const GAIA_PLUGIN = true;

    /**
     * 移动的文件
     *
     * @var array
     */
    protected static $file_relation = [
        'NatServer.php' => 'bin/nat_server.php',
        'NatClient.php' => 'bin/nat_client.php',
    ];

    /**
     * 移动的文件夹
     *
     * @var array
     */
    protected static $dir_relation = [
        'process'   => 'support/nat/process',
    ];

    /**
     * 移动的配置文件，处理key值
     *
     * @var array
     */
    protected static $config_relation = [
        'config.php' => 'config/nat.php',
    ];

    /**
     * 安装
     *
     * @return void
     */
    public static function install()
    {
        echo 'Gaia-Nat installation successful, please execute `php gaia vendor:publish gaia\nat`' . PHP_EOL;
    }

    /**
     * 更新升级
     *
     * @return void
     */
    public static function update()
    {
        echo 'Gaia-Nat upgrade successful, please execute `php gaia vendor:publish gaia\nat`' . PHP_EOL;
    }

    /**
     * 卸载
     *
     * @return void
     */
    public static function uninstall() {}

    /**
     * Gaia发布
     *
     * @return void
     */
    public static function publish()
    {
        // 创建框架文件
        $source_path = __DIR__ . DIRECTORY_SEPARATOR;
        // 移动文件
        foreach (static::$file_relation as $source => $dest) {
            $sourceFile = $source_path . $source;
            Plugin::copyFile($sourceFile, $dest, true);
        }
        // 移动目录
        foreach (static::$dir_relation as $source => $dest) {
            $sourceDir = $source_path . $source;
            Plugin::copydir($sourceDir, $dest, true);
        }
        // 处理需要随机生成秘钥的配置文件
        foreach (static::$config_relation as $source => $dest) {
            $sourceFile = $source_path . $source;
            $destFile = ROOT_PATH . DIRECTORY_SEPARATOR . $dest;
            $content = File::read($sourceFile);
            // 绑定key值
            $content = sprintf($content, static::getKey());
            File::createFile($content, $destFile, false);
            echo 'Create File ' . $destFile . "\r\n";
        }
    }

    /**
     * 获取生成的随机key
     *
     * @return void
     */
    protected static function getKey()
    {
        return Common::randString(24, 36, '~!@#{}|$^&*()-_+%`');
    }
}
