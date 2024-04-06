# Endpoints

## `POST` - /api/login

### Headers

`Accept` : `application/json`

### Payload

| Field    | rules                                     |
| -------- | ----------------------------------------- |
| username | <ul><li>requierd</li><li>String</li></ul> |
| password | <ul><li>requierd</li><li>String</li></ul> |

### Data

-   token

## `POST` - /api/logout

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Payload

No payload requierd.

## `GET` - /api/contacts

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Pagination's data [^1]

-   id
-   name
-   phone
-   social_media_links
-   email
-   location_id
-   birth_date
-   location

## `GET` - /api/contacts/{id}

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Data

-   id
-   name
-   phone
-   social_media_links
-   email
-   location_id
-   birth_date
-   interest_ids

## `POST` - /api/contacts

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Payload

| Field              | rules                                                                                             |
| ------------------ | ------------------------------------------------------------------------------------------------- |
| name               | <ul><li>Requierd</li><li>Contain letters and white space only</li><li>Max length is 255</li></ul> |
| phone              | <ul><li>Contain numbers only</li><li>must have 9 digits</li><li>Must be unique</li></ul>          |
| social_media_links | <ul><li>Json string</li><li>May be unpresent in the payload</li></ul>                             |
| email              | <ul><li>Email</li><li>Must be unique</li><li>Max length is 255</li></ul>                          |
| location_id        | <ul><li>Requierd</li><li>Number</li><li>Exists in locations table</li></ul>                       |
| birth_date           | <ul><li>Requierd</li><li>Date</li><li>Format : Y-m-d</li></ul>                                    |
| interest_ids       | <ul><li>present</li><li>Array</li></ul>                                                           |
| interest_ids.\*    | <ul><li>Number</li><li>Exists in interests table</li></ul>                                        |

## `PUT` - /api/contacts/{id}

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Payload

| Field              | rules                                                                                             |
| ------------------ | ------------------------------------------------------------------------------------------------- |
| name               | <ul><li>Requierd</li><li>Contain letters and white space only</li><li>Max length is 255</li></ul> |
| phone              | <ul><li>Contain numbers only</li><li>must have 9 digits</li><li>Must be unique</li></ul>          |
| social_media_links | <ul><li>Json string</li><li>May be unpresent in the payload</li></ul>                             |
| email              | <ul><li>Email</li><li>Must be unique</li><li>Max length is 255</li></ul>                          |
| location_id        | <ul><li>Requierd</li><li>Number</li><li>Exists in locations table</li></ul>                       |
| birth_date           | <ul><li>Requierd</li><li>Date</li><li>Format : Y-m-d</li></ul>                                    |
| interest_ids       | <ul><li>present</li><li>Array</li></ul>                                                           |
| interest_ids.\*    | <ul><li>Number</li><li>Exists in interests table</li></ul>                                        |

## `DELETE` - /api/contacts/{id}

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Payload

No payload requierd.

## `GET` - /api/deals

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Pagination's data [^1]

-   id
-   heading
-   description
-   datetime
-   is_annual
-   image

## `GET` - /api/deals/{id}

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Data

-   id
-   heading
-   description
-   datetime
-   is_annual
-   image
-   tag_ids
-   interest_ids

## `POST` - /api/deals

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Payload

| Field           | rules                                                                |
| --------------- | -------------------------------------------------------------------- |
| heading         | <ul><li>Requierd</li><li>String</li><li>Max length is 255</li></ul>  |
| description     | <ul><li>Requierd</li><li>String</li></ul>                            |
| datetime        | <ul><li>Requierd</li><li>Date</li><li>Format : Y-m-d H:i:s</li></ul> |
| is_annual          | <ul><li>Requierd</li><li>Boolean</li></ul>                           |
| image           | <ul><li>String</li></ul>                                             |
| interest_ids    | <ul><li>present</li><li>Array</li></ul>                              |
| interest_ids.\* | <ul><li>Number</li><li>Exists in interests table</li></ul>           |
| tag_ids         | <ul><li>present</li><li>Array</li></ul>                              |
| tag_ids.\*      | <ul><li>Number</li><li>Exists in tags table</li></ul>                |

## `PUT` - /api/deals/{id}

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Payload

| Field           | rules                                                                |
| --------------- | -------------------------------------------------------------------- |
| heading         | <ul><li>Requierd</li><li>String</li><li>Max length is 255</li></ul>  |
| description     | <ul><li>Requierd</li><li>String</li></ul>                            |
| datetime        | <ul><li>Requierd</li><li>Date</li><li>Format : Y-m-d H:i:s</li></ul> |
| is_annual          | <ul><li>Requierd</li><li>Boolean</li></ul>                           |
| image           | <ul><li>String</li></ul>                                             |
| interest_ids    | <ul><li>present</li><li>Array</li></ul>                              |
| interest_ids.\* | <ul><li>Number</li><li>Exists in interests table</li></ul>           |
| tag_ids         | <ul><li>present</li><li>Array</li></ul>                              |
| tag_ids.\*      | <ul><li>Number</li><li>Exists in tags table</li></ul>                |

## `DELETE` - /api/deals/{id}

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Payload

No payload requierd.

## `GET` - /api/interests

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Collaction's Data [^2]

-   id
-   name

## `POST` - /api/interests

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Payload

| Field | rules                                                                                      |
| ----- | ------------------------------------------------------------------------------------------ |
| name  | <ul><li>Requierd</li><li>String</li><li>Max length is 255</li><li>Must be unique</li></ul> |

## `GET` - /api/tags

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Collaction's Data [^2]

-   id
-   name

## `POST` - /api/tags

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Payload

| Field | rules                                                                                      |
| ----- | ------------------------------------------------------------------------------------------ |
| name  | <ul><li>Requierd</li><li>String</li><li>Max length is 255</li><li>Must be unique</li></ul> |

## `GET` - /api/locations

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Collaction's Data [^2]

-   id
-   name

## `POST` - /api/locations

### Headers

`Accept` : `application/json` <br>
`Authorization` : `Bearer <Token>`

### Payload

| Field | rules                                                                                      |
| ----- | ------------------------------------------------------------------------------------------ |
| name  | <ul><li>Requierd</li><li>String</li><li>Max length is 255</li><li>Must be unique</li></ul> |

[^1]: The data in the key `data` in laravel pagination. <br>
[^2]: The data in the key `data` in a collaction.
