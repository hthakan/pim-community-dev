<?php

declare(strict_types=1);

namespace Akeneo\Connectivity\Connection\Domain\Webhook\Model;

use Akeneo\Platform\Component\EventQueue\Author;
use Akeneo\Platform\Component\EventQueue\EventInterface;

/**
 * @author    Willy Mesnage <willy.mesnage@akeneo.com>
 * @copyright 2020 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class WebhookEvent
{
    /** @var string */
    private $action;

    /** @var string */
    private $eventId;

    /** @var string */
    private $eventDateTime;

    /** @var array<mixed> */
    private $data;

    /** @var Author */
    private $author;

    /** @var string */
    private $pimSource;

    /** @var EventInterface */
    private $pimEvent;

    private ?string $version;

    /**
     * @param array<mixed> $data
     */
    public function __construct(
        string $action,
        string $eventId,
        string $eventDateTime,
        Author $author,
        string $pimSource,
        array $data,
        EventInterface $pimEvent,
        ?string $version = null
    ) {
        $this->action = $action;
        $this->eventId = $eventId;
        $this->eventDateTime = $eventDateTime;
        $this->data = $data;
        $this->author = $author;
        $this->pimSource = $pimSource;
        $this->pimEvent = $pimEvent;
        $this->version = $version;
    }

    public function action(): string
    {
        return $this->action;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function eventDateTime(): string
    {
        return $this->eventDateTime;
    }

    public function author(): Author
    {
        return $this->author;
    }

    public function pimSource(): string
    {
        return $this->pimSource;
    }

    /**
     * @return array<mixed>
     */
    public function data(): array
    {
        return $this->data;
    }

    public function getPimEvent(): EventInterface
    {
        return $this->pimEvent;
    }

    public function version(): ?string
    {
        return $this->version;
    }
}
