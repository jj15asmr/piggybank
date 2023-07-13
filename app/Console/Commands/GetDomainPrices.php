<?php

namespace App\Console\Commands;

use App\Actions\GetPorkbunDomainPricesAction;
use App\Exceptions\PorkbunApiRequestFailedException;
use Illuminate\Console\Command;

class GetDomainPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'piggybank:get-domain-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the current domain prices from the Porkbun API and store them in the DB.';

    /**
     * Execute the console command.
     */
    public function handle(GetPorkbunDomainPricesAction $get)
    {
        $progress = $this->output->createProgressBar(50);

        try {
            $get($progress);

        } catch (PorkbunApiRequestFailedException $ex) {
            report($ex);

            $progress->clear();

            $this->error($ex->getMessage());
            $this->newLine();

            $this->info('Response:');
            $this->line($ex->response ?? 'n/a');
            $this->newLine();

            return self::FAILURE;
        }

        $progress->clear();

        $this->newLine();
        $this->info('💾 Domain prices fetched and stored!');
        $this->newLine();

        return self::SUCCESS;
    }
}
