<?php

namespace App\Actions;

use App\Models\DomainPrice;
use App\Services\DomainNameService;
use Cknow\Money\Money;
use Illuminate\Support\Arr;

class CalculateTotalDomainCostsAction
{
    public function __construct(
        private DomainNameService $domain_service
    ) {}

    /**
     * Invoke the action.
     */
    public function __invoke(string $domains): array
    {
        $total_costs = [];

        $total_registration_cost = Money::USD(0);
        $total_renewal_cost = Money::USD(0);

        // Convert the domains to an array and then create a separate array of their TLDs
        $domains = $this->domain_service->domainsToArray($domains);
        $tlds = $this->domain_service->domainsToTlds($domains);

        $domain_prices = DomainPrice::byTlds($tlds)->get();

        foreach ($domains as $domain) {
            $domain = trim(strtolower($domain));

            // Get the corresponding DomainPrice model for the TLD from the Eloquent collection retrieved
            $domain_price = $domain_prices->firstWhere('tld', $this->domain_service->domainToTld($domain));

            // Add to the total costs! 🤑
            $total_registration_cost = $total_registration_cost->add(
                Money::USD($domain_price->registration_price ?? 0)
            );
            $total_renewal_cost = $total_renewal_cost->add(
                Money::USD($domain_price->renewal_price ?? 0)
            );

            // Add the domain's individual registration & renewal price
            $total_costs['domains'][$domain]['registration'] = $domain_price->registration_price ?? Money::USD(0);
            $total_costs['domains'][$domain]['renewal'] = $domain_price->renewal_price ?? Money::USD(0);
        }

        $total_costs = Arr::prepend($total_costs, count($total_costs['domains']), 'total_domains');
        $total_costs = Arr::prepend($total_costs, $total_renewal_cost, 'total_renewal');
        $total_costs = Arr::prepend($total_costs, $total_registration_cost, 'total_registration');

        return $total_costs;
    }
}
