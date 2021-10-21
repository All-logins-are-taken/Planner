<?php

declare(strict_types=1);

namespace App\Model;

use App\Container\ServiceContainer;
use App\Database\RDBMS;
use App\Exception\NotFoundException;
use Exception;
use PDOStatement;
use ReflectionException;

class Project
{
    public const PATH_TO_VIEW = 'View/projects.php';
    public const PATH_TO_PREVIEW = 'View/project.php';
    public const DATABASE_SOURCE = 'mysql';
    public const MAX_PAGES_TO_IMPORT = 2;

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function __construct(
        private ServiceContainer $container,
        private PDOStatement $statement,
        private RDBMS $database
    ) {
        self::dbConnect();
    }

    public function query(string $sql): void
    {
        $this->statement = $this->database->prepare($sql);
    }

    public function perform(): bool
    {
        return $this->statement->execute();
    }

    public function all(): bool|array
    {
        $this->perform();

        return $this->statement->fetchAll();
    }

    public function single(): mixed
    {
        $this->perform();

        return $this->statement->fetch();
    }

    public function last(): string
    {
        return $this->database->last();
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     * @throws Exception
     */
    private function dbConnect(): void
    {
        $this->container->get('DotEnvService')->load();
        $dsn = self::DATABASE_SOURCE . ':host=' . getenv('MYSQL_HOST') . ';dbname=' . getenv('MYSQL_DATABASE');

        try {
            $this->database->connect($dsn, getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), []);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
