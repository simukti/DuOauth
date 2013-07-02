<?php
/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
namespace DuOauth\Mapper;

interface UserFinderInterface
{
    /**
     * This method implementation must return single array/object contain "username" key, 
     * or boolean false if user does not exists.
     * 
     * @param   string      $username
     * @return  array|false
     */
    public function findOneByUsername($username);
}
