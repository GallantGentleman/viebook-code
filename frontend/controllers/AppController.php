<?php
/**
 * Created by PhpStorm.
 * User: gallant
 * Date: 3/26/17
 * Time: 9:09 PM
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Review;
use frontend\models\SearchModel;

class AppController extends Controller
{
    public function beforeAction($action)
    {
        return true;
    }

    public function actionIndex()
    {
        $model = new SearchModel();
        $search_results = [];

        if (Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                if ($search_results = $model->search_book()) {
                    
                } else {
                    $search_results = 'No books.';
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'search_results' => $search_results,
        ]);
    }

}
