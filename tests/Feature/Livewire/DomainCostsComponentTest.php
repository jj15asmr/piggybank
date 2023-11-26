<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\DomainCostsComponent;
use App\Models\DomainPrice;
use Livewire\Livewire;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\Attributes\{Test, DataProvider};
use Tests\TestCase;

class DomainCostsComponentTest extends TestCase
{
    use RefreshDatabase;

    private Collection $domain_prices;
    private string $domains_list;

    protected function setUp(): void
    {
        parent::setUp();

        $this->domain_prices = DomainPrice::factory(3)->create([
            'registration_price' => 500,
            'renewal_price' => 500
        ]);

        $this->domains_list = <<<EOD
        example.{$this->domain_prices[0]['tld']}
        example.{$this->domain_prices[1]['tld']}
        example.{$this->domain_prices[2]['tld']}
        EOD;
    }

    #[Test]
    public function it_loads_the_route_with_the_component(): void
    {
        $this->get('/')

            ->assertSeeLivewire(DomainCostsComponent::class)
            ->assertSeeText('Copy & paste your simple list of Porkbun domains below', false);
    }

    #[Test]
    public function it_allows_us_to_calculate_our_costs_successfully(): void
    {
        // Fake the "last fetched" date
        Storage::fake();
        Storage::put('last-fetched.txt', '2023-06-20');

        Livewire::test(DomainCostsComponent::class)
            ->set('domains', $this->domains_list)
            ->call('calculate')

            ->assertSeeHtml("Alrighty, here's your calculated costs!")
            ->assertSeeInOrder([
                'Total Domains',
                '3',

                'Registration',
                '$15.00',

                'Renewal',
                '$15.00',

                'Prices last fetched from the Porkbun API on 2023-06-20',

                'View Pricing by Domain',
                'Edit',
                'Reset'
            ])

            ->assertSeeHtmlInOrder([
                'domain-pricing-modal',

                // Domain data in "Pricing by Domain" modal table
                "example.{$this->domain_prices[0]['tld']}",
                '$5.00',
                '$5.00',
            ]);
    }

    #[Test]
    #[DataProvider('invalidDataProvider')]
    public function it_shows_a_validation_error_when_invalid_domain_data_is_entered(?string $data, string $message): void
    {
        Livewire::test(DomainCostsComponent::class)
            ->set('domains', $data)
            ->call('calculate')

            ->assertHasErrors('domains')
            ->assertSee($message);
    }

    public function invalidDataProvider(): array
    {
        return [
            'null domain' => [null, 'Hold your hooves! Enter some domains first.'],
            'invalid domain' => ['google.', '"google." doesn\'t seem to be a valid domain, please check :)'],
        ];
    }

    #[Test]
    public function it_lets_us_reset_the_calculation(): void
    {
        // "Soft" reset (don't reset the list of domains so we can still edit them)
        Livewire::test(DomainCostsComponent::class)
            ->set('domains', $this->domains_list)
            ->call('calculate')
            ->call('resetCalculation')

            ->assertSet('domains', $this->domains_list)
            ->assertSet('total_costs', null)
            ->assertSee('Calculate');

        // "Hard" reset (reset everything including the list of domains so we can start from scratch)
        Livewire::test(DomainCostsComponent::class)
            ->set('domains', $this->domains_list)
            ->call('calculate')
            ->call('resetCalculation', true)

            ->assertSet('domains', null)
            ->assertSet('total_costs', null)
            ->assertSee('Calculate');
    }
}
