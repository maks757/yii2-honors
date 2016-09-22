<?php
/**
 * @author Maxim Cherednyk <maks757q@gmail.com, +380639960375>
 */

namespace bl\honors\behaviors;


use bl\honors\entities\HonorUser;
use frontend\modules\auth\models\User;
use yii\base\Behavior;
use yii\base\InvalidParamException;
use yii\base\UserException;
use yii\web\IdentityInterface;

class Honor extends Behavior
{
    public function addUserHonor($user, $honor_id)
    {
        if($user instanceof IdentityInterface) {
            if (empty(HonorUser::findOne(['user_id' => $user->getId(), 'honor_id' => $honor_id]))) {
                $honor = new HonorUser();
                $honor->user_id = $user->getId();
                $honor->honor_id = $honor_id;
                if($honor->validate())
                    $honor->save();
                else
                    throw new InvalidParamException(HonorUser::class.' '.implode($honor->errors));
            }
        } else {
            throw new UserException('object not implements '.IdentityInterface::class);
        }
    }

    public function deleteUserHonor($user, $honor_id)
    {
        if($user instanceof IdentityInterface) {
            HonorUser::findOne(['user_id' => $user->getId(), 'honor_id' => $honor_id])->delete();
        }
    }

    public function updateUserHonor($user, $old_honor_id, $new_honor_id)
    {
        if($user instanceof IdentityInterface) {
            $honor = HonorUser::findOne(['user_id' => $user->getId(), 'honor_id' => $old_honor_id]);
            $honor->honor_id = $new_honor_id;
            $honor->save();
        }
    }
}