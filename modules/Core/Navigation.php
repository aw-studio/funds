<?php

namespace Funds\Core;

class Navigation
{
    protected array $items = [];

    public function register(
        string $title,
        ?string $routeName,
        ?string $active = null,
        ?string $permission = null,
        ?string $badge = null,
    ): void {
        $this->items[] = [
            'title' => $title,
            'route' => route($routeName),
            'active' => $active ?? request()->routeIs($routeName),
            'permission' => $permission,
            'badge' => $badge,
        ];
    }

    public function items(): array
    {
        return $this->items;
    }
}
