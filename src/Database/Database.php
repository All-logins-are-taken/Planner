<?php

declare(strict_types=1);

namespace App\Database;

use PDOStatement;

interface Database
{
    public function connect(string $dsn, string $user = '', string $pass = '', array $options = []): void;

    public function prepare(string $sql): ?PDOStatement;
}
