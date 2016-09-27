<?php

namespace bl\honors\entities;

use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "honor_user".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $honor_id
 * @property integer $date_create
 * @property integer $date_update
 */
class HonorUser extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_create',
                'updatedAtAttribute' => 'date_update',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'honor_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'honor_id', 'date_create', 'date_update'], 'integer'],
            [['user_id', 'honor_id'], 'required'],
            [['honor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Honor::className(), 'targetAttribute' => ['honor_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'honor_id' => 'Honor ID',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery|Honor
     */
    public function getHonor()
    {
        return $this->hasOne(Honor::className(), ['id' => 'honor_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
