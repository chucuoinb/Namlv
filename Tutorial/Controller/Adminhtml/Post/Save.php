<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/07/2017
 * Time: 11:45
 */

namespace Namlv\Tutorial\Controller\Adminhtml\Post;


use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Namlv\Tutorial\Model\ResourceModel\Post;
use Namlv\Tutorial\Model\PostFactory;

class Save extends Action
{
    protected $postFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
    /**
     *
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $_directoryList;

    /**
     *
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $_fileUploaderFactory;

    public function __construct(
        PostFactory $postFactory,
        Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
    )
    {
        $this->postFactory = $postFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_directoryList = $directoryList;
        $this->_fileUploaderFactory = $fileUploaderFactory;
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
        $resultRedirect = $this->resultRedirectFactory->create();
        $request = $this->getRequest();
        $data = $this->getRequest()->getPostValue();
//        var_dump($data);
        if ($data) {
            $id = $request->getParam('id');
            $model = $this->postFactory->create()->load($id);
            if (!$model->getData('id') && $id) {
                $this->messageManager->addError(__('post not exist'));
                return $resultRedirect->setPath('*/*/');
            }
            $postPathUpload = $this->_directoryList->getRoot() . DIRECTORY_SEPARATOR . DirectoryList::PUB . DIRECTORY_SEPARATOR . DirectoryList::MEDIA . DIRECTORY_SEPARATOR;
            $deleteImage = null;
            if (!empty($data['image'])) {
                if (is_array($data['image'])) {
                    $deleteImage = !empty($data['image']['delete']) ? $data['image']['delete'] : 0;
                    if ($deleteImage) {
                        $imageFile = $data['image']['value'];
                    } else {
                        $data['image'] = $data['image']['value'];
                    }
                }
            }
            $model->setData($data);
            if ($deleteImage) {
                if (file_exists($postPathUpload . $imageFile)) {
                    unlink($postPathUpload . $imageFile);
                }
            }
            try {
                $model->save();
                $this->messageManager->addSuccess(__("saved"));
                $this->_eventManager->dispatch('tutorial_save_observer', ['id' => $model->getId()]);

                try {
                    $uploader = $this->_fileUploaderFactory->create(['fileId' => 'image']);
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                    $uploader->setAllowRenameFiles(true);
                    $newName = $this->createFilename() . '.' . $uploader->getFileExtension();
                    $image = $uploader->save($postPathUpload . Post::FILE_PATH_UPLOADED, $newName);

                    if (!empty($image['file'])) {
                        $imageOld = !empty($data['image']) ? $data['image'] : 'search-image-file.jpg';
                        $data['image'] = Post::FILE_PATH_ACCESS . $newName;
                        $model->setData($data);
                        $model->save();

                        if (file_exists($postPathUpload . $imageOld)) {
                            unlink($postPathUpload . $imageOld);
                        }
                    }
                } catch (\Exception $e) {
                    if ($e->getCode() != \Magento\Framework\File\Uploader::TMP_NAME_EMPTY) {
                        $this->messageManager->addError(__('Can not save image: ' . $e->getMessage()));
                        return $resultRedirect->setPath('*/*/edit', ['id' => $model->getData('id')]);
                    }
                }
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving.'));
                $this->messageManager->addError($e->getMessage());
            }
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getData('id')]);
            }

            return $resultRedirect->setPath('*/*/');

            $this->_getSession()->setFormData($data);
            if ($request->getParam('id'))
                return $resultRedirect->setPath('*/*/edit');
            return $resultRedirect->setPath('*/*/new');


        }
        return $resultRedirect->setPath('*/*/');


    }

    /**
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        if ($this->_authorization->isAllowed('Namlv_Tutorial::post_edit')
            || $this->_authorization->isAllowed('Namlv_Tutorial::post_new')
        ) {
            return true;
        }
        return false;
    }

    public function createFilename()
    {
        $keys = array_merge(range(0, 9), range('a', 'z'));
        $name = time() . $keys[array_rand($keys)] . $keys[array_rand($keys)] . $keys[array_rand($keys)];
        return $name;
    }
}