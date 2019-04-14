<?php
   namespace app\index\model;

   use think\Model;

   class User extends Model
   {
        //开启
        protected $autoWriteTimestamp = true;
       //查询 $where为数组
       public function select($where){
           return $this->where($where)->find();
       }
        //插入 $data为数组
       public function insert($data)
       {
           $result = $this->save($data);
           if ($result === false) {
               return false;
           } else {
               return true;
           }
       }
       //更新 操作
       public function _update($where=array(),$update=array())
       {
            $result = $this->where($where)->update($update);
           if ($result === false) {
               return false;
           } else {
               return true;
           }
       }
       //删除操作
       public function delete($where=array())
       {
            return $this->where($where)->delete();
       }

   }