<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetFilePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:reset
                            {cliuser? : User who execute artisan commands. Default: current user}
                            {wwwgroup? : Group of apache server. Default: www}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset file and folder permission of storage and cache folders';

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
        if ($this->argument('cliuser')) {
            $cliuser = $this->argument('cliuser');
        } else {
            $cliuser = get_current_user();
        }
        if ($this->argument('wwwgroup')) {
            $wwwgroup = $this->argument('wwwgroup');
        } else {
            $wwwgroup = 'www';
        }

        exec("sudo chown -R $cliuser:$wwwgroup storage public/storage bootstrap/cache");
        exec("sudo chmod -R ug-x+rwX,o-wx+rX storage public/storage bootstrap/cache");
    }
}
