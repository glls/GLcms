<?php

class FileUploader
{

    private $allowedExtensions = [
        'png',
        'jpeg',
        'jpg',
        'gif',
        'bmp'
    ];

    private $sizeLimit = 10485760;

    private $file;

    /**
     * FileUploader constructor.
     * @param array $allowedExtensions
     * @param int $sizeLimit
     */
    function __construct(array $allowedExtensions = [], $sizeLimit = 10485760)
    {
        $allowedExtensions = array_map("strtolower", $allowedExtensions);

        $this->allowedExtensions = $allowedExtensions;
        $this->sizeLimit = $sizeLimit;

        $this->checkServerSettings();

        $this->file = false;
        if (isset($_FILES['file'])) {
            $this->file = new File();
        }
    }

    private function checkServerSettings()
    {
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));

        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit) {
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
            $json = CJSON::encode([
                'error' => 'increase post_max_size and upload_max_filesize'
            ]);
            die($json);
        }
    }

    /**
     * @param string $str
     * @return int|string
     */
    private function toBytes($str)
    {
        $val = trim($str);
        $last = strtolower($str[strlen($str) - 1]);
        switch ($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        return $val;
    }

    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     * @param string $uploadDirectory
     * @return array
     */
    public function handleUpload($uploadDirectory, $replaceOldFile = false)
    {
        if (!is_writable($uploadDirectory)) {
            return ['error' => "Server error. Upload directory isn't writable."];
        }

        if (!$this->file) {
            return ['error' => 'No files were uploaded.'];
        }

        $size = $this->file->size;

        if ($size == 0) {
            return ['error' => 'File is empty'];
        }

        $pathinfo = pathinfo($this->file->name);
        $filename = $pathinfo['filename'];

        //$filename = md5(uniqid());
        $ext = $pathinfo['extension'];

        if (!in_array(strtolower($ext), $this->allowedExtensions)) {
            $these = implode(', ', $this->allowedExtensions);
            return ['error' => "File has an invalid extension"];
        }

        $filename = 'upload-' . md5($filename);

        if (!$replaceOldFile) {
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }

        if ($this->file->save($uploadDirectory . $filename . '.' . $ext)) {
            return ['success' => true, 'filename' => $filename . '.' . $ext];
        } else {
            return ['error' => 'Could not save uploaded file. The upload was cancelled, or server error encountered'];
        }

    }
}
