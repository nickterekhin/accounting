<?php


namespace App\Models\ModelProvider;


use Eloquent;
use Illuminate\Database\Eloquent\Collection;

interface IBaseModel
{
    /**
     * @param array $options
     * @return Eloquent
     */
    function create(array $options);

    /**
     * @return Collection
     */
    function getAll();

    /**
     * @param Eloquent $object
     * @return bool
     */
    function update($object);

    /**
     * @param $id
     * @return Eloquent
     */
    function getById($id);

    /**
     * @param Eloquent $object
     * @return bool
     */
    function delete($object);

    /**
     * @return Collection
     */
    public function getAllActive();
}