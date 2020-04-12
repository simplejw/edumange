<?php
$this->title = '订单列表';

use yii\widgets\LinkPager;
?>

<div class="navbar navbar-default navbar-static">
    <ul class="nav navbar-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">全部订单 <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="/order/index">全部</a></li>
                <li class="divider"></li>
                <li><a href="<?= \Yii::$app->request->hostInfo .'/'. \Yii::$app->request->getPathInfo();?>?order_status=0">未确认</a></li>
                <li class="divider"></li>
                <li><a href="<?= \Yii::$app->request->hostInfo .'/'. \Yii::$app->request->getPathInfo();?>?pay_status=0">未付款</a></li>
            </ul>
        </li>
    </ul>
    <form class="navbar-form row" role="search" method="get">
        <input type="text" name="keyword" class="form-control" placeholder="订单号/收件人/手机号" value="<?= $keyword; ?>">&#10
        <button type="submit" class="btn btn-default ">查找</button>
    </form>
</div>

<table class="table table-striped table-hover">
    <tr>
        <th>订单编号</th>
        <th>下单时间</th>
        <th width="25%">支付金额</th>
        <th width="20%">学员信息</th>
        <th width="10%">支付状态</th>
        <th width="10%">订单状态</th>
        <th width="5%">付款操作</th>
        <th width="5%">订单操作</th>
        <th width="5%">修改订单</th>
    </tr>
    <?php foreach ($data as $res): ?>
        <tr <?php if ($res['pay_status'] == 2 && $res['order_status'] == 1): ?> class="success" <?php elseif ($res['pay_status'] == 2 || $res['order_status'] == 1): ?> class="warning" <?php endif; ?> >
            <td><a title="订单详情：<?= $res['order_sn'] ?>" data-toggle="modal" href="/order/show/<?= $res['order_sn'] ?>" data-target=".showorder"><?= $res['order_sn'] ?></a></td>
            <td><?= $res['add_time'] ?></td>
            <td>
                总金额：￥<?= $res['order_amount'] ?>
            </td>
            <td>
                名字：<?= $res['realname'] ?> 手机：<?= $res['mobile'] ?>
                <br>地址：<?= $res['address'] ?>
            </td>
            <td>
                <?= \Yii::$app->params['pay_status'][$res['pay_status']] ?>
            </td>
            <td>
                <?= \Yii::$app->params['order_status'][$res['order_status']] ?>
            </td>
            <td>
                <?php if ($res['pay_status'] < 2): ?>
                    <a href="/order/payConfirm/<?= $res['order_sn'] ?>">确认付款</a>
                <?php endif; ?>
            </td>
            <td>
                <?php if ($res['order_status'] == 0): ?>
                    <a href="/order/process/<?= $res['order_sn'] ?>">确认订单</a>
                <?php endif; ?>
            </td>
            <td>
                <?php if ($res['order_status'] == 0): ?>
                    <a href="/order/edit/<?= $res['order_sn'] ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                <?php endif; ?>

            </td>
        </tr>
    <?php endforeach; ?>
</table>

<div class="modal fade showorder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php echo LinkPager::widget(['pagination' => $pagination,]); ?>

<script type="text/javascript">
    <?php $this->beginBlock('order_index') ?>
    $('body').on('hidden.bs.modal', '.showorder', function () {
        $(this).removeData('bs.modal');
    });
    <?php $this->endBlock() ?>
</script>
<?php $this->registerJs($this->blocks['order_index'], \yii\web\View::POS_END); ?>
