<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

class BaseService
{
    protected $model;

    public function paginateRessource(Request $request, string $resourceClass): LengthAwarePaginator {
        if (!class_exists($resourceClass)) {
            throw new Exception(__('crud.message.class_not_found'));
        }
        $perPage = is_null($request['perPage']) ? 10 : $request['perPage'];
        $page = is_null($request['page']) ? 1 : $request['page'];
        $offset = ($page - 1 ) * $perPage;

        $query = $this->model::filter();
        $total = $query->get()->count();
        $result = $query->offset($offset)->limit($perPage);

        return new LengthAwarePaginator(new $resourceClass($result->get()), $total, $perPage, $page);
    }

    public function toOptions(string $field = "name") {
        $result = $this->model::select(['id', $field])->get();
        return $result;
    }

    public function getByCustom(array $filters) {
        $query = $this->model::query();

        foreach ($filters as $filter) {
            $model = new $this->model();
            if (!Schema::hasColumn($model->getTable(), $filter['column'])) {
                throw new Exception(__('crud.message.property_not_found'));
            }
            $mod = isset($filter['mod']) ? $filter['mod'] : '=';
            switch ($mod ) {
                case 'or':
                    $query->orWhere($filter['column'], '=', $filter['value']);
                    break;
                case 'in':
                    $query->whereIn($filter['column'], $filter['value']);
                    break;
                default:
                    $query->where($filter['column'], $mod, $filter['value']);
                    break;
            }
        }
        return $query->get();
    }
}
