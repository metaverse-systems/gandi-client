<?php

namespace MetaverseSystems\GandiClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GandiClient
{
    private Client $httpClient;
    private string $personalAccessToken;
    private string $baseUrl;

    public function __construct(string $personalAccessToken, string $baseUrl = 'https://api.gandi.net/v5')
    {
        $this->personalAccessToken = $personalAccessToken;
        $this->baseUrl = rtrim($baseUrl, '/');
        
        $this->httpClient = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 30,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->personalAccessToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Get all domains
     */
    public function getDomains(): array
    {
        try {
            $response = $this->httpClient->get('/domain/domains');
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception('Failed to fetch domains: ' . $e->getMessage());
        }
    }

    /**
     * Get domain information
     */
    public function getDomain(string $domain): array
    {
        try {
            $response = $this->httpClient->get("/domain/domains/{$domain}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception("Failed to fetch domain {$domain}: " . $e->getMessage());
        }
    }

    /**
     * Get DNS records for a domain
     */
    public function getDnsRecords(string $domain): array
    {
        try {
            $response = $this->httpClient->get("/livedns/domains/{$domain}/records");
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception("Failed to fetch DNS records for {$domain}: " . $e->getMessage());
        }
    }

    /**
     * Create a DNS record
     */
    public function createDnsRecord(string $domain, array $record): array
    {
        try {
            $response = $this->httpClient->post("/livedns/domains/{$domain}/records", [
                'json' => $record
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception("Failed to create DNS record for {$domain}: " . $e->getMessage());
        }
    }

    /**
     * Update a DNS record
     */
    public function updateDnsRecord(string $domain, string $recordName, string $recordType, array $record): array
    {
        try {
            $response = $this->httpClient->put("/livedns/domains/{$domain}/records/{$recordName}/{$recordType}", [
                'json' => $record
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception("Failed to update DNS record {$recordName}/{$recordType} for {$domain}: " . $e->getMessage());
        }
    }

    /**
     * Delete a DNS record
     */
    public function deleteDnsRecord(string $domain, string $recordName, string $recordType): bool
    {
        try {
            $this->httpClient->delete("/livedns/domains/{$domain}/records/{$recordName}/{$recordType}");
            return true;
        } catch (GuzzleException $e) {
            throw new \Exception("Failed to delete DNS record {$recordName}/{$recordType} for {$domain}: " . $e->getMessage());
        }
    }

    /**
     * Get a specific DNS record by name and type
     */
    public function getDnsRecord(string $domain, string $recordName, string $recordType): array
    {
        try {
            $response = $this->httpClient->get("/livedns/domains/{$domain}/records/{$recordName}/{$recordType}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception("Failed to fetch DNS record {$recordName}/{$recordType} for {$domain}: " . $e->getMessage());
        }
    }

    /**
     * Get all DNS records for a specific name
     */
    public function getDnsRecordsByName(string $domain, string $recordName): array
    {
        try {
            $response = $this->httpClient->get("/livedns/domains/{$domain}/records/{$recordName}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception("Failed to fetch DNS records for {$recordName} on {$domain}: " . $e->getMessage());
        }
    }

    /**
     * Get domains managed by LiveDNS
     */
    public function getLiveDnsDomains(): array
    {
        try {
            $response = $this->httpClient->get('/livedns/domains');
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception('Failed to fetch LiveDNS domains: ' . $e->getMessage());
        }
    }

    /**
     * Add a domain to LiveDNS
     */
    public function addDomainToLiveDns(string $domain): array
    {
        try {
            $response = $this->httpClient->post('/livedns/domains', [
                'json' => ['fqdn' => $domain]
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception("Failed to add domain {$domain} to LiveDNS: " . $e->getMessage());
        }
    }

    /**
     * Get domain's nameservers
     */
    public function getDomainNameservers(string $domain): array
    {
        try {
            $response = $this->httpClient->get("/domain/domains/{$domain}/nameservers");
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception("Failed to fetch nameservers for {$domain}: " . $e->getMessage());
        }
    }

    /**
     * Update domain's nameservers
     */
    public function updateDomainNameservers(string $domain, array $nameservers): array
    {
        try {
            $response = $this->httpClient->put("/domain/domains/{$domain}/nameservers", [
                'json' => ['nameservers' => $nameservers]
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception("Failed to update nameservers for {$domain}: " . $e->getMessage());
        }
    }
}
