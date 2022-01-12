<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\PlaylistsTracks;
use App\Interfaces\Playlist\PlaylistServiceInterface;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @IgnoreAnnotation("apiName")
 * @IgnoreAnnotation("apiGroup")
 * @IgnoreAnnotation("apiParam")
 * @IgnoreAnnotation("apiBody")
 * @IgnoreAnnotation("apiSuccess")
 * @IgnoreAnnotation("apiSuccessExample")
 * @IgnoreAnnotation("apiError")
 * @IgnoreAnnotation("apiErrorExample")
 * @IgnoreAnnotation("apiHeader")
 * @IgnoreAnnotation("apiHeaderExample")
 * @IgnoreAnnotation("apiParamExample")
 */
class PlaylistController extends SerializeController
{
    private EntityManagerInterface $entityManager;
    private PlaylistServiceInterface $playlistService;

    public function __construct(EntityManagerInterface $entityManager, PlaylistServiceInterface $playlistService)
    {
        $this->entityManager = $entityManager;
        $this->playlistService = $playlistService;
    }

    /**
     * @api {GET} /backend/api/playlists Index Playlist
     * @apiName Index
     * @apiGroup Playlists
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     *
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     *  {
     *   "id": 1,
     *   "name": "name",
     * "createdAt": {
     *      "timezone": {
     *           "name": "UTC",
     *           "transitions": [
     *               {
     *                   "ts": -9223372036854775808,
     *                   "time": "-292277022657-01-27T08:29:52+0000",
     *                   "offset": 0,
     *                   "isdst": false,
     *                   "abbr": "UTC"
     *               }
     *           ],
     *           "location": {
     *               "country_code": "??",
     *               "latitude": 0,
     *               "longitude": 0,
     *               "comments": ""
     *          }
     *       },
     *       "offset": 0,
     *       "timestamp": 1636761600
     *   },
     *   "updatedAt": {
     *       "timezone": {
     *          "name": "UTC",
     *           "transitions": [
     *               {
     *                   "ts": -9223372036854775808,
     *                   "time": "-292277022657-01-27T08:29:52+0000",
     *                   "offset": 0,
     *                   "isdst": false,
     *                   "abbr": "UTC"
     *               }
     *           ],
     *           "location": {
     *               "country_code": "??",
     *               "latitude": 0,
     *               "longitude": 0,
     *               "comments": ""
     *          }
     *       },
     *       "offset": 0,
     *      "timestamp": 1636761600
     *   },
     *   "description": "desk"
     *},
     *{
     *   "id": 2,
     *   "name": "name",
     *   "createdAt": {
     *       "timezone": {
     *           "name": "UTC",
     *           "transitions": [
     *               {
     *                  "ts": -9223372036854775808,
     *                   "time": "-292277022657-01-27T08:29:52+0000",
     *                   "offset": 0,
     *                   "isdst": false,
     *                   "abbr": "UTC"
     *               }
     *           ],
     *           "location": {
     *               "country_code": "??",
     *               "latitude": 0,
     *               "longitude": 0,
     *               "comments": ""
     *           }
     *       },
     *       "offset": 0,
     *       "timestamp": 1636784993
     *   },
     *   "updatedAt": {
     *       "timezone": {
     *           "name": "UTC",
     *           "transitions": [
     *               {
     *                   "ts": -9223372036854775808,
     *                   "time": "-292277022657-01-27T08:29:52+0000",
     *                   "offset": 0,
     *                   "isdst": false,
     *                   "abbr": "UTC"
     *               }
     *           ],
     *           "location": {
     *               "country_code": "??",
     *               "latitude": 0,
     *               "longitude": 0,
     *               "comments": ""
     *           }
     *       },
     *       "offset": 0,
     *      "timestamp": 1636784993
     *   },
     *   "description": "description"
     *}
     */
    public function index(): JsonResponse
    {
        return JsonResponse::fromJsonString($this->serializeJson($this->playlistService->indexService()));
    }

