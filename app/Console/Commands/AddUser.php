<?php

namespace App\Console\Commands;

use App\Services\CreateUserService;
use Illuminate\Console\Command;

class AddUser extends Command
{
    private $userService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add';

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
    public function __construct(CreateUserService $userService)
    {
        $this->userService = $userService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->userService->createAdmin();
    }
}
