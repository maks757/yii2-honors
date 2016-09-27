<?php

namespace bl\honors\entities;

use bl\imagable\BaseImagable;
use bl\imagable\helpers\base\BaseFileHelper;
use bl\multilang\behaviors\TranslationBehavior;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "honor".
 *
 * @property integer $id
 * @property string $image
 * @property integer $translation_id
 * @property HonorTranslation $translation
 */
class Honor extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            'translation' => [
                'class' => TranslationBehavior::className(),
                'translationClass' => HonorTranslation::className(),
                'relationColumn' => 'honor_id'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'honor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery|HonorUser[]
     */
    public function getHonorUser()
    {
        return $this->hasMany(HonorUser::className(), ['id' => 'honor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery|HonorUser[]
     */
    public function getTranslations()
    {
        return $this->hasMany(HonorTranslation::className(), ['honor_id' => 'id']);
    }

    public function getImage($image_name, $category, $type)
    {
        /**@var BaseImagable $imagine */
        $imagine = \Yii::$app->imagableHonor;
        $imagePath = $imagine->get($category, $type, $image_name);
        $aliasPath = BaseFileHelper::normalizePath(Yii::getAlias('@frontend/web'));
        $image = str_replace($aliasPath,'',$imagePath);
        return $image;
    }
}