    /**
     * @api {POST} /backend/api/playlists Create Playlist
     * @apiName CreatePlaylist
     * @apiGroup Playlists
     *
     * @apiParam {String} name Playlist name
     * @apiParam {String} description Playlist description
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *       "name": "name",
     *       "description": "description"
     *     }
     *
     * @apiSuccess (201) {Boolean} success Should be true
     * @apiSuccess (201) {JSON} body Response body
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 201 CREATED
     * {
     *       "id": 3,
     *       "name": "name",
     *       "createdAt": {
     *           "timezone": {
     *               "name": "UTC",
     *               "transitions": [
     *                   {
     *                       "ts": -9223372036854775808,
     *                       "time": "-292277022657-01-27T08:29:52+0000",
     *                       "offset": 0,
     *                       "isdst": false,
     *                       "abbr": "UTC"
     *                  }
     *              ],
     *               "location": {
     *                  "country_code": "??",
     *                   "latitude": 0,
     *                   "longitude": 0,
     *                   "comments": ""
     *               }
     *           },
     *           "offset": 0,
     *           "timestamp": 1634522242
     *       },
     *       "updatedAt": {
     *           "timezone": {
     *               "name": "UTC",
     *               "transitions": [
     *                   {
     *                       "ts": -9223372036854775808,
     *                       "time": "-292277022657-01-27T08:29:52+0000",
     *                       "offset": 0,
     *                       "isdst": false,
     *                       "abbr": "UTC"
     *                   }
     *               ],
     *               "location": {
     *                   "country_code": "??",
     *                   "latitude": 0,
     *                   "longitude": 0,
     *                   "comments": ""
     *               }
     *           },
     *           "offset": 0,
     *           "timestamp": 1634522242
     *       },
     *       "description": "description"
     *   }
     *
     *   @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400 Bad Request
     *     {
     *       "success": false,
     *       "body": {
     *          "message": "An error occurred during playlist creation."
     *       }
     *     }
     */
    public function createPlaylist(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        /** @var $playlist Playlist */
        $playlist = $this->playlistService->createPlaylist($data);
        if (isset($playlist['errors'])) {
            return new JsonResponse([
                'success' => false,
                'body' => [
                    'message' => $playlist['errors'],
                ],
            ], Response::HTTP_BAD_REQUEST);
        }

        return JsonResponse::fromJsonString($this->serializeJson($playlist), Response::HTTP_CREATED);
    }

    /**
     * @api {GET} /backend/api/playlists/:id Show Playlist
     * @apiName GetPlaylist
     * @apiGroup Playlists
     *
     * @apiParam  {id} id Playlist id
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "id": 3,
     *       "name": "name",
     *       "createdAt": {
     *           "timezone": {
     *               "name": "UTC",
     *               "transitions": [
     *                   {
     *                       "ts": -9223372036854775808,
     *                       "time": "-292277022657-01-27T08:29:52+0000",
     *                       "offset": 0,
     *                       "isdst": false,
     *                       "abbr": "UTC"
     *                  }
     *              ],
     *               "location": {
     *                  "country_code": "??",
     *                   "latitude": 0,
     *                   "longitude": 0,
     *                   "comments": ""
     *               }
     *           },
     *           "offset": 0,
     *           "timestamp": 1634522242
     *       },
     *       "updatedAt": {
     *           "timezone": {
     *               "name": "UTC",
     *               "transitions": [
     *                   {
     *                       "ts": -9223372036854775808,
     *                       "time": "-292277022657-01-27T08:29:52+0000",
     *                       "offset": 0,
     *                       "isdst": false,
     *                       "abbr": "UTC"
     *                   }
     *               ],
     *               "location": {
     *                   "country_code": "??",
     *                   "latitude": 0,
     *                   "longitude": 0,
     *                   "comments": ""
     *               }
     *           },
     *           "offset": 0,
     *           "timestamp": 1634522242
     *       },
     *       "description": "description"
     *      }
     */
    public function showPlaylist(Playlist $playlist): JsonResponse
    {
        return JsonResponse::fromJsonString($this->serializeJson($playlist));
    }

