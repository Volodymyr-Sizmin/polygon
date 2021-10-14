/**
 * @api {post} /backend/api/registration/email Email registarion
 * @apiVersion 0.0.0
 * @apiName PostApiRegistationEmail
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
 * @apiName PostApiRegistationPhone
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