<?php


namespace App\Repositories;

use App\Helpers\MenuHelper;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BaseRepository
{
    protected $model;
    protected $trans;
    protected array $log_context;

    public function __construct($model, $trans = null)
    {
        $this->model = $model;
        $this->trans = $trans;
        $this->log_context = [
            'module' => 'Base Repository',
            'logger' => 'Farhan',
            'time' => date('Y-m-d H:i:s')
        ];
    }

    public function model()
    {
        return $this->model;
    }

    public function datatable(array $parameter = null)
    {
        $make_true = @$parameter['make_true'] ?? true;
        $where_array = @$parameter['where'];
        $relations = @$parameter['relations'];
        $data = $relations ? $this->model->with($relations) : $this->query();
        if ($where_array) {
            $data->where([[$where_array]]);
        }
        $datatable = Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('picture', function ($data) {
                if ($data->picture) {
                    $url = asset('storage/profile_images/' . $data->picture);
                } else {
                    $url = asset('assets/images/users/avatar_blank.png');
                }
                $picture = '<img class="img rounded-circle" src="' . $url . '" width="35" height="35">';
                return $picture;
            })
            ->addColumn('image', function ($data) {
                if ($data->image) {
                    $url = asset('frontend/img/MemberImage/' . $data->image);
                } else {
                    $url = asset('assets/images/users/avatar_blank.png');
                }
                $image = '<img class="img rounded-circle" src="' . $url . '" width="35" height="35">';
                return $image;
            })
            ->filterColumn('status', function ($query, $keyword) {
                $query->where('status', 'LIKE', "%{$keyword}%");
            })
            ->addColumn('action', function ($data) {
                $action_array = [
                    'id' => $data->id,
                    'subject' => $data,
                ];
                $action = '';
                $action .= MenuHelper::TableActionButton($action_array);
                return $action;
            })
            ->addColumn('status', function ($data) {
                $status = '';
                $status .= MenuHelper::status($data->id, $data->status);
                return $status;
            })
            ->rawColumns(['picture', 'image', 'action', 'status']);

        if ($make_true) {
            return $datatable->make(true);
        } else {
            return $datatable;
        }
    }

    public function deletedDatatable(array $parameter = null)
    {
        $make_true = @$parameter['make_true'] ?? true;
        $where_array = @$parameter['where'];
        $relations = @$parameter['relations'];
        $data = $relations ? $this->model->with($relations)->onlyTrashed() : $this->model->onlyTrashed();
        if ($where_array) {
            $data->where([[$where_array]]);
        }
        $datatable = Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('picture', function ($data) {
                if ($data->picture) {
                    $url = asset('storage/profile_images/' . $data->picture);
                } else {
                    $url = asset('assets/images/users/avatar_blank.png');
                }
                $picture = '<img class="img img-fluid rounded-circle" src="' . $url . '" width="35" height="35">';
                return $picture;
            })
            ->addColumn('image', function ($data) {
                if ($data->image) {
                    $url = asset('frontend/img/MemberImage/' . $data->image);
                } else {
                    $url = asset('assets/images/users/avatar_blank.png');
                }
                $image = '<img class="img img-fluid rounded-circle" src="' . $url . '" width="35" height="35">';
                return $image;
            })
            ->filterColumn('status', function ($query, $keyword) {
                $query->where('status', 'LIKE', "%{$keyword}%");
            })
            ->addColumn('status', function ($data) {
                $status = '';
                $status .= MenuHelper::status($data->id, $data->status);
                return $status;
            })
            ->addColumn('action', function ($data) {
                $action_array = [
                    'id' => $data->id
                ];
                $action = '';
                $action .= MenuHelper::TableActionButton($action_array);
                return $action;
            })
            ->rawColumns(['picture', 'image', 'action', 'status']);

        if ($make_true) {
            return $datatable->make(true);
        } else {
            return $datatable;
        }
    }

    public function query()
    {
        return $this->model::query();
    }

    public function pluck($where_array = null)
    {
        $default_language = App::getLocale();
        return $this->model::where([['status', 'Active'], [$where_array]])->pluck(($default_language == 'bn') ? 'bn_name' : 'name', 'id');
    }

    public function get($where_array = null)
    {
        return $this->model::where([[$where_array]])->get();
    }


    public function selectRawPluck(array $params = null)
    {
        return $this->model::where([['status', 'Active'], [@$params['where']]])->selectRaw(@$params['columns'])->pluck($params['pluck']['key'], $params['pluck']['value']);
    }

    public function find($id)
    {
        return $this->model::find($id);
    }

    public function first(array $params = null)
    {
        return $this->model::where([[@$params['where']]])->first();
    }

    public function all()
    {
        return $this->model::all();
    }

    public function create(object $data, array $parameters = null)
    {
        DB::beginTransaction();
        try {
            $data['created_by'] = \Auth::id();
            $last_data = $this->model::create($data->all());

            if (@$parameters['create_many']) {
                $this->createManyRelation($last_data, $parameters);
            }

            //image uploads
            $image_array = @$parameters['image_info'];
            if ($image_array) {
                foreach ($image_array as $image_info) {
                    if ($image_info['images']) {
                        if (!is_array($image_info['images'])) {
                            $image_info['images'] = [$image_info['images']];
                        }
                        foreach ($image_info['images'] as $image) {
                            $image_parameters = [
                                'image' => $image,
                                'directory' => $image_info['directory'],
                                'width' => @$image_info['width'],
                                'height' => @$image_info['height'],
                            ];
                            $source = ImageHelper::Image($image_parameters);
                            $file_parameter = [
                                'source' => $source,
                                'type' => $image_info['type'],
                                'created_by' => $last_data->created_by,
                            ];
                            $file = new File($file_parameter);
                            $last_data->files()->save($file);
                        }
                    }
                }
            }

            DB::commit();
            session()->put('created_user', $last_data);
            Toastr::success(trans('common.created', ['model' => $this->getTranslateKey()]), trans('common.success'));
            if ($data->ajax() == true) {
                return response()->json([
                    'data' => $last_data,
                    'message' => trans('common.created', ['model' => $this->getTranslateKey()]),
                ], 200);
            } else {
                return redirect(route($this->getModelNameLower() . '.index'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Method: create Exception:' . $e->getMessage(), $this->log_context);
            if ($data->ajax() == true) {
                return response()->json($e->getMessage(), 500);
            } else {
                Toastr::error(trans('common.error') . '</br>' . $e->getMessage(), trans('common.failed'));
                return back()->withInput()->withErrors($e->getMessage());
            }
        }
    }

    public function createManyRelation($last_data, $parameters)
    {
        foreach ($parameters['create_many'] as $key => $create_many) {
            $create_many['data'] = collect($create_many['data'])->map(function ($item) {
                $item['created_by'] = auth()->user()->id;
                return $item;
            });
            $create_many_relation = $create_many['relation'];
            $relation_items = $last_data->$create_many_relation()->createMany($create_many['data']);
            foreach ($create_many['data'] as $key => $create_many_relations) {
                if (@$create_many_relations['create_many']) {
                    $last_data = $relation_items[$key];
                    $parameters = $create_many_relations;
                    $this->createManyRelation($last_data, $parameters);
                }
            }

        }
    }

    public function update($id, object $data, array $parameters = null)
    {
        DB::beginTransaction();
        try {
            $data['updated_by'] = \Auth::id();
            $last_data = $this->model::find($id);
            $last_data->update($data->all());

            //save relational data
            if (@$parameters['create_many']) {
                $this->updateManyRelation($last_data, $parameters);
            }

            //image uploads
            $image_array = @$parameters['image_info'];
            if ($last_data->files != null) {
                $last_data->files()->update(['deleted_by' => \Auth::id()]);
                if (@$data->delete_images != null) {
                    $last_data->files()->whereIn('id', $data->delete_images)->delete();
                }
            }

            if ($image_array) {
                foreach ($image_array as $image_info) {
                    if ($image_info['images']) {
                        if (!is_array($image_info['images'])) {
                            $image_info['images'] = [$image_info['images']];
                        }
                        foreach ($image_info['images'] as $image) {
                            $image_parameters = [
                                'image' => $image,
                                'directory' => $image_info['directory'],
                                'width' => @$image_info['width'],
                                'height' => @$image_info['height'],
                            ];
                            $source = ImageHelper::Image($image_parameters);
                            $file_parameter = [
                                'source' => $source,
                                'type' => $image_info['type'],
                                'created_by' => $last_data->created_by,
                                'updated_by' => $last_data->updated_by,
                            ];
                            $file = new File($file_parameter);
                            $last_data->files()->save($file);
                        }
                    }
                }
            }

            DB::commit();
            if ($data->ajax() == true) {
                return response()->json([
                    'data' => $last_data,
                    'message' => trans('common.updated', ['model' => $this->getTranslateKey()]),
                ], 200);
            } else {
                Toastr::success(trans('common.updated', ['model' => $this->getTranslateKey()]), trans('common.success'));
                return redirect(route($this->getModelNameLower() . '.index'));
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Method: update Exception:' . $e->getMessage(), $this->log_context);
            if ($data->ajax() == true) {
                return response()->json($e->getMessage(), 500);
            } else {
                Toastr::error(trans('common.error') . '</br>' . $e->getMessage(), trans('common.failed'));
                return back()->withInput()->withErrors($e->getMessage());
            }
        }
    }

    public function updateManyRelation($last_data, $parameters)
    {
        foreach ($parameters['create_many'] as $create_many) {
            $create_many['data'] = collect($create_many['data'])->map(function ($item) use ($last_data) {
                $item['created_by'] = $last_data->created_by;
                $item['updated_by'] = $last_data->updated_by;
                return $item;
            });
            $create_many_relation = $create_many['relation'];

            if ($last_data->$create_many_relation()->first() != null) {
                $table = $last_data->$create_many_relation->first()->getTable();
                $last_data->$create_many_relation()->forceDelete();
                $last_id = DB::table($table)->max('id');
                if ($last_id) {
                    \DB::statement("ALTER TABLE `$table` AUTO_INCREMENT =  $last_id");
                } else {
                    \DB::statement("ALTER TABLE `$table` AUTO_INCREMENT =  1");
                }
            }
            $relation_items = $last_data->$create_many_relation()->createMany($create_many['data']);
            foreach ($create_many['data'] as $key => $create_many_relations) {
                if (@$create_many_relations['create_many']) {
                    $last_data = $relation_items[$key];
                    $parameters = $create_many_relations;
                    $this->updateManyRelation($last_data, $parameters);
                }
            }
        }
    }

    public function delete($id, array $relations = null)
    {
        try {
            $data = $this->model::find($id);
            $data->deleted_by = \Auth::id();
            $data->save();
            if ($data->files != null) {
                $data->files()->delete();
            }
            if (@$relations != null) {
                foreach ($relations as $relation) {
                    $data->$relation()->delete();
                }
            }
            $data->destroy($id);
            return response()->json([
                'message' => trans('common.deleted', ['model' => $this->getTranslateKey()])
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Method: delete Exception:' . $e->getMessage(), $this->log_context);
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function restore($id, array $relations = null)
    {
        try {
            $data = $this->model::withTrashed()->find($id);
            if ($data->files != null) {
                $data->files()->restore();
            }
            $data->restore();
            if (@$relations != null) {
                foreach ($relations as $relation) {
                    $data->$relation()->restore();
                }
            }
            return response()->json([
                'message' => trans('common.restored', ['model' => $this->getTranslateKey()])
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Method: restore Exception:' . $e->getMessage(), $this->log_context);
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function forceDelete($id, array $relations = null)
    {
        try {
            $data = $this->model::withTrashed()->find($id);
            if ($data->files != null) {
                $data->files()->forceDelete();
            }
            if (@$relations != null) {
                foreach ($relations as $relation) {
                    $data->$relation()->forceDelete();
                }
            }
            $data->forceDelete($id);
            return response()->json([
                'message' => trans('common.permanently_deleted', ['model' => $this->getTranslateKey()])
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Method: forceDelete Exception:' . $e->getMessage(), $this->log_context);
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function multipleDelete(object $data)
    {
        try {
            DB::beginTransaction();
            $multiple_id_array = $data->ids;

            $data = $this->model::whereIn('id', $multiple_id_array)->get(['id']);
            $get_data = $data;

            $trashed_data = $this->model::withTrashed()->whereIn('id', $multiple_id_array);
            $get_trashed_data = $trashed_data;

            if ($get_data->count() > 0 && $this->model::destroy($data->toArray())) {
                DB::commit();
                return true;
            } elseif ($get_trashed_data->count() > 0 && $trashed_data->forceDelete()) {
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Method: multipleDelete Exception:' . $e->getMessage(), $this->log_context);
            return $e->getMessage();
        }
    }

    public function multipleRestore(object $data)
    {
        try {
            DB::beginTransaction();
            $multiple_id_array = $data->ids;
            $datas = $this->model::onlyTrashed()->whereIn('id', $multiple_id_array)->get();
            if (count($datas) > 0) {
                foreach ($datas as $data) {
                    $this->model::withTrashed()->find($data->id)->restore();
                }
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Method: multipleRestore Exception:' . $e->getMessage(), $this->log_context);
            return $e->getMessage();
        }
    }

    public function status($id)
    {
        DB::beginTransaction();
        try {
            $data = $this->model::find($id);
            if ($data == null) {
                $data = $this->model::withTrashed()->find($id);
            }
            if ($data->status === 'Active') {
                $data->status = 'Inactive';
            } elseif ($data->status === 'Inactive') {
                $data->status = 'Active';
            } elseif ($data->status == 1) {
                $data->status = 0;
            } elseif ($data->status == 0) {
                $data->status = 1;
            }
            $data->update();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Method: status Exception:' . $e->getMessage(), $this->log_context);
            return $e->getMessage();
        }
    }

    public function with(array $relations = null)
    {
        return $this->model->with($relations);
    }

    protected function getModelName()
    {
        return explode('App\Models\\', get_class($this->model), 2)[1];
    }

    protected function getTranslateKey()
    {
        $routeName = explode('.', Route::currentRouteName());
        /*$menu = Menu::where('route_name',$routeName[0].".index")->first();
        if($this->trans){
        return $this->trans;
        }elseif (@$menu){
        return $menu->bn_name;
        }*/
    }

    protected function getModelNameLower()
    {
        return Str::snake(explode('App\Models\\', get_class($this->model), 2)[1]);
    }

}
