/**
 * @api {post} /backend/api/registration/email Email registarion
 * @apiVersion 0.0.0
 * @apiName PostApiRegistrationEmail
 * @apiGroup Authentication
 *
 * @apiBody {String} firstName
 * @apiBody {String} lastName
 * @apiBody {String} userName
 * @apiBody {String} email
 * @apiBody {String} password
 * @apiBody {String} confirmPassword
 *
 * @apiSuccess (201) {Boolean} success Should be true
 * @apiSuccess (201) {JSON} body Response body
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 201 CREATED
 *     {
 *       "success": "true",
 *       "body": {}
 *     }
 *
 * @apiError (Empty Request) {Boolean} success Should be false
 * @apiError (Empty Request) {JSON} body Error parametrs
 * @apiError (Empty Request) {String} body.message Error message
 * @apiErrorExample {json}  Empty json request 
 *     HTTP/1.1 400
 *     {
 *       "success": "false",
 *       "body": {
 *           "message": "Empty input"
 *       }
 *     }
 * 
 * @apiError (Invalid Request) {Boolean} success Should be false
 * @apiError (Invalid Request) {JSON} body Error parametrs
 * @apiError (Invalid Request) {String} body.message Array of errors
 * @apiErrorExample {json} Empty input
 *     HTTP/1.1 400
 *     {
 *       "success": false,
 *       "body": {
 *           "message": {
 *               "email": "email can't be blank",
 *               "firstName": "first name can't be blank",
 *               "lastName": "last name can't be blank",
 *               "userName": "username can't be blank"
 *           }
 *       }
 *     }
 * @apiErrorExample {json} Invalid input
 *     HTTP/1.1 400
 *     {
 *       "success": false,
 *       "body": {
 *           "message": {
 *              "password": "passsword and confirm password don't match",
 *              "email": "\"1\" is not a valid email"
 *           }
 *       }
 *     }
 * @apiErrorExample {json} Email already used
 *     HTTP/1.1 400
 *     {
 *       "success": false,
 *       "body": {
 *           "message": {
 *               "email": "This value is already used."
 *           }
 *       }
 *     }
 */

/**
 * @api {post} /backend/api/registration/phone Phone registarion
 * @apiVersion 0.0.0
 * @apiName PostApiRegistrationPhone
 * @apiGroup Authentication
 *
 * @apiBody {String} firstName
 * @apiBody {String} lastName
 * @apiBody {String} userName
 * @apiBody {String} phone
 * @apiBody {String} password
 * @apiBody {String} confirmPassword
 *
 * @apiSuccess (201) {Boolean} success Should be true
 * @apiSuccess (201) {JSON} body Response body
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 201 CREATED
 *     {
 *       "success": "true",
 *       "body": {}
 *     }
 *
 * @apiError (Empty Request) {Boolean} success Should be false
 * @apiError (Empty Request) {JSON} body Error parametrs
 * @apiError (Empty Request) {String} body.message Error message
 * @apiErrorExample {json} Empty json request 
 *     HTTP/1.1 400
 *     {
 *       "success": "false",
 *       "body": {
 *           "message": "Empty input"
 *       }
 *     }
 * 
 * @apiError (Invalid Request) {Boolean} success Should be false
 * @apiError (Invalid Request) {JSON} body Error parametrs
 * @apiError (Invalid Request) {String} body.message Array of errors
 * @apiErrorExample {json} Empty input
 *     HTTP/1.1 400
 *     {
 *       "success": false,
 *       "body": {
 *           "message": {
 *               "email": "email can't be blank",
 *               "firstName": "first name can't be blank",
 *               "lastName": "last name can't be blank",
 *               "userName": "username can't be blank"
 *           }
 *       }
 *     }
 * @apiErrorExample {json} Invalid input
 *     HTTP/1.1 400
 *     {
 *       "success": false,
 *       "body": {
 *           "message": {
 *               "password": "passsword and confirm password don't match",
 *               "phone": "incorrect phone format",
 *           }
 *       }
 *     }
 * @apiErrorExample {json} Phone already used
 *     HTTP/1.1 400
 *     {
 *       "success": false,
 *       "body": {
 *           "message": {
 *               "phone": "This value is already used."
 *           }
 *       }
 *     }
 * 
 */

/**
 * @api {GET} /backend/verify/email/:url Email verification url
 * @apiVersion 0.0.0
 * @apiName GetVerificationUrl
 * @apiGroup Authentication
 *
 * @apiParam {String} url request token(part of url)
 *
 * @apiSuccess (200) {Boolean} success Should be true
 * @apiSuccess (200) {JSON} body Response body
 * @apiSuccess {String} body.email Email tht was connected to this verification request
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "success": "true",
 *       "body": { 
 *           "email": "b.astapau@andersenlab.com"
 *       }
 *     }
 *
 * @apiError {Boolean} success Should be false
 * @apiError {JSON} body Error parametrs
 * @apiError {String} body.message Error message
 * @apiErrorExample {json} Url doesn't exist:
 *     HTTP/1.1 404
 *     {
 *       "success": "false",
 *       "body": {
 *           "message": "not found"
 *       }
 *     }
 * @apiErrorExample {json} Request expired:
 *     HTTP/1.1 410
 *     {
 *       "success": "false",
 *       "body": {
 *           "message": "expired"
 *       }
 *     }
 * 
 */