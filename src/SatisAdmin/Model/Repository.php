<?php

namespace SatisAdmin\Model;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class Repository implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return ['type' => $this->getType()];
    }

    /**
     * @param array $data
     *
     * @return Repository
     */
    public function fromArray(array $data)
    {
        $this->type = $data['type'];

        return $this;
    }

    /**
     * @param string $type
     *
     * @return Repository
     */
    public static function create($type)
    {
        $class = __NAMESPACE__.'\\'.ucfirst($type).'Repository';

        return (new $class)->fromArray(['type' => $type]);
    }
}
