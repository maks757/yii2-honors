<?php
/**
 * @author Maxim Cherednyk <maks757q@gmail.com, +380639960375>
 */

namespace bl\honors\controllers;

use bl\honors\components\image\ImageUpload;
use bl\honors\entities\Honor;
use bl\honors\entities\HonorTranslation;
use bl\honors\entities\HonorUser;
use bl\multilang\entities\Language;
use common\models\User;
use yii\base\InvalidParamException;
use yii\base\InvalidValueException;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;

class HonorController extends Controller
{
    public function beforeAction($action)
    {
        if (in_array($action->id, ['index'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex($languageId = null, $honorId = null)
    {
        if(!empty($honorId)){
            $honor = Honor::findOne($honorId);
            $honor_translation = (ArrayHelper::index($honor->translations, 'language_id')[$languageId]);
            if(empty($honor_translation))
                $honor_translation = new HonorTranslation();
        } else {
            $honor = new Honor();
            $honor_translation = new HonorTranslation();
        }
        $honor_image = new ImageUpload();

        $languages = Language::find()->all();

        if(\Yii::$app->request->isPost){
            if(!(empty($languageId) && !empty($languages) && !empty($honor_translation->language_id))) {
                if (empty($languageId) && !empty($languages) && empty($honor_translation->language_id)) {
                    $languageId = $languages[0]->id;
                    $honor_translation->language_id = $languageId;
                } elseif (!empty($languageId) && !empty($honor_translation->language_id)) {
                    $honor_translation->language_id = $languageId;
                } else {
                    $honor_translation->language_id = $languageId;
                }
            }
            $post = \Yii::$app->request->post();

            $honor_image->image = UploadedFile::getInstance($honor_image, 'image');

            $imageName = $honor_image->upload();

            $honor->load($post);
            $honor_translation->load($post);

            if(!empty($imageName))
                $honor->image = $imageName;

            if ($honor->validate() && $honor_translation->validate()) {
                $honor->save();
                $honor_translation->honor_id = $honor->id;
                $honor_translation->save();
                return $this->redirect(Url::toRoute(['/honor/honor/index', 'honorId' => $honor->id, 'languageId' => $honor_translation->language_id]));
            } else {
                throw new InvalidValueException();
            }
        }
        return $this->render('createHonorCategory',[
            'languages' => $languages,
            'honor' => $honor,
            'honor_translation' => $honor_translation,
            'honor_image' => $honor_image,
            'currentLanguage' => empty($languageId) ? Language::getDefault()->id : $languageId
        ]);
    }

    public function actionList()
    {
        $query = Honor::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $honors = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('honorList',[
            'honors' => $honors,
            'pages' => $pages,
            'languages' => Language::find()->all()
        ]);
    }

    public function actionHonorDelete($honorId = null){
        if(!empty($honorId)) {
            Honor::findOne(['id' => $honorId])->delete();
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionUser(){
        $userHonor = new HonorUser();
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            $userHonor->load($post);
            if (empty(HonorUser::find()->where(['user_id' => $userHonor->user_id, 'honor_id' => $userHonor->honor_id])->one())) {
                $honor = new HonorUser();
                $honor->user_id = $userHonor->user_id;
                $honor->honor_id = $userHonor->honor_id;
                if($honor->validate())
                    $honor->save();
                else
                    throw new InvalidParamException(HonorUser::class.' '.implode($honor->errors));
            }
        }

        $query = HonorUser::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $all_honor_user = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        ArrayHelper::multisort($all_honor_user, 'user_id');
        return $this->render('userHonor',[
            'userHonor' => $userHonor,
            'honors' => Honor::find()->all(),
            'honor_user' => $all_honor_user,
            'pages' => $pages,
            'user_id' => $userHonor->user_id
        ]);
    }

    public function actionUserDelete($honorUserId = null){
        if(!empty($honorUserId)) {
            HonorUser::findOne(['id' => $honorUserId])->delete();
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionUsersList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $out['results'] =
                User::find()
                    ->select('id, email as text')
                    ->andWhere(['like', 'email', $q])
                    ->limit(20)
                    ->asArray()
                    ->all();
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => User::find()
                ->select('email as text')
                ->where(['id' => $id])
                ->asArray()
                ->one()->text
            ];
        }
        return $out;
    }
}