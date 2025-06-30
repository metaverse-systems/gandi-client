<?php

namespace MetaverseSystems\GandiClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GandiClient
{
    private Client $httpClient;
    private string $apiKey;
    private string $baseUrl;

    public function __construct(string $apiKey, string $baseUrl = 'https://api.gandi.net/v5')
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
        
        $this->httpClient = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 30,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
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
            $response = $this->httpClient->get("/domain/domains/{$domain}/records");
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
            $response = $this->httpClient->post("/domain/domains/{$domain}/records", [
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
            $response = $this->httpClient->put("/domain/domains/{$domain}/records/{$recordId}", [
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
            $this->httpClient->delete("/domain/domains/{$domain}/records/{$recordId}");
            return true;
        } catch (GuzzleException $e) {
            throw new \Exception("Failed to delete DNS record {$recordId} for {$domain}: " . $e->getMessage());
        }
    }
}
