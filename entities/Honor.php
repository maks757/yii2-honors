<?php

namespace bl\honors\entities;

use Yii;

/**
 * This is the model class for table "honor".
 *
 * @property integer $id
 * @property string $image
 * @property integer $translation_id
 */
class Honor extends \yii\db\ActiveRecord
{
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
            [['translation_id'], 'integer'],
            [['image'], 'string', 'max' => 60],
            [['translation_id'], 'exist', 'skipOnError' => true, 'targetClass' => HonorTranslation::className(), 'targetAttribute' => ['translation_id' => 'id']],
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
            'translation_id' => 'Translation ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery|HonorTranslation[]
     */
    public function getTranslations()
    {
        return $this->hasMany(HonorTranslation::className(), ['id' => 'translation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery|HonorUser[]
     */
    public function getHonorUser()
    {
        return $this->hasMany(HonorUser::className(), ['id' => 'honor_id']);
    }
}
