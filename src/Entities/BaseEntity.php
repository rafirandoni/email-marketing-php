<?php

namespace EmailMarketing\Entities;

class BaseEntity
{
    protected array $data;

    public function __construct(array $data = [])
    {
        $this->apply($data);
    }

    protected function apply(array $data = [])
    {
        $this->data = $data;
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}
