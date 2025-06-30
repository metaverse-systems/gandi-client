# Gandi Client for Laravel

A Laravel package for managing Gandi domains and DNS records through the Gandi API.

## Installation

Install the package via Composer:

```bash
composer require metaverse-systems/gandi-client
```

## Configuration

### Environment Variables

Add your Gandi Personal Access Token to your `.env` file:

```env
GANDI_PERSONAL_ACCESS_TOKEN=your_gandi_personal_access_token_here
GANDI_BASE_URL=https://api.gandi.net/v5
```

You can create a Personal Access Token in your [Gandi Admin dashboard](https://admin.gandi.net/organizations/account/pat).

### Publish Configuration (Optional)

You can publish the configuration file to customize the package settings:

```bash
php artisan vendor:publish --tag=gandi-config
```

This will create a `config/gandi.php` file where you can customize the package settings.

## Usage

### Using the Facade

```php
use MetaverseSystems\GandiClient\Facades\Gandi;

// Get all domains
$domains = Gandi::getDomains();

// Get specific domain information
$domain = Gandi::getDomain('example.com');

// Get DNS records for a domain
$records = Gandi::getDnsRecords('example.com');

// Create a new DNS record
$record = Gandi::createDnsRecord('example.com', [
    'rrset_name' => 'www',
    'rrset_type' => 'A',
    'rrset_values' => ['192.168.1.1'],
    'rrset_ttl' => 3600
]);

// Update a DNS record
$updatedRecord = Gandi::updateDnsRecord('example.com', 'record-id', [
    'rrset_values' => ['192.168.1.2']
]);

// Delete a DNS record
Gandi::deleteDnsRecord('example.com', 'record-id');
```

### Using Dependency Injection

```php
use MetaverseSystems\GandiClient\GandiClient;

class DomainController extends Controller
{
    public function __construct(private GandiClient $gandiClient)
    {
    }

    public function index()
    {
        $domains = $this->gandiClient->getDomains();
        return view('domains.index', compact('domains'));
    }
}
```

## API Methods

### Domains

- `getDomains()` - Get all domains
- `getDomain(string $domain)` - Get specific domain information

### DNS Records

- `getDnsRecords(string $domain)` - Get all DNS records for a domain  
- `createDnsRecord(string $domain, array $record)` - Create a new DNS record
- `updateDnsRecord(string $domain, string $recordId, array $record)` - Update a DNS record
- `deleteDnsRecord(string $domain, string $recordId)` - Delete a DNS record

## Configuration Options

The following configuration options are available in `config/gandi.php`:

- `personal_access_token` - Your Gandi Personal Access Token
- `base_url` - The Gandi API base URL (default: https://api.gandi.net/v5)
- `timeout` - Request timeout in seconds (default: 30)
- `verify_ssl` - Whether to verify SSL certificates (default: true)

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).
