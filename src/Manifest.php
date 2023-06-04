<?php

declare(strict_types=1);

namespace Drzl;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Yaml;

final class Manifest {

    protected readonly string $filename;

    protected array $values;

    public function __construct(protected readonly Filesystem $storage)
    {
        $this->filename = strtolower(config('app.name')) . '.yml';
        
        $this->values = Yaml::parse(
            $this->storage->get($this->filename) ?? ''
        ) ?? [];
    }

    public function update(array $values): bool
    {
        $this->values = $values;
        
        return $this->storage->put($this->filename, Yaml::dump($values));
    }

    public function values(): Collection
    {
        return collect($this->values);
    }

    public function path(): string
    {
        return $this->storage->path($this->filename);
    }

    public static function default(): array
    {
        return [
            'name' => config('app.name'),
            'servers' => [
                '129.168.0.1'
            ]
        ];
    }
}