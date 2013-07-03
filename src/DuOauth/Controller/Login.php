<?php
/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
namespace DuOauth\Controller;

use Zend\View\Model\ViewModel;

class Login extends BaseController
{
    public function indexAction()
    {
        $configs   = $this->getConfigs();
        $twitter   = $this->getTwitterService()->getTwitter();
        $auth      = $this->getUserService()->getAuthService();
        
        if($auth->hasIdentity()) {
            return $this->redirect()->toRoute($configs['route_after_success']);
        } elseif ($twitter->isAuthorised()) {
            return $this->redirect()->toRoute('duoauth-duosecurity-userverify');
        } else {
            $viewModel = new ViewModel(array(
                'twitter' => $twitter
            ));
            return $viewModel;
        }
    }
    
    public function logoutAction()
    {
        $configs = $this->getConfigs();
        $auth    = $this->getUserService()->getAuthService();
        
        if($auth->hasIdentity()) {
            $auth->clearIdentity();
        }
        
        $sessionManager = $this->getSessionService()->getSessionManager();
        if($sessionManager->isValid()) {
            $sessionManager->forgetMe();
            $sessionManager->destroy();
        }
        
        return $this->redirect()->toRoute($configs['route_after_logout']);
    }
}