    /**
     * @api {PUT} /backend/api/playlists Modify Playlist
     * @apiName ModifyPlaylist
     * @apiGroup Playlists
     *
     * @apiParam {id} id Playlist id
     * @apiParam {String} name Playlist name
     * @apiParam {String} description Playlist description
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *       "name": "name",
     *       "description": "description"
     *     }
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": true,
     *       "body": {
     *          "message": "Playlist was successfully modified"
     *       }
     *     }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400 Bad Request
     *     {
     *       "success": false,
     *       "body": {
     *          "message": "Empty data"
     *       }
     *     }
     */
    public function modifyPlaylist(Playlist $playlist, array $data): JsonResponse
    {
        try {
            $playlist = $this->playlistService->modifyPlaylist($playlist, $data);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'body' => [
                    'message' => $e->getMessage(),
                ],
            ], Response::HTTP_BAD_REQUEST);
        }

        if (isset($playlist['errors'])) {
            return new JsonResponse([
                'success' => false,
                'body' => [
                    'message' => $playlist['errors'],
                ],
            ], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([
            'success' => true,
            'body' => [
                'message' => 'Playlist was successfully modified',
            ],
        ]);
    }

    /**
     * @api {DELETE} /backend/api/playlists/:id Delete Playlist
     * @apiName DeletePlaylist
     * @apiGroup Playlists
     *
     * @apiParam  {id} id Playlist id
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": true,
     *       "body": {
     *          "message": "Playlist was successfully deleted"
     *       }
     *     }
     */
    public function deletePlaylist(Playlist $playlist): JsonResponse
    {
        $this->playlistService->deletePlaylist($playlist);

        return new JsonResponse([
            'success' => true,
            'body' => [
                'message' => 'Playlist was successfully deleted',
            ],
        ]);
    }

    /**
     * @api {POST} /api/backend/playlists/addtrack Add track
     * @apiName AddTrack
     * @apiGroup Playlists
     *
     * @apiParam {number} playlist_id Playlist id
     * @apiParam {number} track_id Track id
     *
     *  @apiParamExample {json} Request-Example:
     *     {
     *       "playlist_id": 1,
     *       "track_id": 1
     *     }
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *
     *     {
     *       "success": true,
     *       "body": "Track successfully added"
     *     }
     *
     * @apiError ThisTrackHasAlreadyBeenAddedToThisPlaylist This track has already been added to this playlist
     *
     * @apiErrorExample Error-Response
     *     HTTP/1.1 400 Bad request
     * {
     *   "success": false,
     *   "body": "This track has already been added to this playlist"
     * }
     *
     * @apiError TrackHasNotBeenAdded Track has not been added
     *
     * @apiErrorExample Error-Response
     *     HTTP/1.1 400 Bad request
     * {
     *   "success": false,
     *   "body": "Track has not been added"
     * }
     *
     */
    public function addTrack(Request $request): JsonResponse
    {
        $playlistsTracks = new PlaylistsTracks();

        $data = json_decode($request->getContent(), true);

        if (
            $this->entityManager->getRepository(PlaylistsTracks::class)
            ->existPlaylistsTracks($data['playlist_id'], $data['track_id'])
        ) {
            return new JsonResponse(
                [
                'success' => false,
                'body' => 'This track has already been added to this playlist'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        if (!is_numeric($data['playlist_id']) || !is_numeric($data['track_id'])) {
            return new JsonResponse(
                ['success' => false, 'body' => 'Track hasn`t been added'],
                Response::HTTP_BAD_REQUEST
            );
        }

        $playlistsTracks->setPlaylistId($data['playlist_id']);
        $playlistsTracks->setTrackId($data['track_id']);

        $this->entityManager->persist($playlistsTracks);
        $this->entityManager->flush();

        return new JsonResponse(['success' => true, 'body' => 'Track successfully added']);
    }
}
