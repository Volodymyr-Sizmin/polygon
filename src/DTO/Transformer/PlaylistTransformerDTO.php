<?php

namespace App\DTO\Transformer;

use App\DTO\PlaylistDTO;
use Symfony\Component\HttpFoundation\Request;

class PlaylistTransformerDTO
{
    public function transform(Request $request): PlaylistDTO
    {
        $dto = new PlaylistDTO();

        $dto->title = $request->get('title');
        $dto->description = $request->get('description');

        return $dto;
    }
}
