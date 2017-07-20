<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/07/2017
 * Time: 14:43
 */

namespace Namlv\Tutorial\Helper;


use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Post extends AbstractHelper
{
    protected $_resourceModel;
    protected $_data;
    protected $_userFactory;
    protected $rootImage;
    protected $directoryList;

    public function __construct(
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,

        \Magento\Framework\App\Helper\Context $context,
        \Namlv\Tutorial\Model\ResourceModel\Post $resourceModel,
        \Magento\User\Model\UserFactory $userFactory
    )
    {
        $this->directoryList = $directoryList;
        $this->_resourceModel = $resourceModel;
        $this->_userFactory = $userFactory;
//        $this->_data = $this->_resourceModel->getPostStore()
        parent::__construct($context);
    }

    /**
     * @return string
     */
    public function getRootImage()
    {
        $postPathUpload = $this->directoryList->getRoot() . DIRECTORY_SEPARATOR . DirectoryList::PUB . DIRECTORY_SEPARATOR . DirectoryList::MEDIA . DIRECTORY_SEPARATOR;
        return $postPathUpload . \Namlv\Tutorial\Model\ResourceModel\Post::FILE_PATH_UPLOADED;
    }

    /**
     * @return array|bool
     */
    public function getPostEnable()
    {
        $select = $this->_resourceModel->getConnection()->select()
            ->from(['post' => $this->_resourceModel->getMainTable()])
            ->where('post.status=?', 1);
        $result = $this->_resourceModel->getConnection()->fetchAssoc($select);
        return $result ? $result : false;
    }


    /**
     * @param $limit
     * @return float|int
     */
    public function getNumberPage($limit)
    {
        $result = $this->getPostEnable();
        if ($result)
            return ceil((count($result) / $limit));
        return 0;
    }


    /**
     * @param $page
     * @param $limit
     * @return array|bool
     */
    public function getPage($page, $limit)
    {
        if (!is_int($page))
            $page = 1;
        elseif (($page > $this->getNumberPage($limit)) || $page < 1)
            $page = 1;
        $select = $this->_resourceModel->getConnection()->select()
            ->from(['post' => $this->_resourceModel->getMainTable()])
            ->where('post.status=?', 1)
            ->limit($limit, ($page - 1) * $limit);
        $result = $this->_resourceModel->getConnection()->fetchAssoc($select);
        return $result ? $result : false;
    }

    public function getSession($key, $default)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * get number post default in page
     * @return mixed
     */
    public function getDefaultNumberInPage()
    {
        return $this->scopeConfig->getValue('web/tutorial/numberInPage', ScopeInterface::SCOPE_STORE, null);
    }
}