<?php
namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function getUser()
    {
        $perPage = 3;
        $currentPage = request()->input('page', 1);

        $total = $this->model->count();

        $items = $this->model->select('*')->skip(($currentPage - 1) * $perPage)->take($perPage)->get();
        $path = "/manager-user";
        return new LengthAwarePaginator($items, $total, $perPage, $currentPage, [
            'path' => $path,
        ]);

        // return $this->model->select('*')->take(5)->get();
    }
}