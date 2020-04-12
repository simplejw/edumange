<?php
$this->title = '后台报名';

use yii\widgets\LinkPager;
?>
<form action="" method="post" class="form-horizontal" id="form" enctype="multipart/form-data">
    <h4>课程信息</h4>
    <div class="form-group">
        <label for="" class='col-md-2 control-label'>课程分类</label>
        <div class='col-md-4'>
            <select class="form-control" name="cate_id" id="cate_id" <?php if (isset($order_goods['cat_id'])){echo ' disabled="disabled" ';}?> >
                <option value="">-- 选择分类 --</option>
                <?php foreach ($category as $res): ?>
                    <option value="<?= $res['cat_id'];?>" <?php if (isset($order_goods['cat_id']) && $res['cat_id'] == $order_goods['cat_id']){echo ' selected = "selected" ';}?> ><?= $res['cat_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>课程名称</label>
        <div class='col-md-4'>
            <select class="form-control" name="goods_id" id="goods_id" <?php if (isset($order_goods['goods_id'])){echo ' disabled="disabled" ';}?>>
                <option value="">-- 选择课程 --</option>
                <?php if (!empty($order_goods)): ?>
                    <option value="<?php if (isset($order_goods['goods_id'])){echo $order_goods['goods_id'];}?>" <?php if (isset($order_goods['goods_id'])){echo ' selected = "selected" ';}?> ><?php if (isset($order_goods['goods_name'])){echo $order_goods['goods_name'];}?></option>
                <?php endif; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>课程金额</label>
        <div class='col-md-4'>
            <input type="number" name="goods_price" class="form-control" id="goods_price" placeholder="课程金额" <?php if (!empty($order)){ echo ' value="' . $order->order_amount . '"';}?> >
        </div>
    </div>

    <br>
    <h4>个人信息</h4>
    <div class="form-group">
        <label for="" class='col-md-2 control-label'>姓名</label>
        <div class='col-md-4'>
            <input type="text" name="realname" class="form-control" id="realname" placeholder="姓名" <?php if (!empty($order)){ echo ' value="' . $order->realname . '"';}?> >
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>手机号</label>
        <div class='col-md-4'>
            <input type="text" name="mobile" class="form-control" id="mobile" placeholder="手机号" <?php if (!empty($order)){ echo ' value="' . $order->mobile . '"';}?> >
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>政治面貌</label>
        <div class='col-md-4'>
            <label class="radio-inline">
                <input type="radio" name="political_status" id="" value="0" <?php if (isset($order->political_status) && $order->political_status ==0 ){echo ' checked ';}?> > 群众
            </label>
            <label class="radio-inline">
                <input type="radio" name="political_status" id="" value="1" <?php if (isset($order->political_status) && $order->political_status ==1 ){echo ' checked ';}?> > 团员
            </label>
            <label class="radio-inline">
                <input type="radio" name="political_status" id="" value="2" <?php if (isset($order->political_status) && $order->political_status ==2 ){echo ' checked ';}?> > 党员
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>省份</label>
        <div class='col-md-4'>
            <select class="form-control" name="province" id="province"  >
                <option value="">-- 选择省份 --</option>
                <?php foreach ($province as $pro): ?>
                    <option value="<?php echo $pro->region_id; ?>" <?php if (isset($order->province) && $pro->region_id == $order->province){echo ' selected = "selected" ';}?> ><?php echo $pro->region_name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="" class='col-md-2 control-label'>城市</label>
        <div class='col-md-4'>
            <select class="form-control" name="city" id="city">
                <!-- <option value="">-- 选择城市 --</option> -->
                <?php if (!empty($order)): ?>
                    <?php foreach ($city as $ct): ?>
                        <option value="<?php echo $ct->region_id; ?>" <?php if (isset($order->city) && $ct->region_id == $order->city){echo ' selected = "selected" ';}?> ><?php echo $ct->region_name; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="" class='col-md-2 control-label'>区/县</label>
        <div class='col-md-4'>
            <select class="form-control" name="district" id="district">
                <!-- <option value="">-- 选择区/县 --</option> -->
                <?php if (!empty($order)): ?>
                    <?php foreach ($district as $dt): ?>
                        <option value="<?php echo $dt->region_id; ?>" <?php if (isset($order->district) && $dt->region_id == $order->district){echo ' selected = "selected" ';}?> ><?php echo $dt->region_name; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="" class='col-md-2 control-label'>地址</label>
        <div class='col-md-4'>
            <input type="text" name="address" class="form-control" id="address" placeholder="详细地址" <?php if (!empty($order)){ echo ' value="' . $order->address . '"';}?> >
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>备注</label>
        <div class='col-md-4'>
            <textarea class="form-control" name="remark" id="remark" rows="3"><?php if (!empty($order)){ echo $order->remark;}?></textarea>
        </div>
    </div>

    <br>
    <h4>证件信息</h4>
    <div class="form-group">
        <label for="" class='col-md-2 control-label'>身份证正面照</label>
        <div class='col-md-4'>
            <input type="file" name="identity_fr" id="identity_fr" class="fileInput" value="<?php if (!empty($iden_img)){ echo \Yii::$app->request->hostInfo . '/upload/' . $iden_img->identity_fr;}?>" >
            <img src="<?php if (!empty($iden_img)){ echo \Yii::$app->request->hostInfo . '/upload/' . $iden_img->identity_fr;}?>" alt="" class="img-rounded">
            <hr>
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>身份证反面照</label>
        <div class='col-md-4'>
            <input type="file" name="identity_bg" id="identity_bg" class="fileInput" value="<?php if (!empty($iden_img)){ echo \Yii::$app->request->hostInfo . '/upload/' . $iden_img->identity_bg;}?>" >
            <img src="<?php if (!empty($iden_img)){ echo \Yii::$app->request->hostInfo . '/upload/' . $iden_img->identity_bg;}?>" alt="" class="img-rounded">
            <hr>
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>学历照</label>
        <div class='col-md-4'>
            <input type="file" name="edu_img" id="edu_img" class="fileInput" value="<?php if (!empty($iden_img)){ echo \Yii::$app->request->hostInfo . '/upload/' . $iden_img->edu_img;}?>" >
            <img src="<?php if (!empty($iden_img)){ echo \Yii::$app->request->hostInfo . '/upload/' . $iden_img->edu_img;}?>" alt="" class="img-rounded">
            <hr>
        </div>
    </div>

    <div class="form-group">
        <label for="" class='col-md-2 control-label'>2寸白底照片</label>
        <div class='col-md-4'>
            <input type="file" name="signage_img" id="signage_img" class="fileInput" value="<?php if (!empty($iden_img)){ echo \Yii::$app->request->hostInfo . '/upload/' . $iden_img->signage_img;}?>" >
            <img src="<?php if (!empty($iden_img)){ echo \Yii::$app->request->hostInfo . '/upload/' . $iden_img->signage_img;}?>" alt="" class="img-rounded">
            <hr>
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

    $(document).ready(function () {
        $("#province").on('change', () => {
            const parentId = $("#province").val()
            const elCity = $("#city")
            const elDistrict = $("#district")
            elDistrict.html('<option value=0>-- 选择区/县 --</option>')
            $.ajax({
                url: '/api/regions/' + parentId,
                type: 'get',
                dataType: 'json',
                success: (data) => {
                    let content = ''
                    content += '<option value=0>-- 选择城市 --</option>'
                    if (data) {
                        const dataValues = Object.values(data)
                        dataValues.forEach((item) => {
                            content += '<option value='+ item.region_id +'>' + item.region_name + '</option>'
                        })
                    }
                    elCity.html(content)
                },
                error: (error) => {
                    console.log(error)
                }

            })
        });

        $("#city").on('change', () => {
            const parentId = $("#city").val()
            const elDistrict = $("#district")
            $.ajax({
                url: '/api/regions/' + parentId,
                type: 'get',
                dataType: 'json',
                success: (data) => {
                    let content = ''
                    content += '<option value=0>-- 选择区/县 --</option>'
                    if (data) {
                        const dataValues = Object.values(data)
                        dataValues.forEach((item) => {
                            content += '<option value='+ item.region_id +'>' + item.region_name + '</option>'
                        })
                    }
                    elDistrict.html(content)
                },
                error: (error) => {
                    console.log(error)
                }

            })
        });

        $("#cate_id").on('change', () => {
            const parentId = $("#cate_id").val()
            const elDistrict = $("#goods_id")
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

    })

    $('.fileInput').change(function(){
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
                if (res.code == 200) {
                    const { data: { path } } = res;
                    $(id).attr('path', path);
                    $(id).next().attr('src', "<?= \Yii::$app->request->hostInfo . '/upload/';?>" + path);
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
        const cate_id = $('#cate_id').val();
        // 课程名称
        const goods_id = $('#goods_id').val();
        // 课程金额
        const goods_price = $('#goods_price').val();
        // 姓名
        const realname = $('#realname').val();
        // 手机号
        const mobile = $('#mobile').val();
        // 政治面貌
        const political_status = $('input[name="political_status"]:checked').val();
        // 省份
        const province = $('#province').val();
        // 城市
        const city = $('#city').val();
        // 区/县
        const district = $('#district').val();
        // 地址
        const address = $('#address').val();
        // 备注
        const remark = $('#remark').val();
        // 身份证正面照
        const identity_fr = $('#identity_fr').attr("path");
        // 身份证反面照
        const identity_bg = $('#identity_bg').attr("path");
        // 学历照
        const edu_img = $('#edu_img').attr("path");
        // 2寸白底照片
        const signage_img = $('#signage_img').attr("path");
        return {
            cate_id,
            goods_id,
            goods_price,
            realname,
            mobile,
            political_status,
            province,
            city,
            district,
            address,
            remark,
            identity_fr,
            identity_bg,
            edu_img,
            signage_img,
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
                if (res.code == 200) {
                    window.location.href = "/order/index";
                }else{
                    window.location.href = "/order/add";
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
