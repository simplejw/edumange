<?php
$this->title = 'My Yii Application';
?>

<h4><?php if ($act === 'edit') {echo '编辑';} else {echo '添加';}?>视频</h4>

<form action="" method="post" class="form-horizontal" id="form" enctype="multipart/form-data">

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>视频课程分类</label>
        <div class='col-md-4'>
            <select class="form-control" name="cate_id" id="cate_id" >
                <option value="">-- 选择分类 --</option>
                <?php foreach ($category as $res): ?>
                    <option value="<?= $res['cat_id'];?>" <?php if (isset($course->cat_id) && $res['cat_id'] == $course->cat_id){echo ' selected = "selected" ';}?> ><?= $res['cat_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>视频课程名称</label>
        <div class='col-md-4'>
            <select class="form-control" name="product_id" id="product_id" >
                <option value="">-- 选择课程 --</option>
                <?php if (!empty($product)): ?>
                    <option value="" selected = "selected" > <?= $product['goods_name']; ?>  </option>
                <?php endif; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>视频名称</label>
        <div class='col-md-4'>
            <input type="text" name="cs_name" value="<?php if (isset($course->cs_name)) echo $course->cs_name;  ?>" class="form-control" id="cs_name" placeholder="视频名称">
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>视频简介</label>
        <div class='col-md-4'>
            <textarea class="form-control" name="cs_desc" rows="5" id="cs_desc" placeholder="视频简介" ><?php if(!empty($course->cs_desc)){echo $course->cs_desc;}else { echo 'init'; } ?></textarea>
        </div>
    </div>



    <br>
    <div class="form-group">
        <label for="" class='col-md-2 control-label'>视频排序(正序)</label>
        <div class='col-md-4'>
            <input type="number" name="sort" value="<?php if(!empty($course->sort)){echo $course->sort;}  ?>" class="form-control" id="sort" placeholder="课程排序">
        </div>
    </div>


    <input type="hidden" name="vod_id" value="<?php if(!empty($course->vod_id)){echo $course->vod_id;}  ?>" class="form-control" id="vod_id" placeholder="课程视频vodId">

    <br>
    <div class="form-group">
        <label for="" class='col-md-2 control-label' >视频文件</label>
        <div class='col-md-4'>
            <input type="file" name="file" id="exampleInputFile">
            <p class="help-block">只能单个视频，500M 内.</p>
        </div>
        <div class="btn btn-info" id="saveVideo">上传视频</div>
<!--        <div class='col-md-2'>-->
<!--            <input  class='btn btn-primary btn-submit' value='上传视频'>-->
<!--        </div>-->
    </div>

    <br>

    <div class='form-group'>
        <div class='col-md-2 col-md-offset-2'>
            <div class='btn btn-lg btn-primary' id="saveForm" >保存</div>
        </div>
    </div>

</form>

<script type="text/javascript">
    <?php $this->beginBlock('video_add') ?>

    $(document).ready(function () {
        // 分类课程联动
        $("#cate_id").on('change', () => {
            const parentId = $("#cate_id").val()
            const elDistrict = $("#product_id")
            $.ajax({
                url: '/api/getProduct/' + parentId,
                type: 'get',
                dataType: 'json',
                success: (data) => {
                    let content = ''
                    content += '<option value=0>-- 选择课程 --</option>'
                    if (data.code == 200) {
                        const dataValues = Object.values(data.data)
                        dataValues.forEach((item) => {
                            content += '<option value='+ item.product_id +'>' + item.goods_name + '</option>'
                        })
                    }
                    elDistrict.html(content)
                },
                error: (error) => {
                    console.log(error)
                }

            })
        });

        // 获取表单数据
        function getFormData() {
            // 课程分类
            const cate_id = $('#cate_id').val();
            // 课程名称
            const product_id = $('#product_id').val();
            // 视频名称
            const cs_name = $('#cs_name').val();
            // 视频简介
            const cs_desc = $('#cs_desc').val();
            
            // 视频源名称包括扩展名
            let file_name = '';
            if ($('#exampleInputFile').get(0).files[0]) {
                file_name = $('#exampleInputFile').prop('files')[0].name;
            }
            // else {
            //     alert('请选择视频');
            //     return;
            // }


            //vod 视频ID
            // const vod_id = $('#vod_id').val();

            // 视频排序
            const sort = $('#sort').val();

            return {
                cate_id,
                product_id,
                cs_name,
                cs_desc,
                file_name,
                // vod_id,
                sort
            }
        }

        // 提交表单
        $('#saveVideo').click(function() {

            const formData = getFormData();
            console.warn('formData', formData);

            // 所有选项不能为空
            for(var key in formData) {
                if (formData[key] === '' || typeof formData[key] === undefined || formData[key] === 0) {
                    alert('所有值必填');
                    return;
                }
            }

            //获取vod上传的post参数
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                headers: {
                    'X-CSRF-Token':csrfToken
                },
                url: '/api/postVod',
                type: 'POST',
                dataType: 'json',
                cache: false,
                data: JSON.stringify(formData),
                contentType: 'application/json',
                success: function (res) {
                    if (res.code == 200) {
                        console.warn('res', res.data.ossData);
                        postObject(res.data.ossData, res.data.authData);
                    } else {
                        alert('SYS Error');
                    }
                },
                error: function (error) {
                    alert('获取vod参数失败');
                }
            })
        })

        // post oss object
        function postObject(vodParam, authData) {
            var formData = new FormData();

            for(var key in vodParam) {
                formData.append(key, vodParam[key]);
            }
            formData.append('file', $('#exampleInputFile').prop("files")[0]);

            $.ajax({
                url: vodParam.apiHost,
                type: 'POST',
                dataType: 'json',
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                // statusCode: {
                //     200: function (response) {
                //         console.warn('response', response);
                //         postFormData(authData.VideoId);
                //         alert('success');
                //     }
                // },
                // success: function (res) {
                //     console.warn('res', res);
                //     alert('successfffggg');
                // },
                // error: function (error) {
                //     console.warn('error', error);
                //     alert('post oss 失败');
                //     return;
                // },
                complete: function(xhr, textStatus) {
                    console.warn('xhr', xhr);
                    if (xhr.status == 200) {
                        console.warn('VideoId', authData.VideoId);
                        $('#vod_id').val(authData.VideoId);
                        alert('视频上传成功');
                        return;
                    } else {
                        alert('post oss 失败');
                        return;
                    }
                }
            })
        }

        //提交表单数据
        $('#saveForm').click(function(){
            postFormData();
        })

        function postFormData() {
            const VideoId = $('#vod_id').val();
            if (VideoId === '') {
                alert('请上传视频数据');
                return;
            }
            const formData = getFormData();
            formData['vod_id'] = VideoId;

            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                headers: {
                    'X-CSRF-Token':csrfToken
                },
                url: "<?= '/' . Yii::$app->request->getPathInfo();?>",
                type: 'POST',
                dataType: 'json',
                cache: false,
                data: JSON.stringify(formData),
                contentType: 'application/json',
                success: function (res) {
                    if (res.code == 200) {
                        alert(res.msg);
                        window.location.href = res.href;
                    } else {
                        alert(res.msg);
                    }
                },
                error: function (error) {
                    alert('获取vod参数失败');
                }
            })
        }


    })

    <?php $this->endBlock() ?>
</script>

<?php $this->registerJs($this->blocks['video_add'], \yii\web\View::POS_END); ?>