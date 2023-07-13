<?php

namespace Tests\Feature\Actions;

use App\Actions\GetPorkbunDomainPricesAction;
use App\Exceptions\PorkbunApiRequestFailedException;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetPorkbunDomainPricesActionTest extends TestCase
{
    use RefreshDatabase;

    private GetPorkbunDomainPricesAction $get_prices_action;

    public function setUp(): void
    {
        parent::setUp();

        $this->get_prices_action = new GetPorkbunDomainPricesAction;
    }

    #[Test]
    public function it_gets_the_domain_prices_successfully(): void
    {
        $response = file_get_contents(base_path(
            'tests/Fixtures/Actions/porkbun-api-prices-response.json'
        ));
        Http::fake([
            'https://porkbun.com/api/json/v3/pricing/get' => Http::response($response),
        ]);

        Storage::fake(); // To ensure that the "last fetched" date isn't changed by the test

        ($this->get_prices_action)();

        Http::assertSentCount(1);
        Storage::assertExists('last-fetched.txt');

        $this->assertEquals(Storage::get('last-fetched.txt'), today()->toDateString());

        $this->assertDatabaseCount('domain_prices', 3);
        $this->assertDatabaseHas('domain_prices', [
            'tld' => 'com',
            'registration_price' => 973,
            'renewal_price' => 973
        ]);
    }

    #[Test]
    public function it_throws_an_exception_when_the_porkbun_api_request_fails(): void
    {
        Http::fake([
            'https://porkbun.com/api/json/v3/pricing/get' => Http::response(status: 418),
        ]);

        $this->expectException(PorkbunApiRequestFailedException::class);
        $this->expectExceptionMessage('Porkbun API request failed with status code 418.');

        ($this->get_prices_action)();
    }
}
