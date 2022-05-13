<?php

namespace App\DTO\Transformer;

use App\DTO\TracklistDTO;
use App\Service\Validation\ValidationService;
use Symfony\Component\HttpFoundation\Request;

class TracklistTransformerDTO
{
    /**
     * @throws \App\Exception\ValidationServiceException
     */
    public function transformerDTO(Request $request): TracklistDTO
    {
        $validation = new ValidationService();
        $dto = new TracklistDTO();

        $validation->smallField($request->get('title'), 2, 60);
        $validation->smallField($request->get('author'), 2, 60);
        $validation->smallField($request->get('album'), 2, 60);

        $dto->cover = $request->files->get('cover');
        $dto->track_path = $request->files->get('trackPath');
        $dto->title = $request->get('title');
        $dto->author = $request->get('author');
        $dto->album = $request->get('album');
        $dto->type = $request->get('type');
        $dto->genre = $request->get('genre');

        return $dto;
    }
}
