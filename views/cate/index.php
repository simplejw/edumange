<?php
$this->title = 'My Yii Application';

use yii\widgets\LinkPager;
?>

    <div class="navbar-form row">
        <a href="/cate/add" class="batchbind btn btn-primary pull-right" title="添加分类">添加分类</a>
    </div>

    <table class="table table-striped table-hover">
        <tr>
            <th width="20%">ID</th>

            <th width="30%">分类名称</th>
            <th width="20%">修改操作</th>
            <th width="20%">删除操作</th>
        </tr>
        <?php foreach ($data as $res): ?>
            <tr>
                <td><?= $res['cat_id']; ?></td>

                <td><?= $res['cat_name']; ?></td>
                <td><a href="/cate/edit/<?= $res['cat_id']; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                <td><a href="/cate/del/<?= $res['cat_id']; ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
            </tr>
        <?php endforeach; ?>
    </table>


<?php
echo LinkPager::widget(['pagination' => $pagination,]);
?>