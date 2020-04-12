<?php
$this->title = 'My Yii Application';
?>
<h4>新增课程</h4>
<form class="form-horizontal" id="form">

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>课程分类</label>
        <div class='col-md-4'>
            <select class="form-control" name="cat_id" id="cat_id" <?php if (isset($res)){echo ' disabled="disabled" ';}?> >
                <option value="">-- 选择分类 --</option>
                <?php foreach ($category as $pro): ?>
                    <option value="<?php echo $pro['cat_id']; ?>" <?php if (isset($res['cat_id']) && $res['cat_id'] == $pro['cat_id']){echo ' selected = "selected" ';}?> ><?php echo $pro['cat_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>课程名称</label>
        <div class='col-md-4'>
            <input type="text" name="goods_name" class="form-control" id="goods_name" placeholder="课程名称" value="<?php if(isset($res)){echo $res['goods_name'];} ?>" >
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>课程编号</label>
        <div class='col-md-4'>
            <input type="text" name="goods_sn" class="form-control" id="goods_sn" placeholder="课程编号" value="<?php if(isset($res)){echo $res['goods_sn'];} ?>" >
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>课程排序</label>
        <div class='col-md-4'>
            <input type="number" name="sort_order" class="form-control" id="sort_order" placeholder="课程排序" value="<?php if(isset($res)){echo $res['sort_order'];} ?>" >
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>课程金额</label>
        <div class='col-md-4'>
            <input type="number" name="shop_price" class="form-control" id="goods_price" placeholder="课程金额" value="<?php if(isset($res)){echo $res['goods_price'];} ?>" >
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>课程头图</label>
        <div class='col-md-4'>
            <input type="file" name="goods_img" id="goods_img" value="<?php if (!empty($res)){ echo Yii::$app->params['upload']['host'] . $res['goods_img'];}?>" >
            <p class="help-block">图片尺寸 270px * 180px</p>
            <img src="<?php if (!empty($res)){ echo Yii::$app->params['upload']['host'] . $res['goods_img'];}?>" alt="" class="img-rounded">
            <hr>
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>课程介绍（必填）</label>
        <div class='col-md-6'>
            <!-- 加载编辑器的容器 -->
            <script id="container" name="content" type="text/plain" style="width:600px;height:200px;">
                <?php if(isset($res)){echo $res['goods_desc'];} ?>
            </script>
        </div>
    </div>

    <hr>
    <div class="form-group">
        <label for="" class='col-md-2 control-label'>讲师名称</label>
        <div class='col-md-4'>
            <input type="text" name="tech_name" class="form-control" id="tech_name" placeholder="讲师名称" value="<?php if(isset($res)){echo $res['tech_name'];} ?>" >
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>讲师头像</label>
        <div class='col-md-4'>
            <input type="file" name="tech_icon" id="tech_icon" class="fileInput" value="<?php if (!empty($res)){ echo Yii::$app->params['upload']['host'] . $res['tech_icon'];}?>" >
            <p class="help-block">图片尺寸 120px * 120px</p>
            <img src="<?php if (!empty($res)){ echo Yii::$app->params['upload']['host'] . $res['tech_icon'];}?>" alt="" class="img-rounded">
            <hr>
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>讲师职位</label>
        <div class='col-md-4'>
            <input type="text" name="tech_position" class="form-control" id="tech_position" placeholder="讲师职位" value="<?php if(isset($res)){echo $res['tech_position'];} ?>" >
        </div>
    </div>

    <div class='form-group'>
        <div class='col-md-2 col-md-offset-2'>
            <input class='btn btn-primary btn-submit' value='提交'>
        </div>
    </div>
</form>

<script type="text/javascript">
    <?php $this->beginBlock('order_add') ?>
    var um = UM.getEditor('container');

    $('#goods_img').change(function(){
        uploadPic('#goods_img');
    });

    $('#tech_icon').change(function(){
        uploadPic('#tech_icon');
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
                if (res.code == 200) {
                    const { data: { path } } = res;
                    $(id).attr('path', path);
                    alert('上传成功');
                }
            },
            fail: function (error) {
                alert('上传失败');
            }
        })
    }


    // 获取表单数据
    function getFormData() {
        // 课程分类
        const cat_id = $('#cat_id').val();
        // 课程名称
        const goods_name = $('#goods_name').val();
        //课程排序
        const sort_order = $('#sort_order').val();
        // 课程金额
        const goods_price = $('#goods_price').val();
        // 课程头图
        const goods_img = $('#goods_img').attr("path");
        // 课程介绍
        const goods_desc = UM.getEditor('container').getContent();
        // 讲师名称
        const tech_name = $('#tech_name').val();
        // 讲师头像
        const tech_icon = $('#tech_icon').attr("path");
        // 讲师职位
        const tech_position = $('#tech_position').val();

        return {
            cat_id,
            goods_name,
            sort_order,
            goods_price,
            goods_img,
            goods_desc,
            tech_name,
            tech_icon,
            tech_position,
        }
    }

    $('.btn-submit').click(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        const formData = getFormData();
        console.warn('formData', formData);
        $.ajax({
            headers: {
                'X-CSRF-Token':csrfToken
            },
            url: "<?= '/' . Yii::$app->request->getPathInfo();?>",
            type: 'post',
            dataType: 'json',
            contentType:"application/json;charset=utf-8",
            cache: false,
            data: JSON.stringify(formData),
            success: function (res) {
                console.warn('res', res);
                if (res.code == 200) {
                    alert(res.msg);
                    window.location.href = "/product/index";
                }else{
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
<?php $this->registerJs($this->blocks['order_add'], \yii\web\View::POS_END); ?>
