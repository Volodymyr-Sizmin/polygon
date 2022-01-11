<?php

namespace App\Controller;

use App\Entity\Track;
use App\Interfaces\MyTracklist\MyTracklistInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\SerializeController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @IgnoreAnnotation("apiName")
 * @IgnoreAnnotation("apiGroup")
 * @IgnoreAnnotation("apiParam")
 * @IgnoreAnnotation("apiParamExample")
 * @IgnoreAnnotation("apiSuccess")
 * @IgnoreAnnotation("apiSuccessExample")
 * @IgnoreAnnotation("apiError")
 * @IgnoreAnnotation("apiErrorExample")
 */
class BurgerController extends SerializeController
{
    private MyTracklistInterface $myTracklistInterface;

    public function __construct(MyTracklistInterface $myTracklistInterface)
    {
        $this->myTracklistInterface = $myTracklistInterface;
    }

    /**
     * @api {GET} /backend/api/burger/sharesong/{id} Share song
     * @apiName share_song
     * @apiGroup BURGER
     *
     * @apiParam {id} id Track id
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     * {
     * "success":true,
     * "path": {
     *           "track_path":"audio\/fd3a2bd0c4a7fbef2633ccde4885362c-61a24e3165fb8.mp3"
     *         }
     * }
     *
     * @apiError InvalidId Invalid id
     *
     * @apiErrorExample Error-Response
     *     HTTP/1.1 404 Not Found
     *     [
     *     {
     *       "success": false,
     *       "body": "Invalid id"
     *     }
     *     ]
     *
     * @apiError ThisTrackDoesNotFound This track does not found
     *
     * @apiErrorExample Error-Response
     *     HTTP/1.1 404 Not Found
     *    [
     *    {
     *      "success": false,
     *      "body": "This track does not found"
     *    }
     *    ]
     */
    public function shareSong($id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        if (!is_numeric($id) && $id < 0) {
            return new JsonResponse(['success' => false, 'body' => 'Invalid id'], Response::HTTP_BAD_REQUEST);
        }

        if (!$entityManager->getRepository(Track::class)->getTrackPath($id)) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => 'This track does not found'
                ],
                Response::HTTP_NOT_FOUND
            )
                ;
        }

        return new JsonResponse(['success' => true, 'path' => $entityManager
            ->getRepository(Track::class)
            ->getTrackPath($id)])
            ;
    }

    /**
     * @api {POST} /backend/api/burger/gotoartist Go to artist
     * @apiName go_to_artist
     * @apiGroup BURGER
     *
     * @apiParam {id} id Track id
     * @apiParamExample {json} Request-Example:
     *     {
     *       "id": 1
     *     }
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     * {
     *      "success":true,"information":[
     *          {
     *             "author":"Linnur",
     *             "title":"Sister",
     *             "album":"red",
     *             "cover":"image\/dfffffffffwrf4545rggggggg-4554544dg.png",
     *             "name":"12345"
     *          },
     *          {
     *            "author":"Linnur",
     *            "title":"Brother",
     *            "album":"red",
     *            "cover":"image\/f2812e00124f03ad20ba0eb74899db5c-61a24e315f41a.png",
     *            "name":"test"
     *          }
     *                              ]
     * }
     *
     * @apiError InvalidId Invalid id
     *
     * @apiErrorExample Error-Response
     *     HTTP/1.1 404 Not Found
     *     [
     *     {
     *       "success": false,
     *       "body": "Invalid id"
     *    }
     *    ]
     *
     * @apiError ThisArtistDoesNotFound This artist does not found
     *
     * @apiErrorExample Error-Response
     *     HTTP/1.1 404 Not Found
     *     [
     *     {
     *       "success": false,
     *       "body": "This track does not found"
     *    }
     *    ]
     */
    public function getArtist(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);

        if (!is_numeric($data['id']) && $data['id'] < 0) {
            return new JsonResponse(['success' => false, 'body' => 'Invalid id'], Response::HTTP_BAD_REQUEST);
        }

        if (!$entityManager->getRepository(Track::class)->getArtistData($data['id'])) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => 'This artist does not found'
                ],
                Response::HTTP_NOT_FOUND
            )
                ;
        }

         return new JsonResponse(['success' => true, 'information' => $entityManager
            ->getRepository(Track::class)
            ->getArtistData($data['id'])]);
    }

    /**
     * @api {GET} /backend/api/burger/addnextup/:id Add next up
     *
     * @apiName add_next_up
     * @apiGroup BURGER
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     * {
     *"id": 7,
     *"author": "deskot",
     *"title": "my live",
     *"album": null,
     *"type": "Music",
     *"genre": "Rock",
     *"cover": null,
     *"trackPath": "public",
     *"createdAt": {
     *   "timezone": {
     *       "name": "UTC",
     *       "transitions": [
     *           {
     *               "ts": -9223372036854775808,
     *               "time": "-292277022657-01-27T08:29:52+0000",
     *               "offset": 0,
     *               "isdst": false,
     *               "abbr": "UTC"
     *           }
     *       ],
     *       "location": {
     *           "country_code": "??",
     *           "latitude": 0,
     *           "longitude": 0,
     *           "comments": ""
     *       }
     *   },
     *   "offset": 0,
     *   "timestamp": 1637604470
     *},
     *"updatedAt": {
     *   "timezone": {
     *       "name": "UTC",
     *       "transitions": [
     *           {
     *               "ts": -9223372036854775808,
     *               "time": "-292277022657-01-27T08:29:52+0000",
     *               "offset": 0,
     *               "isdst": false,
     *               "abbr": "UTC"
     *           }
     *       ],
     *       "location": {
     *           "country_code": "??",
     *           "latitude": 0,
     *           "longitude": 0,
     *           "comments": ""
     *       }
     *   },
     *   "offset": 0,
     *   "timestamp": 1637604470
     *},
     *"playlistId": null
     *}
     *
     * @apiError InvalidId Invalid id
     *
     * @apiErrorExample Error-Response
     *     HTTP/1.1 404 Not Found
     *     [
     * {
     *   "success": false,
     *   "body": "Invalid id"
     * }
     *
     * @apiError ThisTrackDoesNotFound This track does not found
     *
     * @apiErrorExample Error-Response
     *     HTTP/1.1 404 Not Found
     *     [
     * {
     *   "success": false,
     *   "body": "This track does not found"
     * }
     *
     */
    public function addNextUp($id): JsonResponse
    {
        return JsonResponse::fromJsonString($this->serializeJson($this->myTracklistInterface->showService($id)));
    }

    /**
     * @api {POST} /backend/api/burger/gotoalbum Go to album
     * @apiName go_to_album
     * @apiGroup BURGER
     *
     * @apiParam {id} id Track id
     * @apiParamExample {json} Request-Example:
     *     {
     *       "id": 1
     *     }
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     * {
     *      "success":true,
     *      "path":[
     *                {
     *                 "author":"Linnur",
     *                 "title":"Brother",
     *                 "album":"red",
     *                 "cover":"image\/f2812e00124f03ad20ba0eb74899db5c-61a24e315f41a.png",
     *                 "track_path":"audio\/fd3a2bd0c4a7fbef2633ccde4885362c-61a24e3165fb8.mp3"
     *                },
     *                {
     *                 "author":"Linnur",
     *                 "title":"Sister",
     *                 "album":"red",
     *                 "cover":"image\/dfffffffffwrf4545rggggggg-4554544dg.png",
     *                 "track_path":"audio\/wdwmkjkh5ju4ht4h5kj4hn5kj3h4kj3h5kj3h-34n.mp3"
     * }
     *            ]
     *                }
     *
     * @apiError InvalidId Invalid id
     *
     * @apiErrorExample Error-Response
     *     HTTP/1.1 404 Not Found
     *     [
     * {
     *   "success": false,
     *   "body": "Invalid id"
     * }
     *
     * @apiError ThisAlbumDoesNotFound This album does not found
     *
     * @apiErrorExample Error-Response
     *     HTTP/1.1 404 Not Found
     *     [
     * {
     *   "success": false,
     *   "body": "This track does not found"
     * }
     */
    public function getAlbum(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);

        if (!is_numeric($data['id']) && $data['id'] < 0) {
            return new JsonResponse(['success' => false, 'body' => 'Invalid id'], Response::HTTP_BAD_REQUEST);
        }

        if (!$entityManager->getRepository(Track::class)->getArtistData($data['id'])) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => 'This album does not found'
                ],
                Response::HTTP_NOT_FOUND
            )
                ;
        }

         return new JsonResponse(['success' => true, 'path' => $entityManager
            ->getRepository(Track::class)
            ->getAlbumSong($data['id'])])
             ;
    }
}
