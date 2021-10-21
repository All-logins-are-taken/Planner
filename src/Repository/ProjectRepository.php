<?php

declare(strict_types=1);

namespace App\Repository;

use App\Container\ServiceContainer;
use App\Exception\NotFoundException;
use ReflectionException;

class ProjectRepository
{
    public function __construct(
        private ServiceContainer $container,
    ) {
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function add(array $parameters = []): void
    {
        $project = $this->container->get('Project');

        $query = 'INSERT INTO `projects` (`title`, `preview_path`, `images_paths`, `hit`, `created_at`) 
        VALUES("' . $parameters['title'] . '", "' . $parameters['preview_path'] . '", "' . addslashes(serialize($parameters['images_paths'])) . '", 0,  NOW())'
        ;

        $project->query($query);
        $project->perform();
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function retrieve(): array
    {
        $project = $this->container->get('Project');

        $query = 'SELECT `id`, `title`, `preview_path` FROM `projects`';
        $project->query($query);

        return $project->all();
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function search(int $id): array
    {
        $project = $this->container->get('Project');

        self::hit($id);

        $query = 'SELECT `title`, `images_paths`, `hit` FROM `projects`';
        $project->query($query);

        return $project->single();
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function hit(int $id): void
    {
        $project = $this->container->get('Project');

        $query = 'UPDATE `projects` SET `hit` = `hit` + 1 WHERE `id` = '.$id;
        $project->query($query);
        $project->perform();
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function createProjects()
    {
        $project = $this->container->get('Project');

        $query = 'CREATE TABLE IF NOT EXISTS `projects` (
          `id` int NOT NULL AUTO_INCREMENT,
          `title` varchar(255) NOT NULL,
          `preview_path` varchar(255) NOT NULL,
          `images_paths` text NOT NULL,
          `hit` int NOT NULL,
          `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;';

        $project->query($query);
        $project->perform();
    }
}
