<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14/07/2017
 * Time: 16:41
 */

namespace Namlv\Tutorial\Controller\Post;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;

class Index extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * @var \Namlv\Tutorial\Model\ResourceModel\Post
     */
    protected $_resourceModel;
    protected $_coreRegistry;
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Namlv\Tutorial\Model\ResourceModel\Post $resourceModel,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->_coreRegistry=$registry;
        $this->_resourceModel  = $resourceModel;
        $this->_resultForwardFactory = $resultForwardFactory;
        $this->_resultPageFactory    = $resultPageFactory;
        return parent::__construct($context);
    }
    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        echo '<script>console.log("Your stuff here")</script>';

        $page = $this->getRequest()->getParam('page');
        if (!$page)
            $page=1;
        $this->_coreRegistry->register('namlv_tutorial_page',$page);
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;

    }
}