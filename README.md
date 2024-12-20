BookingApi
==================================


# Need to run #

* run `docker compose -f docker-compose.yml up` to run docker container
* after docker up application run at `http://localhost:25000`
* first run on container php-fpm run command `composer install`
* after that on container php-fpm run command `php bin/console doctrine:schema:create` to prepare database schema
* and last on container php-fpm run command `php bin/console doctrine:fixtures:load --no-interaction` to prepare data of pre-availability 

# Endpoints #

* Booking period time
  * Endpoint: http://localhost:25000/api/booking
  * Method: POST
  * Request:
    * Parameters:
      * data: arrayObject
        * Parameters:
          * startDate: string
          * endDate: string
          * guests: int
    * Example:
      * ```{"data":[{"startDate":"21-12-2024","endDate":"22-12-2024","guests":1},{"startDate":"25-12-2024","endDate":"27-12-2024","guests":3}]}```
  * Response:
    * Parameters:
      * status: string
    * Example:
      * ```{"status": ok }```
  * Response:
    * Parameters:
      * error: string
    * Example:
      * ```{"error": "Not enough rooms available."}```
* Booking List
  * Endpoint: http://localhost:25000/api/reservation/list
  * Method: GET
  * Request:
    * Parameters:
      * startDate: string
      * endDate: string
    * Example:
      * ```?startDate=24-12-2024&endDate=28-12-2024```
  * Response:
    * Parameters:
      * data: array
        * Parameters:
          * id: string
          * startDate: string
          * endDate:string
          * bookedDays: array
            * Parameters:
              * id: string
              * data: string
  * Example:
    * ```{"data":[{"id":"288734a5-b2cf-4473-9e31-3f585257e66b","startDate":"2024-12-25","endDate":"2024-12-27","bookedDays":[{"id":"e2609f32-fda4-41e1-bc65-40b2d48fcf3e","date":"2024-12-27T00:00:00+00:00"},{"id":"ea9a19a0-a82f-4f6e-a049-d58e6c3c90c5","date":"2024-12-26T00:00:00+00:00"},{"id":"eda3cd05-5afb-4017-8734-933aafe3cabb","date":"2024-12-25T00:00:00+00:00"}]},{"id":"cd36d29a-d417-4d0a-b189-15eb16901614","startDate":"2024-12-25","endDate":"2024-12-27","bookedDays":[{"id":"335e60f3-ee52-414c-87d3-4d71bdc7d2d1","date":"2024-12-26T00:00:00+00:00"},{"id":"4591f910-a96f-423b-b5ce-52c21fc7fd40","date":"2024-12-27T00:00:00+00:00"},{"id":"c948a1d8-a270-4f6f-8981-90dc670f2dbb","date":"2024-12-25T00:00:00+00:00"}]},{"id":"cdc61f1c-e08f-4ea9-8e90-d5551d040bfe","startDate":"2024-12-25","endDate":"2024-12-27","bookedDays":[{"id":"1eb68ce9-0bf6-4f74-a560-b037119c0207","date":"2024-12-25T00:00:00+00:00"},{"id":"49868d37-ba75-446e-ab6c-f348b57a3a12","date":"2024-12-27T00:00:00+00:00"},{"id":"49e7e455-8b36-4c5a-b7b6-b5eada38dacf","date":"2024-12-26T00:00:00+00:00"}]}]}```