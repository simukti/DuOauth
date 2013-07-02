<?php
/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
namespace DuOauth\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class Assets extends AbstractActionController
{
    protected $defaultHeaders = array(
        'cache-control' => 'public',
        'pragma'        => 'public',
        'connection'    => 'close'
    );
    
    public function getFileAction()
    {
        $file       = $this->params('file');
        $split      = explode('.', $file);
        $extension  = $split[(count($split) - 1)];
        $assetsDir  = realpath(__DIR__ . '/../../../public/');
        $valid      = true;
        
        switch ($extension) {
            case 'js':
                $contentType = 'text/javascript';
                $fileDir = '/js/';
                break;
            case 'css':
                $contentType = 'text/css';
                $fileDir = '/css/';
                break;
            default:
                $valid = false;
                break;
        }
        
        if(! $valid) {
            return $this->notFoundAction();
        }
        
        $realFile = $assetsDir.$fileDir.$file;
        if(! is_readable($realFile)) {
            return $this->notFoundAction();
        }
        $content =  @file_get_contents($realFile);
        
        $this->defaultHeaders['content-type'] = $contentType;
        $this->defaultHeaders['expires']      = gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT'; // 1 year
        
        $response = $this->getResponse();
        $response->getHeaders()->clearHeaders()
                 ->addHeaders($this->defaultHeaders);
        $response->setContent($content);
        
        return $response;
    }
}
