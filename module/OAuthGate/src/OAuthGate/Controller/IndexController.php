<?php
/**
 * OAuthGate
 * Require users to be authenticated through OAuth before using the site
 * See Module.php for the event management
 */

namespace OAuthGate\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function authenticateAction()
    {
        $token = null;
        $info = null;
        $me = $this->getServiceLocator()->get('ReverseOAuth2\Google');

        if (strlen($this->params()->fromQuery('code')) > 10) {

            if($me->getToken($this->request)) {
                $token = $me->getSessionToken(); // token in session
            } else {
                $token = $me->getError(); // last returned error (array)
            }

            $info = $me->getInfo();

        } else {

            $url = $me->getUrl();

        }

        return array('token' => $token, 'info' => $info, 'url' => $url);
    }

    public function authenticateReturnAction(){

    }

    public function logoutAction()
    {
        return new ViewModel();
    }
}
