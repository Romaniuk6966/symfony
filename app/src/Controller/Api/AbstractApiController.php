<?php
namespace App\Controller\Api;

use Symfony\Component\Uid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractApiController extends AbstractController
{
    abstract public function delete(Uuid $uuid);
    abstract public function show(Uuid $uuid);
    abstract public function all();
}
