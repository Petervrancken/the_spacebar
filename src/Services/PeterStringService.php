<?php


namespace App\Services;



class PeterStringService
{
    public function capital(string $source){
        return strtoupper($source);
    }
}