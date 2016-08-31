<?php

namespace SatisAdmin\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class Config implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $homepage;

    /**
     * @var boolean
     */
    protected $requireAll;

    /**
     * @var Repository[]
     */
    protected $repositories = [];

    /**
     * @param string $homepage
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;
    }

    /**
     * @return string
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Repository[] $repositories
     */
    public function setRepositories(array $repositories)
    {
        $this->repositories = $repositories;
    }

    /**
     * @return Repository[]
     */
    public function getRepositories()
    {
        return $this->repositories;
    }

    /**
     * @param int $index
     *
     * @return Repository
     */
    public function getRepository($index)
    {
        return $this->repositories[$index];
    }

    /**
     * @param boolean $requireAll
     */
    public function setRequireAll($requireAll)
    {
        $this->requireAll = $requireAll;
    }

    /**
     * @return boolean
     */
    public function getRequireAll()
    {
        return $this->requireAll;
    }

    /**
     * @param Repository $repository
     */
    public function addRepository(Repository $repository)
    {
        $this->repositories[] = $repository;
    }

    /**
     * @param Repository|int $repository
     */
    public function removeRepository($repository)
    {
        if ($repository instanceof Repository) {
            $repository = array_search($repository, $this->repositories);
        }

        unset($this->repositories[$repository]);
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return [
            'name'         => $this->getName(),
            'homepage'     => $this->getHomepage(),
            'require-all'  => $this->getRequireAll(),
            'repositories' => array_values($this->getRepositories()),
        ];
    }

    /**
     * @param array $data
     *
     * @return Config
     */
    public function fromArray(array $data)
    {
        $this->name       = isset($data['name']) ? $data['name'] : '';
        $this->homepage   = isset($data['homepage']) ? $data['homepage'] : '';
        $this->requireAll = isset($data['require-all']) ? $data['require-all'] : false;

        if (!isset($data['repositories'])) {
            return $this;
        }

        foreach ($data['repositories'] as $repository) {
            $this->addRepository(Repository::create($repository['type'])->fromArray($repository));
        }

        return $this;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('homepage', new Assert\NotBlank);
    }
}
