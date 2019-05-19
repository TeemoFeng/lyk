<?php
/**
 * Created by PhpStorm.
 * User: aa
 * Date: 2019/1/17
 * Time: 21:36
 */

namespace app\wycadmin\validate;


use think\Validate;

class Product extends Validate
{
    protected $rule = [
        ["title","require|max:128","标题不能为空|标题不能超过128个字符"],
      //  ["short_title","require|max:32","简略标题不能为空|简略标题不能超过32个字符"],
        ["cid","require|gt:0","商品分类不能为空|商品分类不能为空"],
        ["pc_image","require","PC端列表图不能为空"],
        ["yd_image","require","移动端列表图不能为空"],
        ["min_price","require|gt:0|number","最低价不能为空|最低价必须大于0|最低价只能填写数字"],
        ["colour","require|max:64","颜色不能为空|颜色不能超过64个字符"],
        ["count","require|number|egt:0","库存不能为空|库存只能填写数字|库存不能小于0"],
        ["sales_volume","require|number|egt:0","销量不能为空|销量只能填写数字|销量不能小于0"],
        ["content","require","详情不能为空"],
    ];
}