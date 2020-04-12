<?php
$this->title = 'My Yii Application';

use yii\widgets\LinkPager;
?>

<div class="navbar-form row">
    <a href="/news/add" class="batchbind btn btn-primary pull-right" title="添加新闻">添加新闻</a>
</div>

<table class="table table-striped table-hover">
    <tr>
        <th>新闻编号</th>
        <th width="25%">新闻名称</th>
        <th width="20%">更新时间</th>
        <th width="10%">编辑</th>
        <th width="10%">删除</th>
    </tr>
    <?php foreach ($news as $res): ?>
        <tr>
            <td><?= $res->news_id; ?></td>
            <td><?= $res->title; ?></td>
            <td><?= $res->last_update_time; ?></td>
            <td><a href="/news/detail/<?= $res->news_id; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
            <td><a href="/news/del/<?= $res->news_id; ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
        </tr>
    <?php endforeach; ?>
</table>


<?php echo LinkPager::widget(['pagination' => $pagination,]); ?>
