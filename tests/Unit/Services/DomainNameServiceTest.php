<?php

namespace Tests\Unit\Services;

use App\Services\DomainNameService;
use App\Exceptions\InvalidDomainException;
use PHPUnit\Framework\Attributes\{
    Test,
    DoesNotPerformAssertions,
    DataProvider
};
use PHPUnit\Framework\TestCase;

class DomainNameServiceTest extends TestCase
{
    private DomainNameService $domain_service;

    public function setUp(): void
    {
        $this->domain_service = new DomainNameService();
    }

    #[Test]
    #[DoesNotPerformAssertions]
    #[DataProvider('validDomainNameProvider')]
    public function it_validates_a_domain_name_successfully(string $domain): void
    {
        $this->domain_service->validateDomain($domain);
    }

    public function validDomainNameProvider(): array
    {
        return [
            'domain with single-level tld' => [
                'google.com'
            ],

            'domain with two-level tld' => [
                'google.co.uk'
            ],

            'domain with three-level tld' => [
                'owen.sj.ca.us'
            ],

            'domain with numeric tld' => [
                'handshake.420247'
            ],
        ];
    }

    #[Test]
    #[DataProvider('invalidDomainNameProvider')]
    public function it_throws_an_exception_when_attempting_to_validate_an_invalid_domain_name(string $domain): void
    {
        $this->expectException(InvalidDomainException::class);

        $this->domain_service->validateDomain($domain);
    }

    public function invalidDomainNameProvider(): array
    {
        return [
            'domain with scheme' => [
                'https://twitter.com'
            ],

            'domain with no tld' => [
                'twitter.'
            ],
        ];
    }

    #[Test]
    public function it_converts_a_list_of_domains_to_an_array(): void
    {
        $domains = <<<EOD
        example.com
        example.co.uk
        handshake.420247
        EOD;

        $domains_array = $this->domain_service->domainsToArray($domains);

        $this->assertIsArray($domains_array);

        $this->assertEquals('example.com', $domains_array[0]);
        $this->assertEquals('example.co.uk', $domains_array[1]);
        $this->assertEquals('handshake.420247', $domains_array[2]);
    }

    #[Test]
    public function it_converts_an_array_of_domains_to_an_array_of_tlds(): void
    {
        $domains = [
            'example.com',
            'example.co.uk',
            'handshake.420247',
        ];

        $tlds_array = $this->domain_service->domainsToTlds($domains);

        $this->assertIsArray($tlds_array);
        
        $this->assertEquals('com', $tlds_array[0]);
        $this->assertEquals('co.uk', $tlds_array[1]);
        $this->assertEquals('420247', $tlds_array[2]);
    }

    #[Test]
    public function it_throws_an_exception_when_attempting_to_convert_an_empty_array_of_domains_to_an_array_of_tlds(): void
    {
        // Empty string value
        $domains = [''];
        $this->expectExceptionMessage('Array of domains is empty');

        $this->domain_service->domainsToTlds($domains);

        // Totally empty array
        $domains = [];
        $this->expectExceptionMessage('Array of domains is empty');

        $this->domain_service->domainsToTlds($domains);
    }

    #[Test]
    public function it_extracts_the_tld_from_a_domain_name(): void
    {
        $tld = $this->domain_service->domainToTld('example.com');

        $this->assertEquals('com', $tld);
    }
}
