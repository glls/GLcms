<?php

class FileUpload
{

    // The Content ID
    private $_id = null;

    // The end response
    private $_response = null;

    // The response object
    public $_result = [];

    /**
     * Constructor for handling uploads
     * @param int $id The content id
     * @throws CHttpException
     */
    public function __construct($id)
    {
        $this->_id = $id;
        $this->_uploadFile();
    }

    /**
     * Handle normal file uploads
     * @return string
     * @throws CHttpException
     */
    private function _uploadFile()
    {
        $path = '/';
        $folder = Yii::app()->getBasePath() . '/../uploads' . $path;

        $sizeLimit = Yii::app()->params['max_fileupload_size'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
        $uploader = new FileUploader($allowedExtensions, $sizeLimit);

        $this->_result = $uploader->handleUpload($folder);

        if (isset($this->_result['error'])) {
            throw new CHttpException(500, $this->_result['error']);
        }
        return $this->_handleResourceUpload('/uploads/' . $this->_result['filename']);
    }

    /**
     * Generic function to handle all resource uploads
     * @param string $value The value that should be assigned to $meta->value
     * @return string
     * @throws CHttpException
     */
    private function _handleResourceUpload($value)
    {
        if ($this->_result['success'] == true) {
            $meta = ContentMetadata::model()->findbyAttributes([
                'content_id' => $this->_id,
                'key'        => $this->_result['filename']
            ]);

            if ($meta == null) {
                $meta = new ContentMetadata;
            }

            $meta->content_id = $this->_id;
            $meta->key = $this->_result['filename'];
            $meta->value = $value;
            if ($meta->save()) {
                $this->_result['filepath'] = $value;
                return $this->_result;
            } else {
                throw new CHttpException(400, 'Unable to save uploaded image.');
            }
        } else {
            return htmlspecialchars(CJSON::encode($this->_result), ENT_NOQUOTES);
            throw new CHttpException(400, $this->_result['error']);
        }
    }
}
