<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\web\ServerErrorHttpException;

use app\models\Product;
use app\models\Region;

class ApiController extends Controller
{
    /**
     * 上传单个文件到oss
     * @return mixed
     * @throws ServerErrorHttpException
     */
    public function actionUpload()
    {
        $file = UploadedFile::getInstanceByName('file');
        $ext = $file->getExtension();

        if (!in_array($ext, Yii::$app->params['upload']['allow'])) {
            throw new ServerErrorHttpException("file type error！");
        }

        $tmpFileName = time();
        $fileDir = $tmpFileName % 10;
        $uploadDir = '/edumanage/upload/' . $fileDir . '/';
        $filename = mt_rand(10000, 99999) . $tmpFileName;
        $filePath = $uploadDir . $filename . '.' . $ext;

        $res = Yii::$app->oss->putObject($filePath, $file->tempName, $file->type);

        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($res === 200) {
            $result['code'] = 200;
            $result['data']['path'] = $filePath;
            return $result;
        } else {
            throw new ServerErrorHttpException("file save error！");
        }

    }

    /**
     * 根据分类获取课程
     * @param int $cat_id
     * @return array
     */
    public function actionGetProduct($cat_id = 0)
    {
        $product = Product::find()->where(['cat_id' => $cat_id, 'is_delete' => NOT_DELETE_0])->orderBy('product_id desc')->all();

        Yii::$app->response->format = Response::FORMAT_JSON;

        $result = ['code'=>500, 'data'=>[]];
        if (!empty($product)) {
            $result['code'] = 200;
            $result['data'] = $product;
        }

        return $result;
    }


    /**
     * 获取vod的post上传参数
     * @return array (表单域中file必须是最后一个)
     */
    public function actionPostVod()
    {
        $title = trim(Yii::$app->request->getBodyParam('cs_name', ''));       //vod视频名称
        $fileName = trim(Yii::$app->request->getBodyParam('file_name', '')); //视频源文件名 必须带扩展名

        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($title === '' || $fileName === '') {
            $result = ['code' => 500, 'data' => ['title'=>$title, 'fileName' => $fileName ]];
            return $result;
        }

        $res = Yii::$app->vod->postVideoParam($title, $fileName);

        return ['code'=>200, 'data'=>$res];
    }

    public function actionRegions($parentId)
    {
        $key = 'regions_' . $parentId;

        $regions = Yii::$app->cache->get($key);

        if (empty($regions))
        {
            $regions = array();

            foreach (Region::find()->where(['parent_id'=>$parentId])->all() as $row)
            {
                $regions[$row->region_id] = $row->attributes;
            }

            if (!empty($regions)) Yii::$app->cache->set($key, $regions, 600);
        }

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $regions;
    }

}