<?php

namespace Lyrixx\Bundle\FortuneBundle\Entity;

class Search
{
    private $orderBy;
    private $search;
    private $exactMatching;

    public function __construct(array $params = array())
    {
        $defaults = array(
            'orderBy' => null,
            'search' => null,
            'exactMatching' => false,
        );

        if ($diff = array_diff_key($params, $defaults)) {
            throw new \InvalidArgumentException(sprintf('This method only accept the following options: "%s". Extra options sended: "%s"', implode('", "', array_keys($defaults)), implode('", "', array_keys($diff))));

        }

        $params = array_replace($defaults, $params);

        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
    }

    public function orderBy()
    {
        return $this->orderBy;
    }

    public function search()
    {
        return $this->search;
    }

    public function exactMatching()
    {
        return $exactMatching;
    }
}
