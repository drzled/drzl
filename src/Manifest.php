<?php

declare(strict_types=1);

namespace Drzl;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Yaml;

final class Manifest {

    public readonly string $filename;

    protected array $values;

    public function __construct(protected readonly Filesystem $storage)
    {
        $this->filename = strtolower(config('app.name')) . '.yml';
        
        $this->values = Yaml::parse(
            $this->storage->get($this->filename) ?? ''
        ) ?? [];
    }

    function servers(): Collection {
        return collect(
            data_get($this->values, 'servers', [])
        );
    }

    public function primaryServer(): string
    {
        return $this->servers()->first(default: 'localhost');
    }

    public function update(array $values): bool
    {
        $this->values = $values;
        
        return $this->storage->put($this->filename, Yaml::dump($values));
    }

    public function created(): bool
    {
        return $this->update($this->default());
    }

    public function values(): Collection
    {
        return collect($this->values);
    }

    public function path(): string
    {
        return $this->storage->path($this->filename);
    }

    public function exists(): bool
    {
        return $this->storage->exists($this->filename);
    }

    public function default(): array
    {
        return [
            'name' => config('app.name'),
            'servers' => [
                '129.168.0.1'
            ]
        ];
    }
}