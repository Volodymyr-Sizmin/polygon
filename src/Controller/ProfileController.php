<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\City;
use App\Entity\Country;
use App\Exception\FileUploadException;
use App\Service\FileUploader;
use App\Service\ProfileService;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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
 */
class ProfileController extends AbstractController
{
    private $security;
    private $profileService;

    public function __construct(Security $security, ProfileService $profileService)
    {
        $this->security = $security;
        $this->profileService = $profileService;
    }

    /**
     * @api {post} /backend/api/profile/about/photo Upload Profile Photo
     * @apiName PostApiUploadProfilePhoto
     * @apiGroup Profile
     *
     * @apiBody {File} photo
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     * @apiSuccess (200) {String} body.message Success message
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "success": "true",
     *       "body": {
     *           "message":"Profile photo was successfully uploaded."
     *       }
     *     }
     *
     * @apiError {Boolean} success Should be false
     * @apiError {JSON} body Error parameters
     * @apiError {String} body.message Error message
     * @apiErrorExample {json}  Empty json request
     *     HTTP/1.1 400
     *     {
     *       "success": "false",
     *       "body": {
     *           "message": "An error occured during file upload."
     *       }
     *     }
     */
    public function uploadProfilePhoto(Request $request, FileUploader $fileUploader): Response
    {
        $profilePhoto = $request->files->get('photo');

        $validateProfilePhoto = $this->profileService->validateProfilePhoto($profilePhoto);
        if (isset($validateProfilePhoto['error'])) {
            return new JsonResponse([
                'success' => false,
                'body' => [
                    'error' => $validateProfilePhoto['error']
                ]
            ], Response::HTTP_CONFLICT);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => 'b.astapau@andersenlab.com']);

        $uploadProfilePhoto = $this->profileService->uploadProfilePhoto($user, $profilePhoto);
        if (isset($uploadProfilePhoto['error'])) {
            return new JsonResponse([
                'success' => false,
                'body' => [
                    'error' => $uploadProfilePhoto['error']
                ]
            ], Response::HTTP_CONFLICT);
        }

