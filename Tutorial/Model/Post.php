<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/07/2017
 * Time: 09:48
 */

namespace Namlv\Tutorial\Model;


use Magento\Framework\Model\AbstractModel;
use Namlv\Tutorial\Api\PostApiInterface;

class Post extends AbstractModel
{
    const CACHE_TAG = 'namlv_tutorial';
    protected function _construct()
    {
        $this->_init('Namlv\Tutorial\Model\ResourceModel\Post');
    }

}