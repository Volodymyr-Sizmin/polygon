<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\PlaylistsTracks;
use App\Interfaces\Playlist\PlaylistServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    private PlaylistServiceInterface $playlist;

    public function __construct(PlaylistServiceInterface $playlistServiceInterface)
    {
        $this->playlist = $playlistServiceInterface;
    }

    /**
     * @api {GET} /backend/api/playlists Index Playlist
     * @apiName Index
     * @apiGroup Playlists
     *
     * @apiSuccess (200) {Boolean} succes Should be true
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
        return JsonResponse::fromJsonString($this->serializeJson($this->playlist->indexService()));
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
     */
    public function createPlaylist(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $playlist = new Playlist();

        $data = json_decode($request->getContent(), true);

        $playlist->setName(isset($data["name"]) ? $data["name"] : $playlist->getName());
        $playlist->setDescription(isset($data["description"]) ? $data["description"] : $playlist->getDescription());
        $playlist->setCreatedAt(new \DateTimeImmutable());
        $playlist->setUpdatedAt(new \DateTimeImmutable());

        $entityManager->persist($playlist);
        $entityManager->flush();

        return JsonResponse::fromJsonString($this->serializeJson($playlist), Response::HTTP_CREATED);
    }

    /**
     *
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
     *
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
     *       "body": "Playlist successfully modified"
     *     }
     */
    public function modifyPlaylist(Playlist $playlist, Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);
        $playlist->setName(isset($data["name"]) ? $data["name"] : $playlist->getName());
        $playlist->setDescription(isset($data["description"]) ? $data["description"] : $playlist->getDescription());
        $playlist->setUpdatedAt(new \DateTimeImmutable());

        $entityManager->persist($playlist);
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'playlist' => [
            'name' => $playlist->getName(),
            'description' => $playlist->getDescription(),
            'updatedAt' => $playlist->getCreatedAt()
        ]]);
    }

    /**
     *
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
     *       "body": "Playlist successfully deleted"
     *     }
     */
    public function deletePlaylist(Playlist $playlist): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($playlist);
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'body' => 'Playlist successfully deleted']);
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
     *     HTTP/1.1 Not Found
     * {
     *   "success": false,
     *   "body": "This track has already been added to this playlist"
     * }
     *
     * @apiError TrackHasNotBeenAdded Track has not been added
     *
     * @apiErrorExample Error-Response
     *     HTTP/1.1 Not Found
     * {
     *   "success": false,
     *   "body": "Track has not been added"
     * }
     *
     */
    public function addTrack(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $playlistsTracks = new PlaylistsTracks();

        $data = json_decode($request->getContent(), true);

        if (
            $entityManager->getRepository(PlaylistsTracks::class)
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

        $entityManager->persist($playlistsTracks);
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'body' => 'Track successfully added']);
    }
}
