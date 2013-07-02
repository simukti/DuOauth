<?php
/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
namespace DuOauth\Authentication\Adapter;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Authentication\Exception\InvalidArgumentException;
use \Duo;

class DuoSecurity implements AdapterInterface
{
    protected $identity;
    protected $credential;
    protected $duoConfigs;
    
    public function setDuoConfigs(array $configs)
    {
        $this->duoConfigs = $configs;
        return $this;
    }
    
    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }
    
    public function setCredential($credential)
    {
        $this->credential = $credential;
        return $this;
    }
    
    public function authenticate()
    {
        if( (! $this->identity) || (! $this->credential) ) {
            throw new InvalidArgumentException('Identity or credential was not provided.');
        }
        
        $validUser = $this->validateResponse($this->credential);
        
        if(! $validUser) {
            $code    = Result::FAILURE;
            $message = 'Invalid TFA Response.';
        } else {
            $code    = Result::SUCCESS;
            $message = 'Authentication Success.';
        }
        
        $result = new Result($code, $this->identity, array($message));
        return $result;
    }
    
    public function validateResponse($response)
    {
        if(! $this->duoConfigs) {
            throw new InvalidArgumentException('Duo configs was not provided.');
        }
        
        $duoConfigs    = $this->duoConfigs;
        $validResponse = Duo::verifyResponse($duoConfigs['ikey'],
                                             $duoConfigs['skey'],
                                             $duoConfigs['akey'],
                                             $response);
        return ($validResponse !== null) ? true : false;
    }
}
