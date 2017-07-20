<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/07/2017
 * Time: 09:54
 */

namespace Namlv\Tutorial\Model\ResourceModel\Post;



use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected function _construct()
    {
        $this->_init('Namlv\Tutorial\Model\Post','Namlv\Tutorial\Model\ResourceModel\Post');
    }
}