<?php

namespace App\Console\Commands;

use Aws\S3\S3Client;
use Illuminate\Console\Command;

class SyncOAuthKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:synckeys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync get passport key files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start downloading passport key file');
        $bucket = 'cheng-laravel-test';

        $client = S3Client::factory([
            'version' => 'latest', 'region' => 'us-east-2', 'signature' => 'v4',
            'credentials' => [
                'key'    => env('S3_KEY'),
                'secret' => env('S3_SECRET'),
            ],
        ]);

        $lists = ['private', 'public'];
        foreach ($lists as $k => $name) {
            $this->info($name . '.key 开始下载');
            $result = $client->getObject(array(
                'Bucket' => $bucket,
                'Key' => 'oauth-' . $name . '.key',
                // 'Range' => 'bytes=0-20' //只下载文件的前20个字节
                'SaveAs' => storage_path('/secret-keys/oauth-' . $name . '.key')
            ));
            $this->info($name . '.key下载成功');
        }
    }
}
