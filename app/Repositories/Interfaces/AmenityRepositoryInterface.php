<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface AmenityRepositoryInterface
{
    public function all(Request $request);

    public function store($data);

    public function find($model);

    public function update($model, $data);

    public function destroy($model);
}
