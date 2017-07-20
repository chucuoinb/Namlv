<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/07/2017
 * Time: 14:24
 */

namespace Namlv\Tutorial\Controller\Adminhtml\Post;


use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;

class Edit extends Action
{
    const ADMIN_RESOURCE = 'Namlv_Tutorial::post_edit';
    protected $_coreRegistry;
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    protected function _initAction(){
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Namlv_Tutorial::post');
        return $resultPage;
    }
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('Namlv\Tutorial\Model\Post');
        $model->setData([]);
        if ($id && (int)$id >0){
            $model->load($id);
            if (!$model->getData('id')){
                $this->messageManager->addError(__('id not exist'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
            $title = $model->getData('title');
        }
        $formData = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if(!empty($formData)){
            $model->setData($formData);
        }
        $this->_coreRegistry->register('namlv_tutorial_edit',$model);

        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id? __('Edit Post'):('New Post'),
            $id? __('Edit Post'):('New Post')
        );
        $resultPage->getConfig()->getTitle()->prepend('Post manage');
        $resultPage->getConfig()->getTitle()->prepend($id?'Edit: '.$title.'('.$id.')':__('New Post'));
        return $resultPage;
    }
}