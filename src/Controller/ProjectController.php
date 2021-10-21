<?php

declare(strict_types=1);

namespace App\Controller;

use App\Container\ServiceContainer;
use App\Exception\NotFoundException;
use App\Model\Project;
use ReflectionException;

class ProjectController
{
    public function __construct(
        private ServiceContainer $container,
    ) {
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function index(): string
    {
        $service = $this->container->get('ProjectService');

        if ($service->isProjects() === true)
        {
            $repository = $this->container->get('ProjectRepository');

            return $this->container->get('ProjectService')->renderPhp('../'.Project::PATH_TO_VIEW, ['projects' => $repository->retrieve()]);
        }

        return $this->container->get('ProjectService')->renderPhp('../'.Project::PATH_TO_VIEW);
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function import(): string
    {
        $service = $this->container->get('ProjectService');
        $service->getPlannerProjects();

        return 'complete';
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function preview(int $id): string
    {
        $repository = $this->container->get('ProjectRepository');

        return $this->container->get('ProjectService')->renderPhp('../'.Project::PATH_TO_PREVIEW, ['project' => $repository->search($id)]);
    }
}
