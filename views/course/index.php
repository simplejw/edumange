<?php
$this->title = 'My Yii Application';

use yii\widgets\LinkPager;
?>

<div class="navbar-form row">
    <a href="/course/add" class="batchbind btn btn-primary pull-right" title="添加视频">添加视频</a>
</div>

<table class="table table-striped table-hover">
    <tr>
        <th>编号</th>
        <th>所属类别</th>
        <th width="30%">课程名称</th>

        <th width="20%">点播次数</th>
        <th width="5%">修改</th>
        <th width="5%">删除</th>
    </tr>
    <?php foreach ($data as $res): ?>
        <tr>
            <td><?= $res['course_id']; ?></td>
            <td><?= isset($category[$res['cat_id']]) ? $category[$res['cat_id']]['cat_name'] : ''; ?></td>
            <td><?= $res['cs_name']; ?></td>

            <td><?= $res['cs_count']; ?></td>
            <td><a href="/course/edit/<?= $res['course_id']; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
            <td><a href="/course/del/<?= $res['course_id']; ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
        </tr>
    <?php endforeach; ?>
</table>


<?php echo LinkPager::widget(['pagination' => $pagination,]); ?>
