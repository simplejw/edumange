<?php
$this->title = 'My Yii Application';

use yii\widgets\LinkPager;
?>

    <h4>添加/修改新闻</h4>

    <form  class="form-horizontal" id="form" >

        <div class="form-group">
            <label for="" class='col-md-2 control-label'>新闻标题</label>
            <div class='col-md-4'>
                <input type="text" name="title" value="<?php if(isset($news)){echo $news->title;}  ?>" class="form-control" id="title" placeholder="新闻标题">
            </div>
        </div>

        <div class="form-group">
            <label for="" class='col-md-2 control-label'>新闻内容</label>
            <div class='col-md-6'>
                <!-- 加载编辑器的容器 -->
                <script id="container" name="content" type="text/plain" style="width:600px;height:200px;">
            <?php if(isset($news)){echo $news->content;} ?>
        </script>
            </div>
        </div>

        <div class='form-group'>
            <div class='col-md-2 col-md-offset-2'>
                <input type="button" class='btn btn-danger btn-submit' value='提交'>
            </div>
        </div>

    </form>

    <script type="text/javascript">
        <?php $this->beginBlock('news_detail') ?>
        var um = UM.getEditor('container');

        // 获取表单数据
        function getFormData() {

// 课程名称
            const title = $('#title').val();
// 新闻内容
            const content = UM.getEditor('container').getContent();

            return {
                title,
                content,
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
                url: "<?= '/' . \Yii::$app->request->getPathInfo();?>",
                type: 'post',
                dataType: 'json',
                contentType:"application/json;charset=utf-8",
                cache: false,
                data: JSON.stringify(formData),
                success: function (res) {
                    console.warn('res', res);
                    if (res.code == 200) {
                        window.location.href = "/news/index";
                    }else{
                        window.location.href = "/news/add";
                    }
                },
                fail: function (error) {
                    alert('操作失败');
                }
            })
        })

        <?php $this->endBlock() ?>
    </script>
<?php $this->registerJs($this->blocks['news_detail'], \yii\web\View::POS_END); ?>