<?php
/**
 * Created by PhpStorm.
 * User: aa
 * Date: 2019/1/19
 * Time: 17:42
 */

namespace app\common\model;


use think\Model;

class PublicModel extends Model
{

    protected $autoWriteTimestamp = true;
    /**
     * 查询信息
     * @param array $where 条件
     * @param bool $lock 是否开锁
     * @return PublicModel|null
     * @throws \think\exception\DbException
     */
    public static function getInfo($where = [], $field = '*', $lock = false)
    {
        return self::get (function ($query) use ($where, $lock, $field) {
            $query->field ($field)->lock ($lock)->where ($where);
        });
    }

    /**
     * @param string $field 获取的字段
     * @param array $where where条件
     * @param string $order 排序
     * @return PublicModel[]|false
     * @throws \think\exception\DbException
     */
    public static function getAll($field = '*', $where = [], $order = '',$lock = false)
    {
        return self::all (function ($query) use ($field, $where, $order,$lock) {
            $query->lock($lock)->field ($field)->where ($where)->order ($order);
        });
    }

    public static function delImage($path){
        @unlink (ROOT_PATH.'public'.$path);
    }


    public function getWStatusAttr($value,$data)
    {
        $arr = [
            '-1'=>'删除',
            '0'=>'禁用',
            '1'=>'正常'
        ];
        return $arr[$data['status']];
    }


    /**
     * 获取数量
     * @param array $where 条件
     * @param string $field 获取的字段
     * @return int|string
     * @throws \think\Exception
     */
    public static function getCount($where = [], $field = 'id')
    {
        return self::where ($where)->count ($field);
    }

    public function getWImagePathAttr($value,$data){
        return request ()->domain ().$data['image_path'];
    }



    /**
     * @param null $info 需要修改的对象
     * @param array $field 修改的字段
     * @param array $data 修改的值
     * @return mixed
     */
    public static function infoEdit($info = null, $field = [], $data = [])
    {
        return $info->allowField ($field)->isUpdate (true)->save ($data);
    }


    /**
     * 分页 下拉加载
     * @param array $where 查询条件
     * @param string $order 排序方式
     * @param int $listRow 分页条数
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function getInfoPage($where = [],$field = '*', $order = '', $listRow = 10)
    {
        return self::where ($where)->field($field)->order ($order)->paginate ($listRow, false, [
            'query' => request ()->param ()
        ]);
    }


    public static function updateStatus($idArr = [],$status = 1){
        self::where('id','in',$idArr)->setField([
            'status'=>$status
        ]);
    }



    public static function getValue($where = [],$value = ''){
        return self::where ($where)->value ($value);
    }


    /**
     * 新增
     * @param array $data 新增的数据
     * @param array $field 新增的字段
     * @return BaseModel
     */
    public static function infoAdd($data = [], $field = [])
    {
        return self::create ($data, $field);
    }



    /**
     * 新增
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        if (!is_array ($data)) {
            exception ('传递的数据不合法');
        } else {
            $result = $this->allowField (true)->save ($data);
            return $this->id;
        }
    }


    public function edit($data, $id)
    {
        if (!is_array ($data)) {
            exception ('传递的数据不合法');
        } else {
            $result = $this->allowField (true)->save ($data, ['id' => $id]);
            return $id;
        }
    }
}