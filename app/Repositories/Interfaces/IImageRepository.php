<?php


namespace App\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Model;

interface IImageRepository
{
    public function attach(Model $model, string $relation, array $images = [], string $directory = null): void;
}
