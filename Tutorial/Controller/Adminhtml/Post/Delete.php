<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14/07/2017
 * Time: 14:19
 */

namespace Namlv\Tutorial\Controller\Adminhtml\Post;


use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;

class Delete extends Action
{

    /**
     *
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $_directoryList;
    protected $_coreRegistry;
    const ADMIN_RESOURCE = 'Namlv_Tutorial::post_delete';

    public function __construct(
        Action\Context $context,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList
    )
    {
        $this->_directoryList = $directoryList;
        parent::__construct($context);
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
        $model = $this->_objectManager->create('Namlv\Tutorial\Model\Post');
            /** @var \Namlv\Tutorial\Model\Post $model */
        $model->load($id);
        $postPathUpload = $this->_directoryList->getRoot() . DIRECTORY_SEPARATOR . DirectoryList::PUB . DIRECTORY_SEPARATOR . DirectoryList::MEDIA . DIRECTORY_SEPARATOR;
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if($model->getData('id') && (int)$id>0){
            try{

            if ($model->getData('id')){
                $title = $model->getData('title');
                $image = $model->getData('image');
                $model->delete();
                if ($image && file_exists($postPathUpload.$image))
                    unlink($postPathUpload.$image);
                $this->messageManager->addSuccess(__($title.' has been deleted'));
                return $resultRedirect->setPath('*/*/');
            }
            }catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/');
            }
        }else{
            $this->messageManager->addError(__('Post not found'));
            return $resultRedirect->setPath('*/*/');
        }
    }
}