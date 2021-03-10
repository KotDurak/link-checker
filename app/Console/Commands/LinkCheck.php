<?php

namespace App\Console\Commands;

use App\Services\CheckService;
use Illuminate\Console\Command;

class LinkCheck extends Command
{

    private $checkService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'link:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CheckService $checkService)
    {
        parent::__construct();
        $this->checkService = $checkService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->checkService->doCheck();
    }
}
