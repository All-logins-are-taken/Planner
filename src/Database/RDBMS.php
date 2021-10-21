<?php

declare(strict_types=1);

namespace App\Database;

use Exception;
use PDO;
use PDOStatement;

class RDBMS implements Database
{
    protected ?PDO $db = null;

    /**
     * @throws Exception
     */
    public function connect(string $dsn, string $user = '', string $pass = '', array $options = []): void
    {
        $this->db = new PDO($dsn, $user, $pass, $options);

        if (empty($this->db)) {
            throw new Exception('PDO MySQL not enabled or installed');
        }
    }

    public function prepare(string $sql): ?PDOStatement
    {
        return $this->db->prepare($sql);
    }

    public function last(): string
    {
        return $this->db->lastInsertId();
    }
}
