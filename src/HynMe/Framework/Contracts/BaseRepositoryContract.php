<?php namespace HynMe\Framework\Contracts;

interface BaseRepositoryContract
{
    /**
     * Create a pagination object
     * @param int $per_page
     * @return mixed
     */
    public function paginated($per_page = 20);
}