        return new JsonResponse([
            'success' => true,
            'body' => [
                'message' => 'Profile photo was successfully uploaded.'
            ]
        ], 201);
    }

    /**
     * @api {get} /backend/api/profile/about/info User info
     * @apiName GetApiProfileAboutInfo
     * @apiGroup Profile
     *
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     * @apiSuccess (200) {String} body.message Success message
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *        "success": true,
     *        "user": {
     *           "id": id,
     *           "firstName": "firstName",
     *           "lastName": "lastName",
     *           "userName": "userName",
     *           "country": "country",
     *           "city": "city",
     *           "email": "email",
     *           "phone": "phone"
     *        }
     *      }
     *
     * @apiError {Boolean} success Should be false
     * @apiError {JSON} body Error parameters
     * @apiError {String} body.message Error message
     * @apiErrorExample {json} Access denied
     *  HTTP/1.1 403
     *     {
     *          "success": false,
     *          "body": {
     *              "message": "Access denied"
     *          }
     *      }
     *
     */

    public function showUserInfo(): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Access denied'
                    ]
                ], 
                Response::HTTP_UNAUTHORIZED
            );
        }
        
        return new JsonResponse(
            [
                'success' => true,
                'user' => [
                    'id' => $user->getId(),
                    'firstName' => $user->getFirstName(),
                    'lastName' => $user->getLastName(),
                    'userName' => $user->getUserName(),
                    'country' => $user->getCity() ? $user->getCity()->getCountry()->getName() : null,
                    'city' => $user->getCity() ? $user->getCity()->getName() : null,
                    'email' => $user->getEmail() ? $user->getEmail() : null,
                    'phone' => $user->getPhone() ? $user->getPhone() : null
                ]
            ], 
            Response::HTTP_OK
        );
    }

    private function validateName($name): ?string
    {
        $length = mb_strlen($name);
        if ($length < 2) {
            return 'Must be 2 characters or more';
        }
        if ($length > 60) {
            return 'Must be 60 characters or less';
        }
        $pattern = "/^[a-zA-Zа-яА-Я0-9\s!@#$%^&`*()_\-=+;:'\x22?,<>[\]{}\\\|\/№!~]+\.{0,1}[a-zA-Zа-яА-Я0-9\s!@#$%^&*()_\-=+;:'\x22?,<>[\]{}\\\|\/№!~]+$/u";
        if (!preg_match($pattern, $name)) {
            return 'Can contain letters, numbers, !@#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, and one dot not first or last';
        }
        return null;
    }

    private function validatePhone($phone): ?string
    {
        $length = mb_strlen($phone);
        if ($length < 7) {
            return 'must be 7 characters or more';
        }
        if ($length > 15) {
            return 'must be 15 characters or less';
        }
        $pattern = "/^\+[0-9]+$/";
        if (!preg_match($pattern, $phone)) {
            return 'can containe first plus symbol and numbers';
        }
        return null;
    }

    /**
     * @api {put} /backend/api/profile/about/update:id Update user info
     * @apiName PutApiProfileAboutUpdate
     * @apiGroup Profile
     *
     * @apiParam {Number} id Id of the user that we change (part of url)
     * @apiBody {String} [firstName]      Optional firstName of the User
     * @apiBody {String} [lastName]       Optional lastName of the User
     * @apiBody {String} [userName]       Optional userName of the User
     * @apiBody {String} [country]        Optional country of the User
     * @apiBody {String} [city]           Optional city of the User
     * @apiBody {String} [phone]          Optional phone of the User
     *
     * @apiSuccess (201) {Boolean} success Should be true
     * @apiSuccess (201) {JSON} body Response body
     * @apiSuccess (201) {String} body.message Success message
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 201 CREATED
     *     {
     *       "success": true,
     *       "user": {
     *            "firstName": "firstName",
     *            "lastName": "lastName",
     *            "userName": "userName",
     *            "country": "country",
     *            "city": "city",
     *            "phone": "phone"
     *       }
     *     }
     * 
     * @apiError {Boolean} success Should be false
     * @apiError {JSON} body Error parameters
     * @apiError {String} body.message Error message
     * @apiErrorExample {json} Access denied
     *  HTTP/1.1 401
     *     {
     *          "success": false,
     *          "body": {
     *              "message": "Access denied"
     *          }
     *      }
     * @apiErrorExample {json} Not allowed to change
     *  HTTP/1.1 403
     *     {
     *          "success": false,
     *          "body": {
     *              "message": "You are not allowed to change this user`s data"
     *          }
     *      }
     * @apiErrorExample {json} Phone already used
     *  HTTP/1.1 403
     *      {
     *          "success": false,
     *          "body": {
     *              "message": "Phone already used"
     *          }
     *      }
     * @apiErrorExample {json} Name validation less than 2 characters
     *  HTTP/1.1 403
     *      {
     *          "success": false,
     *          "body": {
     *              "name": "name",
     *              "message": "Must be 2 characters or more"
     *          }
     *      }
     * @apiErrorExample {json} Name validation more than 60 characters
     *  HTTP/1.1 403
     *      {
     *          "success": false,
     *          "body": {
     *              "name": "name",
     *              "message": "Must be 60 characters or less"
     *          }
     *      }
     * @apiErrorExample {json} Name validation pattern
     *  HTTP/1.1 403
     *      {
     *          "success": false,
     *          "body": {
     *              "name": "name",
     *              "message": "Can contain letters, numbers, !@#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,' symbols, and one dot not first or last"
     *          }
     *      }
     * @apiErrorExample {json} Phone validation less than 7 characters
     *  HTTP/1.1 403
     *      {
     *          "success": false,
     *          "body": {
     *              "message": "Phone must be 7 characters or more"
     *          }
     *      }
     * @apiErrorExample {json} Phone validation more than 15 characters
     *  HTTP/1.1 403
     *      {
     *          "success": false,
     *          "body": {
     *              "message": "Phone must be 15 characters or less"
     *          }
     *      }
     * @apiErrorExample {json} Phone validation pattern
     *  HTTP/1.1 403
     *      {
     *          "success": false,
     *          "body": {
     *              "message": "Phone can containe first plus symbol and numbers"
     *          }
     *      }
     * @apiErrorExample {json} Country
     *  HTTP/1.1 403
     *      {
     *          "success": false,
     *          "body": {
     *              "message": "You have to choose right country",
     *              "countries": [list of countries]
     *          }
     *      }
     * @apiErrorExample {json} City
     *  HTTP/1.1 403
     *      {
     *          "success": false,
     *          "body": {
     *              "message": "You have to choose right city",
     *              "cities": [list of cities]
     *          }
     *      }
     *
     */

    public function updateUserInfo(User $user, Request $request): JsonResponse
    {
        $currentUser = $this->getUser();
        if (!$currentUser) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Access denied'
                    ]
                ], 
                Response::HTTP_UNAUTHORIZED
            );
        }
        if ($currentUser->getId() != $user->getId()) {
            return new JsonResponse (
                [
                    'success' => false,
                    'body' => [
                        'message' => 'You are not allowed to change this user`s data'
                    ]
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data["firstName"])) {
            $errorString = $this->validateName($data["firstName"]);
            if ($errorString) {
                return new JsonResponse (
                    [
                        'success' => false,
                        'body' => [
                            'name' => 'firstName',
                            'message' => $errorString
                        ]
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
        }
        if (isset($data["lastName"])) {
            $errorString = $this->validateName($data["lastName"]);
            if ($errorString) {
                return new JsonResponse (
                    [
                        'success' => false,
                        'body' => [
                            'name' => 'lastName',
                            'message' => $errorString
                        ]
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
        }
        if (isset($data["userName"])) {
            $errorString = $this->validateName($data["userName"]);
            if ($errorString) {
                return new JsonResponse (
                    [
                        'success' => false,
                        'body' => [
                            'name' => 'userName',
                            'message' => $errorString
                        ]
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
        }

        $user->setFirstName(isset($data["firstName"]) ? $data["firstName"] : $user->getFirstName());
        $user->setLastName(isset($data["lastName"]) ? $data["lastName"] : $user->getLastName());
        $user->setUserName(isset($data["userName"]) ? $data["userName"] : $user->getUsername());

        if (isset($data["phone"])) {
            $errorString = $this->validatePhone($data["phone"]);
            if ($errorString) {
                return new JsonResponse (
                    [
                        'success' => false,
                        'body' => [
                            'message' => 'Phone ' . $errorString
                        ]
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
        }

        if (isset($data["phone"])) {
            $existUserPhone = $this->getDoctrine()->getRepository(User::class)->findOneBy(["phone" => $data["phone"]]);
            $existPhone = isset($existUserPhone) ? $existUserPhone->getPhone() : null;
            if (!$existPhone) {
                $user->setPhone($data["phone"]);
            }
            if ($existPhone == $user->getPhone()) {
                $user->getPhone();
            }
            if ($existPhone != $user->getPhone() && $existPhone != null) {
                return new JsonResponse (
                    [
                        'success' => false,
                        'body' => [
                            'message' => 'Phone already used'
                        ]
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
        }

        if (isset($data["country"]) && empty($data["city"])) {
            $country = $this->getDoctrine()->getRepository(Country::class)->findOneby(["name" => $data["country"]]);
            if (!$country) {
                $countries = $this->getDoctrine()->getRepository(Country::class)->findAll();
                $countryNames = [];
                foreach ($countries as $country) {
                    $countryNames[] = $country->getName();
                }
                return new JsonResponse (
                    [
                        'success' => false,
                        'body' => [
                            'message' => 'You have to choose right country',
                            'countries' => $countryNames
                        ]
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
            else {
                $cities = $country->getCities();
                $cityNames = [];
                foreach ($cities as $city) {
                    $cityNames[] = $city->getName();
                }
                return new JsonResponse (
                    [
                        'success' => false,
                        'body' => [
                            'message' => 'You have to choose right city',
                            'cities' => $cityNames
                        ]
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
        }
        
        if (isset($data["city"])) {
            $city = $this->getDoctrine()->getRepository(City::class)->findOneby(["name" => $data["city"]]);
            if (!$city) {
                $cities = $this->getDoctrine()->getRepository(City::class)->findAll();
                $cityNames = [];
                foreach ($cities as $city) {
                    $cityNames[] = $city->getName();
                }
                return new JsonResponse (
                    [
                        'success' => false,
                        'body' => [
                            'message' => 'You have to choose right city',
                            'cities' => $cityNames
                        ]
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
            else {
                $user->setCity($city);
            }
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse (
            [
                'success' => true, 
                'user' => [
                    'firstName' => $user->getFirstName(),
                    'lastName' => $user->getLastName(),
                    'userName' => $user->getUserName(),
                    'country' => $user->getCity() ? $user->getCity()->getCountry()->getName() : null,
                    'city' => $user->getCity() ? $user->getCity()->getName() : null,
                    'phone' => $user->getPhone() ? $user->getPhone() : null
                ]
            ], 
            Response::HTTP_CREATED
        );
    }
}
