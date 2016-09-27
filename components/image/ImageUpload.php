<?php
/**
 * @author Maxim Cherednyk <maks757q@gmail.com, +380639960375>
 */

namespace bl\honors\components\image;


use bl\imagable\BaseImagable;
use Yii;
use yii\base\Model;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;


/** @property UploadedFile $image */
class ImageUpload extends Model
{
    public $image;

    public function rules()
    {
        return [
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if ($this->validate() && !empty($this->image)) {
            $newImageName = Yii::$app->security->generateRandomString(16);
            if(!is_dir(Yii::getAlias('@frontend/web/tmp/'))){
                BaseFileHelper::createDirectory(Yii::getAlias('@frontend/web/tmp/'));
            }
            $tmpFilePath = BaseFileHelper::normalizePath(Yii::getAlias('@frontend/web/tmp/').$newImageName.'.'.$this->image->extension);
            $this->image->saveAs($tmpFilePath);
            /** @var $imagable BaseImagable */
            $imagable = Yii::$app->imagableHonor;
            $imageName = $imagable->create('honor', $tmpFilePath);

            unlink($tmpFilePath);
            return $imageName;
        } else {
            return false;
        }
    }
}