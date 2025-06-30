<?php

namespace MetaverseSystems\GandiClient\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getDomains()
 * @method static array getDomain(string $domain)
 * @method static array getDnsRecords(string $domain)
 * @method static array createDnsRecord(string $domain, array $record)
 * @method static array updateDnsRecord(string $domain, string $recordName, string $recordType, array $record)
 * @method static bool deleteDnsRecord(string $domain, string $recordName, string $recordType)
 * @method static array getDnsRecord(string $domain, string $recordName, string $recordType)
 * @method static array getDnsRecordsByName(string $domain, string $recordName)
 * @method static array getLiveDnsDomains()
 * @method static array addDomainToLiveDns(string $domain)
 * @method static array getDomainNameservers(string $domain)
 * @method static array updateDomainNameservers(string $domain, array $nameservers)
 */
class Gandi extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'gandi';
    }
}
