<?php

namespace MetaverseSystems\GandiClient\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getDomains()
 * @method static array getDomain(string $domain)
 * @method static array getDnsRecords(string $domain)
 * @method static array createDnsRecord(string $domain, array $record)
 * @method static array updateDnsRecord(string $domain, string $recordId, array $record)
 * @method static bool deleteDnsRecord(string $domain, string $recordId)
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
