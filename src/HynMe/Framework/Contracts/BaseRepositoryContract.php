<?php namespace HynMe\Framework\Contracts;

interface BaseRepositoryContract
{
    /**
     * Create a pagination object
     * @param int $per_page
     * @return mixed
     */
    public function paginated($per_page = 20);


    /**
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function newInstance($type);

    /**
     * Starts a querybuilder
     * @param $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function queryBuilder($type);
}