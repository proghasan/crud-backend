<?php

namespace App\Repository;
interface  ProductRepositoryInterface
{
    public function save(array $request);
    public function update(array $request);
    public function delete($id);
    public function products();
    public function product($id);
}