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
     * @var string
     */
    protected $url;

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
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return array(
            'type' => $this->getType(),
            'url'  => $this->getUrl(),
        );
    }

    /**
     * @param array $data
     *
     * @return Repository
     */
    public function fromArray(array $data)
    {
        $this->type = $data['type'];
        $this->url  = $data['url'];

        return $this;
    }
}
