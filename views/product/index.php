<?php
$this->title = 'My Yii Application';

use yii\widgets\LinkPager;
?>

    <div class="navbar-form row">
        <a href="/product/add" class="batchbind btn btn-primary pull-right" title="添加课程">添加课程</a>
    </div>

    <table class="table table-striped table-hover">
        <tr>
            <th>课程编号</th>
            <th width="20%">课程名称</th>
            <th width="20%">所属类别</th>
            <th width="20%">课程价格</th>
            <th width="10%">修改</th>
            <th width="10%">删除</th>
        </tr>
        <?php foreach ($data as $res): ?>
            <tr>
                <td><?= $res['product_id']; ?></td>
                <td><?= $res['goods_name']; ?></td>
                <td><?= $res['cat_id']; ?></td>
                <td><?= $res['goods_price']; ?></td>
                <td><a href="/product/edit/<?= $res['product_id']; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                <td><a href="/product/del/<?= $res['product_id']; ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
            </tr>
        <?php endforeach; ?>
    </table>


<?php
echo LinkPager::widget(['pagination' => $pagination,]);
?>