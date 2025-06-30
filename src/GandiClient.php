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
            $response = $this->httpClient->get('/domains');
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
            $response = $this->httpClient->get("/domains/{$domain}");
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
            $response = $this->httpClient->get("/domains/{$domain}/records");
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
            $response = $this->httpClient->post("/domains/{$domain}/records", [
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
    public function updateDnsRecord(string $domain, string $recordId, array $record): array
    {
        try {
            $response = $this->httpClient->put("/domains/{$domain}/records/{$recordId}", [
                'json' => $record
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception("Failed to update DNS record {$recordId} for {$domain}: " . $e->getMessage());
        }
    }

    /**
     * Delete a DNS record
     */
    public function deleteDnsRecord(string $domain, string $recordId): bool
    {
        try {
            $this->httpClient->delete("/domains/{$domain}/records/{$recordId}");
            return true;
        } catch (GuzzleException $e) {
            throw new \Exception("Failed to delete DNS record {$recordId} for {$domain}: " . $e->getMessage());
        }
    }
}
