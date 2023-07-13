<?php

namespace App\Actions;

use App\Models\DomainPrice;
use App\Exceptions\PorkbunApiRequestFailedException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Helper\ProgressBar;

class GetPorkbunDomainPricesAction
{
    /**
     * An instance of Symfony's progress bar helper that if set, will be updated as the domain prices
     * are fetched and stored.
     */
    private ProgressBar $progress;

    /**
     * Invoke the action.
     */
    public function __invoke(ProgressBar $progress = null): void
    {
        if (!is_null($progress)) {
            $this->progress = $progress;
        }

        $prices = $this->getDomainPrices();
        $this->storeDomainPrices($prices);

        // Update the "last fetched" date
        Storage::put('last-fetched.txt', today()->toDateString());

        if (isset($this->progress)) {
            $this->progress->finish();
        }
    }

    /**
     * Get the current domain prices from the Porkbun API.
     */
    private function getDomainPrices(): array
    {
        $response = Http::get('https://porkbun.com/api/json/v3/pricing/get');
        if ($response->failed() || $response->json('status') != 'SUCCESS') {
            throw new PorkbunApiRequestFailedException($response->status(), $response->body());
        }

        $pricing = $response->json('pricing');

        if (isset($this->progress)) {
            $total_tlds = count($pricing);
            $this->progress->setMaxSteps($total_tlds);
        }

        return $response->json('pricing');
    }

    /**
     * Store the domain prices in the DB, either updating or inserting them as needed.
     */
    private function storeDomainPrices(array $prices): void
    {
        foreach ($prices as $domain => $pricing) {
            DomainPrice::updateOrCreate(
                ['tld' => $domain],
                [
                    'registration_price' => $pricing['registration'],
                    'renewal_price' => $pricing['renewal'],
                ]
            );

            if (isset($this->progress)) {
                $this->progress->advance();
            }
        }
    }
}
