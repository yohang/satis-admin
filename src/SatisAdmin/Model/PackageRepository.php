<?php

namespace SatisAdmin\Model;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class PackageRepository extends Repository
{
    /**
     * @var array
     */
    protected $package = [];

    /**
     * @param array $package
     */
    public function setPackage(array $package)
    {
        $this->package = $package;
    }

    /**
     * @return array
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), ['package' => $this->getPackage()]);
    }

    /**
     * {@inheritDoc}
     */
    public function fromArray(array $data)
    {
        $this->package = isset($data['package']) ? $data['package'] : [];

        return parent::fromArray($data);
    }
}
