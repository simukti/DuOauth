<?php
/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
namespace DuOauth\Mapper;

/**
 * This is a dummy mapper, you can safely delete this file.
 */
class Dummy implements UserFinderInterface
{
    protected $users = array(
        'simukti' => array(
            'username' => 'simukti',
            'fullname' => 'Sarjono Mukti Aji',
            'role'     => 'superuser'
        )
    );
    
    /**
     * It's a "database" checking for user existence.
     * 
     * findOneByUsername() will called from authentication process, 
     * so whatever your user existence checking method, ensure that you will return false if user does not exists, 
     * OR, array result that contain 'username' key (or defined in configs['username_columnName'])
     * OR, (stdClass/domain model) result with 'username' property (or defined in configs['username_columnName'])
     * 
     * @param   username $username
     * @return  false|mixed
     */
    public function findOneByUsername($username)
    {
        if(! array_key_exists($username, $this->users)) {
            return false;
        }
        return $this->users[$username];
    }
}
