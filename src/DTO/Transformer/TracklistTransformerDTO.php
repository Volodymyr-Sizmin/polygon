<?php
namespace App\DTO\Transformer;

use App\DTO\TracklistDTO;
use Symfony\Component\HttpFoundation\Request;

class TracklistTransformerDTO
{

    public function transformerDTO(Request $request)
    {
        $dto = new TracklistDTO;
        $data = json_decode($request->getContent(), true);
        
        $dto->cover = $request->files->get('cover');
        $dto->track_path = $request->files->get('track');
        $dto->title = $request->get('title');
        $dto->author = $request->get('author');
        $dto->album = $request->get('album');
        $dto->type = $request->get('type');
        $dto->genre = $request->get('genre');

        return $dto;
    }
}