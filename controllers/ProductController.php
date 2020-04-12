<?php

namespace app\controllers;


use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\web\Response;

use app\models\Category;
use app\models\Product;

class ProductController extends Controller
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
     * 课程列表
     * @return string
     */
    public function actionIndex()
    {
        $condition = ['is_delete' => NOT_DELETE_0];

        $query = Product::find()->where($condition);

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => PAGESIZE]);

        $data = [];
        if($count) {
            $data = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->asArray()
                ->orderBy('product_id desc, cat_id desc')->all();
        }

        return $this->render('index',[
            'data' => $data,
            'pagination' => $pagination,
        ]);
    }


    /**
     * 添加课程
     * @return array|string
     */
    public function actionAdd()
    {
        $cateGory = Category::find()->where(['is_delete' => NOT_DELETE_0])->all();

        if (Yii::$app->request->getIsPost()) {
            $goods_name = trim(Yii::$app->request->post('goods_name', ''));
            $goods_sn = trim(Yii::$app->request->post('goods_sn', ''));
            $cat_id = intval(Yii::$app->request->post('cat_id', 0));
            $sort_order = intval(Yii::$app->request->post('sort_order', 0));

            $goods_price = Yii::$app->request->post('goods_price', 0);
            $goods_img = trim(Yii::$app->request->post('goods_img', ''));
            $goods_desc = trim(Yii::$app->request->post('goods_desc', 'init'));

            $tech_name = trim(Yii::$app->request->post('tech_name', ''));
            $tech_icon = trim(Yii::$app->request->post('tech_icon', ''));
            $tech_position = trim(Yii::$app->request->post('tech_position', ''));

            $product = new Product();
            $product->goods_name = $goods_name;
            $product->goods_sn = $goods_sn === '' ? time() . mt_rand(100, 999) : $goods_sn;
            $product->cat_id = $cat_id;
            $product->sort_order = $sort_order;

            $product->goods_price = $goods_price;
            $product->goods_img = $goods_img;
            $product->goods_desc = $goods_desc;

            $product->tech_name = $tech_name;
            $product->tech_icon = $tech_icon;
            $product->tech_position = $tech_position;

            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($product->save()) {
                $result = ['code'=>'200', 'msg'=>'新增成功', 'href' => '/product/index'];
                return $result;
            } else {
                $result = ['code'=>'500', 'msg'=>'新增失败', 'href' => '/product/add'];
                return $result;
            }
        }

        return $this->render('add',[
            'category' => $cateGory,
        ]);
    }


    /**
     * 编辑课程
     * @param int $product_id
     * @return array|string
     */
    public function actionEdit($product_id = 0)
    {
        $product = Product::find()->where(['product_id' => $product_id])->one();
        $cateGory = Category::find()->where(['is_delete' => NOT_DELETE_0])->all();

        if (Yii::$app->request->getIsPost()) {
            $goods_name = trim(Yii::$app->request->post('goods_name', ''));
            $cat_id = intval(Yii::$app->request->post('cat_id', 0));
            $sort_order = intval(Yii::$app->request->post('sort_order', 0));

            $goods_price = Yii::$app->request->post('goods_price', 0);
            $goods_img = trim(Yii::$app->request->post('goods_img', ''));
            $goods_desc = trim(Yii::$app->request->post('goods_desc', 'init'));

            $tech_name = trim(Yii::$app->request->post('tech_name', ''));
            $tech_icon = trim(Yii::$app->request->post('tech_icon', ''));
            $tech_position = trim(Yii::$app->request->post('tech_position', ''));

            $product->goods_name = $goods_name;
            $product->cat_id = $cat_id;
            $product->sort_order = $sort_order;

            $product->goods_price = $goods_price;
            $product->goods_img = $goods_img;
            $product->goods_desc = $goods_desc;

            $product->tech_name = $tech_name;
            $product->tech_icon = $tech_icon;
            $product->tech_position = $tech_position;

            Yii::$app->response->format = Response::FORMAT_JSON;
            if($product->save()) {
                return ['code'=>'200', 'msg'=>'编辑成功', 'href' => '/product/index'];
            } else {
                return ['code'=>'500', 'msg'=>'编辑失败', 'href' => ''];
            }
        }

        return $this->render('add',[
            'category' => $cateGory,
            'res' =>$product,
        ]);
    }


    /**
     * 删除课程
     * @param int $product_id
     * @return Response
     */
    public function actionDel($product_id = 0)
    {
        $product = Product::find()->where(['product_id' => $product_id])->one();

        if (!empty($product)) {
            $product->is_delete = DELETE_0;
            if ($product->save()) {
                Yii::$app->session->setFlash('success', '操作成功');
            } else {
                Yii::$app->session->setFlash('error', '操作失败,系统错误');
            }
        }else{
            Yii::$app->session->setFlash('error', '操作失败');
        }

        return $this->redirect('/product/index');
    }

}