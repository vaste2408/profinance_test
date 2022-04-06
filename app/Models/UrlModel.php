<?php

namespace App\Models;

/**
 * Модель управления урлами. Умеет создавать сокращенные ссылки. Умеет восстанавливать сокращенные ссылки.
 * Модель получилась немного активРекордной, но не страшно.
 */
class UrlModel
{
    protected string $url;
    protected ?string $shortUrl;
    protected string $storageFile = 'links.json';
    protected array $links;

    public function __construct($url)
    {
        $this->url = $url;
        $this->shortUrl = null;
        $this->links = [];
    }

    /**
     * Возвращает обновлённый список линков из базы для поиска
     * @return array|mixed
     */
    public function getLinks(): mixed
    {
        $this->links = $this->readLinks();
        return $this->links;
    }

    /**
     * Восстановление сокращенной ссылки, если она имеется в хранилище
     * @param $short
     * @return string|null
     */
    public function restoreShortUrl($short): string|null
    {
        foreach ($this->getLinks()  as $url => $value) {
            if ($value === $short) {
                return $url;
            }
        }
        return null;
    }

    /**
     * Получение сокращенной ссылки
     * @return mixed|string|null
     */
    public function getShortCode(): mixed
    {
        $this->shortUrl = $this->shortUrl ?? $this->loadShortCode() ?? $this->createShortCode();
        return $this->shortUrl;
    }

    /**
     * Поиск в базе сокращенной ссылки
     * @return mixed|null
     */
    protected function loadShortCode(): mixed
    {
        return  $this->getLinks()[$this->url] ?? null;
    }

    /**
     * Создание сокращенной ссылки
     * @return string|null
     */
    protected function createShortCode(): ?string
    {
        $this->shortUrl = $this->formShortCode();
        return $this->saveShortCode() ? $this->shortUrl : null;
    }

    /**
     * Формирование сокращенной ссылки.
     * В данном случае это просто таймштамп
     * @return string
     */
    protected function formShortCode(): string
    {
        return (string) (new \DateTime('now'))->getTimestamp();
    }

    /**
     * Получение записей из базы
     * @return mixed
     */
    protected function readLinks(): mixed
    {
        return json_decode(file_get_contents($this->storageFile), true) ?? [];
    }

    /**
     * Запись сохранённой ссылки в базу
     * @return bool|int
     */
    protected function saveShortCode(): bool|int
    {
        return file_put_contents($this->storageFile, json_encode(array_merge($this->links, [$this->url => $this->shortUrl])));
    }
}
