<?php

namespace bl\honors\entities;

use Yii;

/**
 * This is the model class for table "honor_translation".
 *
 * @property integer $id
 * @property string $name
 * @property string $long_description
 * @property string $short_description
 */
class HonorTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'honor_translation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'short_description'], 'string', 'max' => 100],
            [['long_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'long_description' => 'Long Description',
            'short_description' => 'Short Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery|Honor
     */
    public function getHonor()
    {
        return $this->hasOne(Honor::className(), ['translation_id' => 'id']);
    }
}
