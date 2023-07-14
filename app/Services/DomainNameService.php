<?php

namespace App\Services;

use App\Exceptions\InvalidDomainException;

class DomainNameService
{
    /**
     * The regex used to match domains that consists of a single name with a single or multi-level TLD.
     * 
     * @var string
     */
    private const DOMAIN_REGEX = "/^[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9]{2,})+$/";

    /**
     * Validate the format of a domain name.
     * 
     * @throws  InvalidDomainException  If the domain is invalid.
     */
    public function validateDomain(string $domain): void
    {
        if (!preg_match(self::DOMAIN_REGEX, $domain)) {
            throw new InvalidDomainException($domain);
        }
    }

    /**
     * Convert a list of domain names to an associative array.
     */
    public function domainsToArray(string $domains): array
    {
        return explode("\n", $domains);
    }

    /**
     * Extract the TLDs from an array of domain names.
     * 
     * @throws  \InvalidArgumentException  If the passed array of domains is considered empty.
     */
    public function domainsToTlds(array $domains): array
    {
        $domains = array_filter($domains); // Remove any empty values
        if (count($domains) === 0) {
            throw new \InvalidArgumentException('Array of domains is empty.');
        }
        
        $tlds = [];

        foreach ($domains as $domain) {
            $tld = $this->domainToTld($domain);
            $tlds[] = $tld;
        }

        return $tlds;
    }

    /**
     * Extract the TLD from a domain name.
     * 
     * @throws  InvalidDomainException  If the domain is invalid.
     */
    public function domainToTld(string $domain): string
    {
        $domain = trim($domain);

        $this->validateDomain($domain);

        $domain_parts = explode('.', $domain);
        unset($domain_parts[0]); // Remove the second-level name (ex. "tinglytube") in case of multi-level TLDs (ex. ".co.uk")

        $tld = implode('.', $domain_parts);

        return $tld;
    }
}
