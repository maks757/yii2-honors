<?php
/**
 * @author Maxim Cherednyk <maks757q@gmail.com, +380639960375>
 */
use common\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\LinkPager;

?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            Create new honor
        </h3>
    </div>
    <div class="panel-body">
        <?php $email = User::findOne($user_id)->email; ?>
        <?php $form = \yii\widgets\ActiveForm::begin() ?>

            <?=
                $form->field($userHonor, 'user_id')->widget(Select2::classname(), [
                    'initValueText' => !empty($email) ? $email : 'Empty',
                    'options' => ['placeholder' => 'Search for a user...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => Url::toRoute(['/honor/honor/users-list']),
                            'dataType' => 'json',
                        ]
                    ],
                ])->label('User')
            ?>

            <?= $form->field($userHonor, 'honor_id')->dropDownList(ArrayHelper::map($honors, 'id', 'translation.name'))->label('Honor')?>

        <?= \yii\helpers\Html::submitButton('Save', ['class' => 'btn btn-warning']) ?>

        <?php \yii\widgets\ActiveForm::end() ?>

        <hr>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Honor</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($honor_user as $user): ?>
                    <tr>
                        <td><?= $user->user->id ?></td>
                        <td><?= $user->user->username ?></td>
                        <td><?= $user->user->email ?></td>
                        <td><?= $user->honor->translation->name ?></td>
                        <td>
                            <a class="btn btn-xs btn-success" href="<?= Url::toRoute(['/honor/honor/user-delete', 'honorUserId' => $user->id])?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-center">
            <?= LinkPager::widget(['pagination' => $pages,])?>
        </div>
    </div>
</div>

