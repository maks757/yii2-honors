<?php
/**
 * @author Maxim Cherednyk <maks757q@gmail.com, +380639960375>
 */

/** @var HonorTranslation $honor_translation */

use bl\honors\entities\HonorTranslation;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            Create new honor
        </h3>
    </div>
    <div class="panel-body">
        <?php $form = \yii\widgets\ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

            <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-warning btn-xs dropdown-toggle">
                    <?php $nameLanguage = !empty($languages) ?
                        ArrayHelper::getValue(
                            ArrayHelper::map($languages, 'id', 'name'),
                            (!empty($currentLanguage) ? $currentLanguage : $honor_translation->language_id)) :
                            'no language'
                    ?>
                    <?= Yii::t('common', $nameLanguage) ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <?php foreach($languages as $language): ?>
                        <li>
                            <a href="<?= Url::to([
                                'languageId' => $language->id,
                                'honorId' => $honor->id
                            ]) ?>">
                                <?= Yii::t('common', $language->name) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php if(!empty($honor->id)): ?>
                <a href="<?= Url::toRoute(['/honor']) ?>" class="btn btn-xs btn-warning">Add new honor</a>
            <?php endif; ?>

            <a href="<?= Url::toRoute(['/honor/honor/user']) ?>" class="btn btn-xs btn-warning">User honors</a>

            <?= $form->field($honor_translation, 'name')
                ->textInput() ?>

            <?= $form->field($honor_translation, 'short_description')
                ->widget(TinyMce::className(), [
                    'options' => ['rows' => 6],
                    'clientOptions' => [
                        'plugins' => [
                            "link preview",
                        ],
                        'toolbar' => "undo redo | alignleft aligncenter alignright alignjustify | link"
                    ]
                ]) ?>

            <?= $form->field($honor_translation, 'long_description')
                ->widget(TinyMce::className(), [
                    'options' => ['rows' => 10],
                    'clientOptions' => [
                        'plugins' => [
                            "link preview",
                        ],
                        'toolbar' => "undo redo | alignleft aligncenter alignright alignjustify | link"
                    ]
                ]) ?>

            <?php $honorImage = $honor->getImage($honor->image); ?>
            <?php if(!empty($honorImage)): ?>
                <?= \yii\helpers\Html::img($honorImage)?>
            <?php endif; ?>

            <?= $form->field($honor_image, 'image')
                ->fileInput() ?>

            <?= \yii\helpers\Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>

        <?php \yii\widgets\ActiveForm::end() ?>
    </div>
</div>
