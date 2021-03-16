<?php declare(strict_types=1);

namespace ShipEngine;

use Http\Client\HttpClient;
use ShipEngine\Service\Address\AddressTrait;
use ShipEngine\Service\Package\PackageTrackingTrait;
use ShipEngine\Service\ServiceFactory;
use ShipEngine\Service\Tag\TagTrait;

/**
 * ShipEngine RPC 2.0 client.
 *
 * @package ShipEngine
 * @property \ShipEngine\Service\Tag\TagService $tags
 * @property \ShipEngine\Service\Address\AddressService $addresses
 * @property \ShipEngine\Service\Package\PackageTrackingService $tracking
 */
final class ShipEngine
{
    // Convenience method Traits.
    use TagTrait;
    use AddressTrait;
    use PackageTrackingTrait;

    /**
     * Factory providing services.
     *
     * @var ServiceFactory
     */
    private ServiceFactory $service_factory;

    /**
     *
     */
    const VERSION = '0.0.1';

    /**
     * ShipEngine constructor.
     *
     * @param string $api_key
     * @param HttpClient|null $client
     * @throws \Http\Discovery\Exception\NotFoundException
     */
    public function __construct(string $api_key, HttpClient $client = null)
    {
        $user_agent = $this->deriveUserAgent();

        $client = new ShipEngineClient($api_key, $user_agent, $client);

        $this->service_factory = new ServiceFactory($client);
    }

    /**
     * Service Getter.
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->service_factory->__get($name);
    }

    /**
     * Derive a User-Agent header from the environment.
     */
    private function deriveUserAgent(): string
    {
        $sdk_version = 'shipengine-php/' . self::VERSION;

        $os = explode(' ', php_uname());
        $os_kernel = $os[0] . '/' . $os[2];

        $php_version = 'PHP/' . phpversion();

        return $sdk_version . ' ' . $os_kernel . ' ' . $php_version;
    }
}
