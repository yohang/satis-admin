<?php

namespace SatisAdmin\Model;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class ComposerRepository extends Repository
{
    /**
     * @var string
     */
    protected $url;

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
        return array_merge(parent::jsonSerialize(), ['url' => $this->getUrl()]);
    }

    /**
     * {@inheritDoc}
     */
    public function fromArray(array $data)
    {
        $this->url = $data['url'];

        return parent::fromArray($data);
    }

    /**
     * {@inheritDoc}
     */
    public function getParams()
    {
        return ['URL' => $this->getUrl()];
    }
}
