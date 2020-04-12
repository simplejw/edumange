<?php

namespace app\controllers;


use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\web\Response;

use app\models\News;

class NewsController extends Controller
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
     * 新闻列表
     * @return string
     */
    public function actionIndex()
    {
        $condition = ' is_delete = :is_delete ';
        $params[':is_delete'] = 0;

        $query = News::find()->where($condition, $params);

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => PAGESIZE]);

        $news = [];
        if ($count > 0) {
            $news = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->orderBy('news_id desc')->all();
        }

        return $this->render('index',[
            'news' => $news,
            'pagination' => $pagination,
        ]);
    }

    /**
     * 添加新闻
     * @return array|string
     */
    public function actionAdd()
    {
        if (Yii::$app->request->getIsPost()) {
            $title = trim(Yii::$app->request->post('title', ''));
            $thumb = trim(Yii::$app->request->post('thumb', ''));
            $content = trim(Yii::$app->request->post('content', 'init'));

            $news = new News();
            $news->title = $title;
            $news->thumb = $thumb;
            $news->content = $content;

            if($news->save()){
                \Yii::$app->response->format = Response::FORMAT_JSON;
                $result = ['code'=>'200', 'msg'=>'', 'data'=>['redirect' => '/news/index']];
                return $result;exit;
            }else{
                \Yii::$app->response->format = Response::FORMAT_JSON;
                $result = ['code'=>'500', 'msg'=>'', 'data'=>['redirect' => '/news/add']];
                return $result;exit;
            }
        }

        return $this->render('detail');
    }

    /**
     * 修改新闻
     * @param $news_id
     * @return array|string
     */
    public function actionDetail($news_id)
    {
        $condition = ' news_id = :news_id AND is_delete = :is_delete ';
        $params[':is_delete'] = 0;
        $params[':news_id'] = $news_id;

        $news = News::find()->where($condition, $params)->one();

        if (Yii::$app->request->getIsPost()) {
            $title = trim(Yii::$app->request->post('title', ''));
            $thumb = trim(Yii::$app->request->post('thumb', ''));
            $content = trim(Yii::$app->request->post('content', 'init'));

            $news->title = $title;
            $news->thumb = $thumb;
            $news->content = $content;

            if($news->save()){
                \Yii::$app->response->format = Response::FORMAT_JSON;
                $result = ['code'=>'200', 'msg'=>'', 'data'=>['redirect' => '/news/index']];
                return $result;exit;
            }else{
                \Yii::$app->response->format = Response::FORMAT_JSON;
                $result = ['code'=>'500', 'msg'=>'', 'data'=>['redirect' => '/news/detail/' . $news_id]];
                return $result;exit;
            }
        }

        return $this->render('detail',[
            'news' => $news,
        ]);
    }

    /**
     * 删除新闻
     * @param $news_id
     * @return Response
     */
    public function actionDel($news_id)
    {
        $news = News::find()
            ->where(['news_id' => $news_id])->one();

        if (!empty($news)) {
            $news->is_delete = 1;
            if ($news->save()) {
                Yii::$app->session->setFlash('success', '操作成功');
            }else{
                Yii::$app->session->setFlash('error', '操作失败');
            }
        }else{
            Yii::$app->session->setFlash('error', '操作失败');
        }

        return $this->redirect('/news/index');
    }

}