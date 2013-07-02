<?php
/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
namespace DuOauth\Controller;

class Twitter extends BaseController
{
    public function loginAction()
    {
        $twitter = $this->getTwitterService()->getTwitter();
        $session = $this->getSessionService()->getSessionContainer();
        $auth    = $this->getUserService()->getAuthService();
        
        if($auth->hasIdentity()) {
            return $this->redirect()->toRoute($this->configs['route_after_success']);
        } else if(! $twitter->isAuthorised()) {
            $session->requestToken = $twitter->getRequestToken();
            return $this->redirect()->toUrl($twitter->getRedirectUrl());
        } else {
            return $this->redirect()->toRoute('duoauth-duosecurity-userverify');
        }
    }
    
    public function callbackAction()
    {
        $request = $this->getRequest();
        $isValidCallback = $this->getTwitterService()->validateCallback($request);
        
        if(! $isValidCallback) {
            return $this->redirect()->toRoute('duoauth-login-logout');
        }
        // so we have valid callback here, 
        // now it's time to check user existence in \DuOauth\Controller\DuoSecurity::userVerifyActiion()
        return $this->redirect()->toRoute('duoauth-duosecurity-userverify');
    }
}
