<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\web\Response;

use app\models\Category;

class CateController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    /**
     * 分类列表
     *
     * @return string
     */
    public function actionIndex()
    {
        $condition = ['is_delete' => NOT_DELETE_0];

        $query = Category::find()->where($condition);

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => PAGESIZE]);

        $data = [];
        if($count) {
            $data = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->asArray()
                ->orderBy('cat_id desc')->all();
        }

        return $this->render('index',[
            'data' => $data,
            'pagination' => $pagination,
        ]);
    }


    /**
     * 添加分类
     *
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        if (Yii::$app->request->getIsPost()) {
            $catName  = trim(Yii::$app->request->post('cateName', ''));
            $cateSort = intval(Yii::$app->request->post('cateSort', 0));
            $inputFile  = trim(Yii::$app->request->post('inputFile', ''));

            $model = new Category();
            $model->cat_name = $catName;
            $model->sort_order = $cateSort;
            $model->cat_img = $inputFile;

            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->save()) {
                return ['code'=>'200', 'msg'=>'添加成功', 'href' => '/cate/index'];
            } else {
                return ['code'=>'500', 'msg'=>'添加失败', 'href' => ''];
            }

        }

        return $this->render('add');
    }


    /**
     * 编辑分类
     * @param int $cat_id
     * @return array|string
     */
    public function actionEdit($cat_id = 0)
    {
        $model = Category::find()->where(['cat_id' => $cat_id])->one();

        $model->cat_img = Yii::$app->params['upload']['host'] . $model->cat_img;

        if (Yii::$app->request->getIsPost()) {
            $catName  = trim(Yii::$app->request->post('cateName', ''));
            $cateSort = intval(Yii::$app->request->post('cateSort', 0));
            $inputFile  = trim(Yii::$app->request->post('inputFile', ''));

            $model->cat_name = $catName;
            $model->sort_order = $cateSort;
            $model->cat_img = $inputFile;

            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->save()) {
                return ['code'=>'200', 'msg'=>'编辑成功', 'href' => '/cate/index'];
            } else {
                return ['code'=>'500', 'msg'=>'编辑失败', 'href' => ''];
            }

        }

        return $this->render('add', [
            'cate' => $model
        ]);
    }


    /**
     * 删除分类
     * @param $cat_id
     * @return Response
     */
    public function actionDel($cat_id)
    {
        $category = Category::find()->where(['cat_id' => $cat_id])->one();

        if (!empty($category)) {
            $category->is_delete = 1;
            if ($category->save()) {
                Yii::$app->session->setFlash('success', '操作成功');
            }else{
                Yii::$app->session->setFlash('error', '操作失败');
            }
        }else{
            Yii::$app->session->setFlash('error', '操作失败');
        }

        return $this->redirect('/cate/index');
    }

}