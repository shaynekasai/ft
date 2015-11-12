<?php
namespace Core\Model;

 use Zend\Db\TableGateway\TableGateway;

 class UrlPackageTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getUrl($id)
     {

         $field = is_numeric($id) == true ? 'id' : 'url';
         $id    = is_numeric($id) == true ? (int) $id : (string) $id;

         $rowset = $this->tableGateway->select(array($field => $id));
         $row = $rowset->current();

         if (!$row) {
             return false;
         }
         return $row;
     }

     public function getUrlByHash($hash) {

        $rowset = $this->tableGateway->select(array('hash' => $hash));
        $row = $rowset->current();

         if (!$row) {
             return false;
         }
         
         return $row;
     }

     private function updateHash($id) {
        $result = $this->getUrl($id);

        if ($result) {
            $data = array(
                    'hash' => hash('crc32', $id)
                );
            $this->tableGateway->update($data, array('id' => $id));
         } else {
             throw new \Exception('Unable to update hash, id does not exist');
         }
     }

     public function addUrl(UrlPackage $urlPackage)
     {
        if(filter_var($urlPackage->url, FILTER_VALIDATE_URL) === false) {
            throw new \Exception('Invalid URL');
        } 

        $data = array(
             'url' => $urlPackage->url
        );

        if($row = $this->getUrl($urlPackage->url)) {
            return $row;
        } else {
            $this->tableGateway->insert($data);
            $insertId = $this->tableGateway->lastInsertValue;
            $this->updateHash($insertId);

            return $this->getUrl($insertId);

        }
        
     }

    
     public function deleteUrl($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
     
 }
 ?>