<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/07/2017
 * Time: 09:58
 */

namespace Namlv\Tutorial\Model\ResourceModel\Post;


class CollectionFactory
{
    protected $_objectManager = null;
    protected $_instanceName = null;
    function __construct(\Magento\Framework\ObjectManagerInterface $objectManager,
                         $instanceName = '\\Namlv\\Tutorial\\Model\\ResourceModel\\Post\\Collection')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }
    public function create(array $data = []){
        return $this->_objectManager->create($this->_instanceName,$data);
    }
}