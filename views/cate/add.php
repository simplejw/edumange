<?php
$this->title = 'My Yii Application';
?>

<h4>添加分类</h4>

<form action="" method="post" class="form-horizontal" id="form" enctype="multipart/form-data">

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>分类名称</label>
        <div class='col-md-4'>
            <input type="text" name="cateName" value="<?php if (!empty($cate->cat_name)) { echo $cate->cat_name;}  ?>" class="form-control" id="cateName" placeholder="分类名称">
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>分类排序</label>
        <div class='col-md-4'>
            <input type="number" class="form-control" name="cateSort" value="<?php if (!empty($cate->sort_order)) { echo $cate->sort_order;}  ?>" rows="3" placeholder="数字倒序" id="cateSort">
        </div>
    </div>

    <div class="form-group">
        <label for="exampleInputFile" class='col-md-2 control-label'>分类头图(296px * 296px)</label>
        <div class='col-md-4'>
            <input type="file" id="inputFile" name="file">

            <img src="<?php if (!empty($cate->cat_img)) { echo $cate->cat_img;}  ?>" alt="分类头图" class="img-rounded">
        </div>
    </div>


    <div class='form-group'>
        <div class='col-md-2 col-md-offset-2'>
            <button class='btn btn-primary btn-submit' type="button">提交</button>
        </div>
    </div>

</form>

<script type="text/javascript">
    <?php $this->beginBlock('cate_add') ?>

    $('#inputFile').change(function(){
        uploadPic(this);
    });

    function uploadPic(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var formData = new FormData();
        formData.append('file', $(id).prop("files")[0]);
        $.ajax({
            headers: {
                'X-CSRF-Token':csrfToken
            },
            url: '/api/upload',
            type: 'post',
            dataType: 'json',
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                console.log(res);
                if (res.code == 200) {
                    const { data: { path } } = res;
                    $(id).attr('path', path);
                    $(id).next().attr('src', "<?= Yii::$app->params['upload']['host']; ?>" + path);
                }
            },
            fail: function (error) {
                alert('上传失败');
            }
        })
    }


    // 获取表单数据
    function getFormData() {
        // 分类名称
        const cateName = $('#cateName').val();
        // 分类排序
        const cateSort = $('#cateSort').val();
        // 分类头图
        const inputFile = $('#inputFile').attr("path");

        return {
            cateName,
            cateSort,
            inputFile,
        }
    }

    // 提交表单
    $('.btn-submit').click(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        const formData = getFormData();
        console.log(formData);
        $.ajax({
            headers: {
                'X-CSRF-Token':csrfToken
            },
            url: "<?= '/' . Yii::$app->request->getPathInfo();?>",
            type: 'post',
            dataType: 'json',
            contentType: "application/json",
            cache: false,
            data: JSON.stringify(formData),
            success: function (res) {
                if (res.code == 200) {
                    alert(res.msg);
                    window.location.href = res.href;
                } else {
                    alert(res.msg);
                }
            },
            fail: function (error) {
                alert('操作失败');
            }
        })
    })

    <?php $this->endBlock() ?>
</script>
<?php $this->registerJs($this->blocks['cate_add'], \yii\web\View::POS_END); ?>