<?php

declare(strict_types=1);

namespace support\nat\process;

use mon\env\Config;
use Channel\Server;
use Workerman\Worker;
use gaia\ProcessTrait;
use gaia\interfaces\ProcessInterface;
use Workerman\Connection\TcpConnection;

/**
 * 内网穿透进程通信服务
 * 
 * @author Mon <985558837@qq.com>
 * @version 1.0.1   2023-04-13
 */
class Channel extends Server implements ProcessInterface
{
    use ProcessTrait;

    /**
     * 获取进程配置
     *
     * @return array
     */
    public static function getProcessConfig(): array
    {
        return [
            // 监听协议端口，需要对外开放，客户端链接管道通信
            'listen'    => 'frame://0.0.0.0:' . Config::instance()->get('nat.channel_port', 2209),
            // 进程数，必须是1
            'count'     => 1,
        ];
    }

    /**
     * 重载构造方法
     */
    public function __construct() {}

    /**
     * 进程启动
     *
     * @param Worker $worker
     * @return void
     */
    public function onWorkerStart(Worker $worker)
    {
        $worker->channels = [];
        $this->_worker = $worker;
    }

    /**
     * 客户端链接
     *
     * @param TcpConnection $connection
     * @return void
     */
    public function onConnect(TcpConnection $connection)
    {
        // TODO 可以通过IP白名单鉴权断开链接
        // dd($connection->getRemoteIp());
    }
}
