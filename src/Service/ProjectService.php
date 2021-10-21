<?php

declare(strict_types=1);

namespace App\Service;

use App\Container\ServiceContainer;
use App\Exception\NotFoundException;
use App\Model\Project;
use DOMDocument;
use Exception;
use PDOException;
use ReflectionException;

class ProjectService
{
    public function __construct(
        private ServiceContainer $container,
    ) {
    }

    public function renderPhp(string $path, array $options = []): bool|string
    {
        ob_start();
        include($path);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function isProjects(): bool
    {
        $repository = $this->container->get('ProjectRepository');

        try {
            $repository->retrieve();
        } catch (PDOException) {
            return false;
        }

        return true;
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     * @throws Exception
     */
    public function getPlannerProjects(): string
    {
        $httpClient = $this->container->get('HttpClient');
        $headers = self::headers();
        $projectsArray = [];

        foreach (range(1, Project::MAX_PAGES_TO_IMPORT) as $page) {
            $response = $httpClient->get(getenv('PLANNER_PROJECTS_URL') . $page, $headers);

            if (empty($response)) {
                throw new Exception('Error retrieving page');
            }
            $projectsArray[] = self::getPlannerProject($response);
        }

        return self::createProjects($projectsArray);
    }


    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    private function headers(): array
    {
        $this->container->get('DotEnvService')->load();

        return [
            'Accept: application/json',
            'Content-Type: application/json'
        ];
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    private function getPlannerProject($response): array
    {
        $dom = new DOMDocument();
        $dom->loadHTML($response);
        $projects = $dom->getElementById("gallery-masonry");
        $links = $projects->getElementsByTagName("a");
        $anchors = [];
        $previews = [];

        foreach ($links as $link) {
            $anchors[] = $link->getAttribute("href");
            $previews[] = $link->getElementsByTagName("img")[0]->getAttribute("src");
        }

        return self::getProjectPreview($anchors, $previews);
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     * @throws Exception
     */
    private function getProjectPreview($anchors, $previews): array
    {
        $httpClient = $this->container->get('HttpClient');
        $headers = self::headers();
        $projects = [];

        foreach ($anchors as $key => $value) {
            $response = $httpClient->get($value, $headers);

            if (empty($response)) {
                throw new Exception('Error retrieving preview page');
            }
            $projects[] = self::getProjectPreviewImages($response,  $previews[$key]);
        }

        return $projects;
    }

    private function getProjectPreviewImages($response, $preview): array
    {
        $dom = new DOMDocument();
        $dom->loadHTML($response);
        $title = $dom->getElementsByTagName("h1")[0]->textContent;
        $carousel = $dom->getElementById("gallery-plan-carousel");
        $links = $carousel->getElementsByTagName("img");
        $images = [];

        foreach ($links as $link) {
            $images[] = $link->getAttribute("src")."\n";
        }

        return ['title' => $title, 'preview_path' => $preview, 'images_paths' => $images];
    }

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    private function createProjects($projects): string
    {
        $repository = $this->container->get('ProjectRepository');

        $repository->createProjects();

        foreach ($projects as $key => $value) {
            foreach ($value as $item) {
                $repository->add($item);
            }
        }

        return 'Done';
    }
}
