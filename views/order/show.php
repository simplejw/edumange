<div class="modal-body">
    <h4>订单号：<?= $order['order_sn'] ?>    <small>课程信息：<?= $order_goods['cat_name']. '(' .$order_goods['goods_name'] . ')'; ?> </small></h4>
    <div><strong>姓名：</strong><?= $order['realname'] ?> <strong>电话：</strong><?= $order['mobile'] ?> </div>
    <strong>地址：</strong><?= $order['address'] ?>
    <br><strong>政治面貌：</strong><?php if ($order['political_status']==1){echo '团员';}elseif($order['political_status']==2){echo '党员';}else{echo '群众';} ?>
    <br><br><strong>总费用：</strong>￥<?= $order['order_amount'] ?>
    <br><strong>备注：</strong><?= $order['remark'] ?>
</div>
<table class="table table-hover table-striped">
    <thead>
    <tr>
        <th width="20%">身份证正面照</th>
        <th width="20%">身份证反面照</th>
        <th width="20%">学历照</th>
        <th width="20%">2寸白底照片</th>
    </tr>
    </thead>
    <tbody>
    <tr class="goods">
        <td><img src="<?= \Yii::$app->params['upload']['host'] . $image_data['identity_fr'] ?>" class="img-rounded" ></td>
        <td><img src="<?= \Yii::$app->params['upload']['host'] . $image_data['identity_bg'] ?>" class="img-rounded" ></td>
        <td><img src="<?= \Yii::$app->params['upload']['host'] . $image_data['edu_img'] ?>" class="img-rounded" ></td>
        <td><img src="<?= \Yii::$app->params['upload']['host'] . $image_data['signage_img'] ?>" class="img-rounded" ></td>
    </tr>
    </tbody>
</table>