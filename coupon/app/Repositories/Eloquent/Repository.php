<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * 定义一个抽象类
 * Date: 2017/11/4
 * Time: 19:16
 */
namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryInterface{

    /**
     * @var null
     */
    private $container = null;

    /**
     * @var
     */
    protected $model;

    /**
     * Repository constructor.
     * @param Container $container
     */
    public function __construct(Container $container) {
        $this->container = $container;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     * 具体操纵的模型名称
     * @return mixed
     */
    abstract function model();

    public function makeModel() {
        $model = $this->containern->make($this->model());

        if (!$model instanceof Model){
            throw  new \Exception('这是异常');
        }

        return $this->model = $model->newQuery();
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*')) {
        return $this->model->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*')) {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data) {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute="id") {
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')) {
        return $this->model->find($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*')) {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }
}