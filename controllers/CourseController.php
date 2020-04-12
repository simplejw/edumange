<?php

namespace app\controllers;

use app\models\Product;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\web\Response;

use app\models\Course;
use app\models\Category;

class CourseController extends Controller
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
     * 视频列表
     * @return string
     */
    public function actionIndex()
    {
        $condition = ['is_delete' => NOT_DELETE_0];

        $query = Course::find()->where($condition);

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => PAGESIZE]);

        $data = [];
        if($count) {
            $data = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->asArray()
                ->orderBy('course_id desc, product_id desc')->all();
        }

        $category = [];
        $allCate = Category::find()->where(['is_delete' => NOT_DELETE_0])->asArray()->all();
        if (!empty($allCate)) {
            foreach ($allCate as $k => $v) {
                $category[$v['cat_id']] = $v;
            }
        }

        return $this->render('index',[
            'data' => $data,
            'pagination' => $pagination,
            'category' => $category,
        ]);
    }


    /**
     * 新加视频
     * @return string|Response
     */
    public function actionAdd()
    {
        $cateGory = Category::find()->where(['is_delete' => NOT_DELETE_0])->all();

        if (Yii::$app->request->getIsPost()) {
            $cate_id = intval(Yii::$app->request->post('cate_id', 0));
            $product_id = intval(Yii::$app->request->post('product_id', 0));
            $cs_name = trim(Yii::$app->request->post('cs_name', ''));
            $cs_desc = trim(Yii::$app->request->post('cs_desc', 'init'));
            $vod_id = trim(Yii::$app->request->post('vod_id', ''));
            $sort = intval(Yii::$app->request->post('sort', 0));

            $course = new Course();
            $course->cat_id = $cate_id;
            $course->product_id = $product_id;
            $course->cs_name = $cs_name;
            $course->cs_desc = $cs_desc;
            $course->vod_id = $vod_id;
            $course->sort = $sort;

            Yii::$app->response->format = Response::FORMAT_JSON;
            if($course->save()) {
                return ['code'=>'200', 'msg'=>'新增成功', 'href' => '/course/index'];
            } else {
                return ['code'=>'500', 'msg'=>'新增失败', 'href' => '/course/add'];
            }
        }

        return $this->render('add',[
            'act' => 'add',
            'category' => $cateGory,
        ]);
    }


    /**
     * 编辑视频信息
     * @param int $course_id
     * @return array|string|Response
     */
    public function actionEdit($course_id = 0)
    {
        $course = Course::find()->where(['course_id' => $course_id])->one();
        if ($course === null) {
            Yii::$app->session->setFlash('error', '无此视频');
            return $this->redirect('/course/index');
        }

        if (Yii::$app->request->getIsPost()) {
            $cate_id = intval(Yii::$app->request->post('cate_id', 0));
            $product_id = intval(Yii::$app->request->post('product_id', 0));
            $cs_name = trim(Yii::$app->request->post('cs_name', ''));
            $cs_desc = trim(Yii::$app->request->post('cs_desc', 'init'));
            $vod_id = trim(Yii::$app->request->post('vod_id', ''));
            $sort = intval(Yii::$app->request->post('sort', 0));


            $course->cat_id = $cate_id;
            $course->product_id = $product_id;
            $course->cs_name = $cs_name;
            $course->cs_desc = $cs_desc;
            $course->vod_id = $vod_id;
            $course->sort = $sort;

            Yii::$app->response->format = Response::FORMAT_JSON;
            if($course->save()) {
                return ['code'=>'200', 'msg'=>'修改成功', 'href' => '/course/index'];
            } else {
                return ['code'=>'500', 'msg'=>'修改失败', 'href' => '/course/add'];
            }
        }

        $cateGory = Category::find()->where(['is_delete' => NOT_DELETE_0])->asArray()->all();
        $product = Product::find()->where(['product_id' => $course['product_id']])->asArray()->one();

        return $this->render('add',[
            'act' => 'edit',
            'course' => $course,
            'category' => $cateGory,
            'product' => $product,
        ]);
    }


    public function actionDel($course_id = 0)
    {

    }

}