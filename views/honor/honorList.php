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
/** @var \bl\honors\entities\Honor $honor*/
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            Honor translations
            <a href="<?= Url::toRoute(['/honor']) ?>" class="pull-right btn btn-xs btn-warning">Add new honor</a>
            <div class="clearfix"></div>
        </h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Short description</th>
                    <th>Long description</th>
                    <th>Translations</th>
                    <th>Image</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($honors as $honor): ?>
                    <tr>
                        <td><?= $honor->translation->name ?></td>
                        <td><?= $honor->translation->short_description ?></td>
                        <td><?= $honor->translation->long_description ?></td>
                        <td>
                            <?php $translations = ArrayHelper::index($honor->translations, 'language.lang_id'); ?>
                            <?php foreach ($languages as $language): ?>
                                <a href="<?= Url::toRoute([
                                    '/honor/honor/index',
                                    'honorId' => $honor->id,
                                    'languageId' => $language->id
                                ]) ?>"
                                   class="btn btn-xs btn-<?= $translations[$language->lang_id] ? 'primary' : 'danger' ?>">
                                    <?= Yii::t('common', $language->name) ?>
                                </a>
                            <?php endforeach ?>
                        </td>
                        <td><?= \yii\helpers\Html::img(Yii::$app->urlManagerFrontend->createAbsoluteUrl($honor->getImage($honor->image))) ?></td>
                        <td>
                            <a class="btn btn-xs btn-primary" href="<?= Url::toRoute(['/honor', 'honorId' => $honor->id])?>">Edit</a>
                            <a class="btn btn-xs btn-success" href="<?= Url::toRoute(['/honor/honor/honor-delete', 'honorId' => $honor->id])?>">Delete</a>
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

