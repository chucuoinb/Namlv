<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17/07/2017
 * Time: 08:47
 */

namespace Namlv\Tutorial\Controller\Post;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;

class View extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    protected $_coreRegistry;


    /**
     * @var \Namlv\Tutorial\Model\ResourceModel\Post
     */
    protected $_resourceModel;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Namlv\Tutorial\Model\ResourceModel\Post $resourceModel,
        \Magento\Framework\Registry $registry

    ) {
        $this->_coreRegistry=$registry;
        $this->_resourceModel  = $resourceModel;
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
        $id = $this->getRequest()->getParam('id');
        /** @var \Namlv\Tutorial\Model\Post $model */

        $model = $this->_objectManager->create('Namlv\Tutorial\Model\Post');
        $model->load($id);
        if(!$model->getData('id')){
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }
        $this->_coreRegistry->register('namlv_tutorial_view',$model);
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;

    }
}