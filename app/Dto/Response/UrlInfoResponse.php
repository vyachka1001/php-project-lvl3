<?php

namespace App\Dto\Response;

class UrlInfoResponse
{
    private ?string $h1;
    private ?string $title;
    private ?string $description;
    private int $status;
    private int $urlId;

    /**
     * Create new UrlInfoRepsonse object.
     *
     * @param string $h1 url's page h1
     * @param string $title url's page title
     * @param string $description url's page description
     * @param int $status response's status code
     * @param int $id url's id in database
     */
    public function __construct(?string $h1, ?string $title, ?string $description, int $status, int $urlId)
    {
        $this->h1 = $h1;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->urlId = $urlId;
    }

    public function getH1(): ?string
    {
        return $this->h1;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getUrlId(): string
    {
        return $this->urlId;
    }
}
