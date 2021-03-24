<?php

namespace EmailMarketing\Services;

interface ListInterface
{
    public function get(array $conditions = []);

    public function create(array $params = []);

    public function update(?string $uniqueID, array $params = []);

    public function delete(?string $uniqueID);
}