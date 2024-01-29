<?php
namespace Debug;

function dd($data): void 
{
    echo '<pre>';    
    var_dump($data);
    echo '</pre>';    
}