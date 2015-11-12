<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\View\Helper\ServerUrl;

use Core\Model\UrlPackage;


class ActionsController extends AbstractActionController
{
    protected $urlPackageTable;

    public function getUrlPackageTable()
    {
         if (!$this->urlPackageTable) {
             $sm = $this->getServiceLocator();
             $this->urlPackageTable = $sm->get('Core\Model\UrlPackageTable');
         }
         return $this->urlPackageTable;
    }

    public function addAction()
    {
        //$this->getUrlPackageTable()->addUrl(...)

        $request = $this->getRequest();
       
        $baseUrl = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost();

        if ($request->isPost()) {
            $urlPackage =  new UrlPackage();

            $urlPackage->url =  $request->getPost('url');

            $package = $this->getUrlPackageTable()->addUrl($urlPackage);

            return (new JsonModel(array(
                'action' => 'add',
                'result'=>'success',
                'url'    => $baseUrl . '/' . $package->hash,
                'data' => $package
            )));
            
        }


       return (new JsonModel(array(
                'action' => 'add',
                'result' =>'error'
            )));
    }
    public function deleteAction()
    {
        
    }

    public function getAction() {
    
        $results = $this->getUrlPackageTable()->getUrlByHash($this->params()->fromRoute('hash'));

        if($results) {
            $this->redirect()->toUrl($results->url);
        } else {

            $this->getResponse()->setStatusCode(404);
            return;
        }
    }

    public function listAction()
    {
        //$package = $this->getUrlPackageTable()->addUrl($urlPackage);
        $data = array();
        $results = $this->getUrlPackageTable()->fetchAll();
        foreach($results as $result) {
            $data[] = $result;
        }
        return ( new JsonModel(array(
	       'action' => 'list',
           'success'=> true,

           'data'   => $data
        )) );
    }
}
