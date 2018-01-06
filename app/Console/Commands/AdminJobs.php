<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Pledge;
use App\Receive;

class AdminJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin Jobs like matching and mailings';

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
        foreach (Pledge::whereIn('status', array('Awaiting 5% match', 'Awaiting 95% match', 'Awaiting maturity'))->orderBy('amount_balance', 'desc')->cursor() as $unmatchedPledge) {
            if ($unmatchedPledge->status == 'Awaiting maturity'){
                $unmatchedPledge->checkAndMature();
                continue;
            }
            $amountToMatch = $unmatchedPledge->getAmountToMatch();
            while ($amountToMatch > 0) {
                $unmatchedReceive = $unmatchedPledge->findReceive();
                $amountToMatch =- $unmatchedPledge->match($unmatchedReceive, $amountToMatch);
            }
        }   
    }
}
