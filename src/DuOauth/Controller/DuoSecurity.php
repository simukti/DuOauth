<?php
/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
namespace DuOauth\Controller;

use Zend\View\Model\ViewModel;

class DuoSecurity extends BaseController
{
    public function userVerifyAction()
    {
        $configs = $this->getConfigs();
        $twitter = $this->getTwitterService()->getTwitter();
        $auth    = $this->getUserService()->getAuthService();
        
        if($auth->hasIdentity()) {
            return $this->redirect()->toRoute($configs['route_after_success']);
        }
        
        if(! $twitter->isAuthorised()) {
            return $this->redirect()->toRoute('duoauth-login-index');
        }
        
        // user existence checking
        $result = $this->getUserService()->verifyUser($twitter->getUsername());
        if(! $result) {
            return $this->redirect()->toRoute('duoauth-login-logout');
        }
        
        return new ViewModel($result);
    }
    
    public function responseVerifyAction()
    {
        $request = $this->getRequest();
        $twitter = $this->getTwitterService()->getTwitter();
        
        if( (! $request->isPost()) || (! $twitter->isAuthorised()) ) {
            return $this->redirect()->toRoute('duoauth-duosecurity-userverify');
        }
        
        if( $request->getPost('sig_response', false) !== false ) {
            $response    = $request->getPost('sig_response');
            $userService = $this->getUserService();
            $authAdapter = $userService->getAuthAdapter();
            $authAdapter->setIdentity($twitter->getUsername())
                        ->setCredential($response);
            $authentication = $userService->getAuthService()->authenticate($authAdapter);
            
            /**
             * @todo set flash message for route_after_success and route_after_failed
             */
            if(! $authentication->isValid()) {
                return $this->redirect()->toRoute('duoauth-login-logout');
                
            }
            $configs = $this->getConfigs();
            return $this->redirect()->toRoute($configs['route_after_success']);
        }
    }
}
