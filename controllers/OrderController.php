<?php

namespace app\controllers;


use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\web\Response;

use app\models\OrderInfo;
use app\models\IdentityImage;
use app\models\Region;
use app\models\OrderGoods;
use app\models\Product;
use app\components\Service;


class OrderController extends Controller
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
     * @return string
     */
    public function actionIndex()
    {
        $condition = ' 1 = 1 ';
        $params = [];

        $keyword = trim(Yii::$app->request->get('keyword', ''));
        $order_status = intval(Yii::$app->request->get('order_status', 9));
        $pay_status = intval(Yii::$app->request->get('pay_status', 3));

        if ($keyword != '') {
            $condition .= " AND ( order_sn = :order_sn OR mobile = :mobile OR realname LIKE :realname ) ";
            $params[':order_sn']	= $keyword;
            $params[':mobile']	= $keyword;
            $params[':realname'] = "%" . $keyword . "%";
        }

        if ($order_status != 9) {
            $condition .= ' AND order_status = :order_status ';
            $params[':order_status'] = $order_status;
        }

        if ($pay_status != 3) {
            $condition .= ' AND pay_status = :pay_status ';
            $params[':pay_status'] = $pay_status;
        }

        $query = OrderInfo::find()->where($condition, $params);

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => PAGESIZE]);

        $data = [];
        if($count) {
            $data = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->asArray()
                ->orderBy('order_id desc')->all();
        }

        return $this->render('index',[
            'data' => $data,
            'keyword' => $keyword,
            'pagination' => $pagination,
        ]);
    }


    /**
     * 订单操作
     */
    public function actionProcess($order_sn)
    {
        $order = OrderInfo::find()
            ->where(['order_sn' => $order_sn])->one();

        if (!empty($order))
        {
            if ($order->order_status == 0) {
                $order->order_status = 1;
            }

            if ($order->save()) {
                Yii::$app->session->setFlash('success', '操作成功');
                return $this->redirect('/order/index');
            }else{
                Yii::$app->session->setFlash('error', '操作失败');
                return $this->redirect('/order/add');
            }
        }
        else
        {
            Yii::$app->session->setFlash('error', '订单不存在');
            return $this->redirect('/order/add');
        }
    }

    /**
     * 支付确认操作
     */
    public function actionPayConfirm($order_sn)
    {
        $order = OrderInfo::find()
            ->where(['order_sn' => $order_sn])->one();

        if (!empty($order))
        {
            if ($order->pay_status != 2) {
                $order->pay_status = 2;
            }

            if ($order->save()) {
                Yii::$app->session->setFlash('success', '操作成功');
                return $this->redirect('/order/index');
            }else{
                Yii::$app->session->setFlash('error', '操作失败');
                return $this->redirect('/order/add');
            }
        }
        else
        {
            Yii::$app->session->setFlash('error', '订单不存在');
            return $this->redirect('/order/add');
        }
    }

    /**
     * 订单详情
     */
    public function actionShow($order_sn)
    {
        $order = OrderInfo::find()
            ->where(['order_sn' => $order_sn])
            ->asArray()->one();

        if (!empty($order)) {
            $image_data = IdentityImage::find()
                ->where(['order_id' => $order['order_id']])
                ->asArray()->one();

            $sql = "SELECT * FROM {{%order_goods}} WHERE order_id = :order_id ";
            $order_goods = Yii::$app->db->createCommand($sql)->bindValues([':order_id' => $order['order_id']])->queryOne();

            $all_cate = Service::category();
            $order_goods['cat_name'] = isset($all_cate[$order_goods['cat_id']]) ? $all_cate[$order_goods['cat_id']]['cat_name'] : '';
        }

        return $this->renderPartial('show', [
            'order' => $order,
            'order_goods' => $order_goods ? $order_goods : [],
            'image_data' => $image_data ? $image_data : [],
        ]);
    }

    /**
     * 添加报名
     */
    public function actionAdd()
    {
        if (Yii::$app->request->getIsPost())
        {
            $result = ['code'=>'400', 'msg'=>'', 'data'=>[]];

            $cate_id = intval(Yii::$app->request->getBodyParam('cate_id', 0));
            $product_id = intval(Yii::$app->request->getBodyParam('product_id', 0));
            $goods_price = intval(Yii::$app->request->getBodyParam('goods_price', 0));

            $realname = trim(Yii::$app->request->getBodyParam('realname', ''));
            $province = intval(Yii::$app->request->getBodyParam('province', 0));
            $city = intval(Yii::$app->request->getBodyParam('city', 0));
            $district = intval(Yii::$app->request->getBodyParam('district', 0));
            // $street = Yii::$app->request->post('street', 0);
            $address = trim(Yii::$app->request->getBodyParam('address', ''));

            $mobile = trim(Yii::$app->request->getBodyParam('mobile', ''));
            $political_status = Yii::$app->request->getBodyParam('political_status', 0);
            $email = trim(Yii::$app->request->getBodyParam('email', ''));
            $remark = trim(Yii::$app->request->getBodyParam('remark', ''));

            $identity_fr = trim(Yii::$app->request->getBodyParam('identity_fr', ''));
            $identity_bg = trim(Yii::$app->request->getBodyParam('identity_bg', ''));
            $edu_img = trim(Yii::$app->request->getBodyParam('edu_img', ''));
            $signage_img = trim(Yii::$app->request->getBodyParam('signage_img', ''));


            $order_info = new OrderInfo();
            $order_info->order_sn = Service::createOrderNum();
            $order_info->realname = $realname;
            $order_info->mobile = $mobile;
            $order_info->political_status = $political_status;
            $order_info->address = $address;

            $order_info->order_amount = $goods_price;
            $order_info->remark = $remark;
            $order_info->add_time = date('Y-m-d');

            if ($order_info->save()) {
                $order_goods = new OrderGoods();
                $order_goods->order_id = $order_info->getPrimaryKey();
                $order_goods->product_id = $product_id;

                $goods = Product::find()->where(['product_id' => $product_id])->one();
                $order_goods->goods_name = empty($goods) ? '' : $goods->goods_name;
                $order_goods->goods_img = empty($goods) ? '' : $goods->goods_img;

                $order_goods->save();

                $iden_img = new IdentityImage();
                $iden_img->order_id = $order_info->getPrimaryKey();
                $iden_img->identity_fr = $identity_fr;
                $iden_img->identity_bg = $identity_bg;
                $iden_img->edu_img = $edu_img;
                $iden_img->signage_img = $signage_img;
                $iden_img->save();

                Yii::$app->session->setFlash('success', '添加成功');
                $result = ['code'=>'200', 'msg'=>'', 'data'=>['redirect' => '/order/index']];
            }else{

                Yii::$app->session->setFlash('error', '添加失败');
                $result = ['code'=>'200', 'msg'=>'', 'data'=>['redirect' => '/order/add']];
            }

            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;exit;
        }

        return $this->render('add', [
            'category' => Service::category(),
            'province' => Region::find()->where(['parent_id' => 1])->all()
        ]);
    }

    /**
     * 修改报名
     */
    public function actionEdit($order_sn)
    {
        $order = OrderInfo::find()
            ->where(['order_sn' => $order_sn])->one();

        if (!empty($order)) {

            $params = [':order_id' => $order->order_id];
            $sql = "SELECT og.*, g.cat_id, g.goods_name FROM {{%order_goods}} AS og LEFT JOIN {{%goods}} AS g ON og.goods_id = g.goods_id WHERE og.order_id = :order_id ";
            $order_goods = Yii::$app->db->createCommand($sql)->bindValues($params)->queryOne();

            $iden_img = IdentityImage::find()
                ->where(['order_id' => $order->order_id])->one();
        }else{
            Yii::$app->session->setFlash('error', '订单不存在');
            return $this->redirect('/order/index');
        }

        if (Yii::$app->request->isPost)
        {
            $result = ['code'=>'400', 'msg'=>'', 'data'=>[]];

            $cate_id = intval(Yii::$app->request->getBodyParam('cate_id', 0));
            $goods_id = intval(Yii::$app->request->getBodyParam('goods_id', 0));
            $goods_price = intval(Yii::$app->request->getBodyParam('goods_price', 0));

            $realname = trim(Yii::$app->request->getBodyParam('realname', ''));
            $province = intval(Yii::$app->request->getBodyParam('province', 0));
            $city = intval(Yii::$app->request->getBodyParam('city', 0));
            $district = intval(Yii::$app->request->getBodyParam('district', 0));
            // $street = Yii::$app->request->post('street', 0);
            $address = trim(Yii::$app->request->getBodyParam('address', ''));
            $tel = trim(Yii::$app->request->getBodyParam('tel', ''));
            $mobile = trim(Yii::$app->request->getBodyParam('mobile', ''));
            $political_status = Yii::$app->request->getBodyParam('political_status', 0);
            $email = trim(Yii::$app->request->getBodyParam('email', ''));
            $remark = trim(Yii::$app->request->getBodyParam('remark', ''));

            $identity_fr = trim(Yii::$app->request->getBodyParam('identity_fr', ''));
            $identity_bg = trim(Yii::$app->request->getBodyParam('identity_bg', ''));
            $edu_img = trim(Yii::$app->request->getBodyParam('edu_img', ''));
            $signage_img = trim(Yii::$app->request->getBodyParam('signage_img', ''));

            $now = time();

            $order->realname = $realname;
            $order->mobile = $mobile;
            $order->political_status = $political_status;

            $order->province = $province;
            $order->city = $city;
            $order->district = $district;
            $order->address = $address;

            $order->order_amount = $goods_price;
            $order->remark = $remark;

            if ($order->save()) {
                $iden_img->identity_fr = $identity_fr == '' ? $iden_img->identity_fr : $identity_fr;
                $iden_img->identity_bg = $identity_bg == '' ? $iden_img->identity_bg : $identity_bg;
                $iden_img->edu_img = $edu_img == '' ? $iden_img->edu_img : $edu_img;
                $iden_img->signage_img = $signage_img == '' ? $iden_img->signage_img : $signage_img;
                $iden_img->save();

                Yii::$app->session->setFlash('success', '修改成功');
                $result = ['code'=>'200', 'msg'=>'', 'data'=>['redirect' => '/order/index']];
            }else{

                Yii::$app->session->setFlash('error', '修改失败');
                $result = ['code'=>'200', 'msg'=>'', 'data'=>['redirect' => '/order/edit/' . $order_sn ]];
            }

            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;exit;
        }

        return $this->render('add', [
            'order' => $order,
            'order_goods' => $order_goods,
            'iden_img' => $iden_img,
            'category' => Service::category(),
            'province' => Region::find()->where(['parent_id' => 1])->all(),
            'city' => Region::find()->where(['parent_id' => $order->province])->all(),
            'district' => Region::find()->where(['parent_id' => $order->city])->all(),
        ]);
    }

}