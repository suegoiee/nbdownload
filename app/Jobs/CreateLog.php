<?php

namespace App\Jobs;

use DB;
use Auth;
use App\Models\cms\CmsLog;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Schema;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private $log_table;

    /**
     * @var string
     */
    private $log_action;

    /**
     * @var string
     */
    private $log_ip;

    public function __construct(string $subject, string $body, string $author)
    {
        $this->log_table = $subject;
        $this->log_action = $body;
        $this->log_ip = $author;
    }

    public static function fromRequest($request): self
    {
        return new static(
            $request->log_table,
            $request->log_action,
            $request->log_ip
        );
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $table = 'cms_log_' . date("Ym");
        if(!Schema::hasTable($table)){
            DB::statement( 'CREATE TABLE `'.$table.'` (
              `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
              `log_table` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
              `log_column` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
              `log_status` tinyint(3) unsigned NOT NULL,
              `log_action` text COLLATE utf8mb4_unicode_ci NOT NULL,
              `log_ip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
              `log_user_id` int(11) NOT NULL,
              `log_table_id` bigint(20) NOT NULL,
              `log_create` datetime NOT NULL,
              PRIMARY KEY (`log_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=11061 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;' );
        }
        
        $log = new CmsLog;
        $log->setTable($table);
        $log->log_table = 'NB_download';
        $log->log_column = 'all';
        $log->log_status = 0;
        $log->log_action = $this->log_action;
        $log->log_ip = $this->log_ip;
        $log->log_user_id = Auth::user()->id;
        $log->log_table_id = 0;
        $log->save();
    }
}
