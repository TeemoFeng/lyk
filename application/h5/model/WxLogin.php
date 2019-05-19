<?php
/**
 *  微信登陆 模型
 */
namespace app\h5\model;


class WxLogin extends BaseModel
{
    /**
     * 保存微信登陆用户信息
     * @param array $data
     * @return WxLogin|false|int
     * @auther enfu
     * @date 2019/5/14 11:25
     */
    public function saveUserInfo($data)
    {
        return self::create($data);
    }
}