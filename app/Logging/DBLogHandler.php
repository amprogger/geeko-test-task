<?php


namespace App\Logging;

use Illuminate\Support\Facades\DB;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

/**
 * Class DBLogHandler
 * @package App\Logging
 */
class DBLogHandler extends AbstractProcessingHandler
{
    /**
     * @var string
     */
    private $table;

    /**
     * DBLogHandler constructor.
     * @param int $level
     * @param bool $bubble
     */
    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        $this->table = 'db_logs';
        parent::__construct($level, $bubble);
    }

    /**
     * @param array $record
     */
    protected function write(array $record): void
    {
        $data = [
            'message' => $record['message'],
            'context' => json_encode($record['context']),
            'level' => $record['level'],
            'level_name' => $record['level_name'],
            'channel' => $record['channel'],
            'record_datetime' => $record['datetime']->format('Y-m-d H:i:s'),
            'extra' => json_encode($record['extra']),
            'formatted' => $record['formatted'],
            'user_id' => auth()->user()->id ?? '',
            'remote_addr' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'created_at' => date("Y-m-d H:i:s"),
        ];
        DB::connection()->table($this->table)->insert($data);
    }
}
