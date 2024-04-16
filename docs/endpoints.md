# Endpoints

-   [Endpoints](#endpoints)
    -   [Users](#users)
        -   [`POST` - /api/login](#post---apilogin)
            -   [Headers](#headers)
            -   [Payload](#payload)
            -   [Data](#data)
        -   [`POST` - /api/logout](#post---apilogout)
            -   [Headers](#headers-1)
            -   [Payload](#payload-1)
    -   [Contacts](#contacts)
        -   [`GET` - /api/contacts](#get---apicontacts)
            -   [Headers](#headers-2)
            -   [Pagination's data \[^1\]](#paginations-data-1)
        -   [`GET` - /api/contacts/{id}](#get---apicontactsid)
            -   [Headers](#headers-3)
            -   [Data](#data-1)
        -   [`POST` - /api/contacts](#post---apicontacts)
            -   [Headers](#headers-4)
            -   [Payload](#payload-2)
        -   [`PUT` - /api/contacts/{id}](#put---apicontactsid)
            -   [Headers](#headers-5)
            -   [Payload](#payload-3)
        -   [`DELETE` - /api/contacts/{id}](#delete---apicontactsid)
            -   [Headers](#headers-6)
            -   [Payload](#payload-4)
    -   [Deals](#deals)
        -   [`GET` - /api/deals](#get---apideals)
            -   [Headers](#headers-7)
            -   [Pagination's data \[^1\]](#paginations-data-1-1)
        -   [`GET` - /api/deals/{id}](#get---apidealsid)
            -   [Headers](#headers-8)
            -   [Data](#data-2)
        -   [`POST` - /api/deals](#post---apideals)
            -   [Headers](#headers-9)
            -   [Payload](#payload-5)
        -   [`PUT` - /api/deals/{id}](#put---apidealsid)
            -   [Headers](#headers-10)
            -   [Payload](#payload-6)
        -   [`DELETE` - /api/deals/{id}](#delete---apidealsid)
            -   [Headers](#headers-11)
            -   [Payload](#payload-7)
    -   [Interests](#interests)
        -   [`GET` - /api/interests](#get---apiinterests)
            -   [Headers](#headers-12)
            -   [Collaction's Data \[^2\]](#collactions-data-2)
        -   [`POST` - /api/interests](#post---apiinterests)
            -   [Headers](#headers-13)
            -   [Payload](#payload-8)
    -   [Tags](#tags)
        -   [`GET` - /api/tags](#get---apitags)
            -   [Headers](#headers-14)
            -   [Collaction's Data \[^2\]](#collactions-data-2-1)
        -   [`POST` - /api/tags](#post---apitags)
            -   [Headers](#headers-15)
            -   [Payload](#payload-9)
    -   [Locations](#locations)
        -   [`GET` - /api/locations](#get---apilocations)
            -   [Headers](#headers-16)
            -   [Collaction's Data \[^2\]](#collactions-data-2-2)
        -   [`POST` - /api/locations](#post---apilocations)
            -   [Headers](#headers-17)
            -   [Payload](#payload-10)

## Users

### `POST` - /api/login

#### Headers

`Accept` : `application/json`

#### Payload

| Field    | Required | rules                    |
| -------- | -------- | ------------------------ |
| username | ✔        | <ul><li>String</li></ul> |
| password | ✔        | <ul><li>String</li></ul> |

#### Data

-   token

### `POST` - /api/logout

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Payload

No payload requierd.

## Contacts

### `GET` - /api/contacts

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Pagination's data [^1]

-   id
-   name
-   phone
-   social_media_links
-   email
-   location_id
-   birth_date
-   location
-   interest_ids

### `GET` - /api/contacts/{id}

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Data

-   id
-   name
-   phone
-   social_media_links
-   email
-   location_id
-   birth_date
-   interest_ids

### `POST` - /api/contacts

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Payload

| Field              | Required | rules                                                                                              |
| ------------------ | -------- | -------------------------------------------------------------------------------------------------- |
| name               | ✔        | <ul><li>Contain letters and white space only</li><li>Max length is 255</li></ul>                   |
| phone              | ✔        | <ul><li>Contain numbers only</li><li>must have 9 digits</li><li>Must be unique</li></ul>           |
| email              | ✔        | <ul><li>Email</li><li>Must be unique</li><li>Max length is 255</li></ul>                           |
| social_media_links |          | <ul><li>Json string</li><li>May be unpresent in the payload</li></ul>                              |
| location_id        |          | <ul><li>Number</li><li>Exists in locations table</li><li>May be unpresent in the payload</li></ul> |
| birth_date         |          | <ul><li>Date</li><li>Format : Y-m-d</li><li>May be unpresent in the payload</li></ul>              |
| interest_ids       |          | <ul><li>present</li><li>Array</li></ul>                                                            |
| interest_ids.\*    |          | <ul><li>Number</li><li>Exists in interests table</li></ul>                                         |

### `PUT` - /api/contacts/{id}

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Payload

| Field              | Required | rules                                                                                              |
| ------------------ | -------- | -------------------------------------------------------------------------------------------------- |
| name               | ✔        | <ul><li>Contain letters and white space only</li><li>Max length is 255</li></ul>                   |
| phone              | ✔        | <ul><li>Contain numbers only</li><li>must have 9 digits</li><li>Must be unique</li></ul>           |
| email              | ✔        | <ul><li>Email</li><li>Must be unique</li><li>Max length is 255</li></ul>                           |
| social_media_links |          | <ul><li>Json string</li><li>May be unpresent in the payload</li></ul>                              |
| location_id        |          | <ul><li>Number</li><li>Exists in locations table</li><li>May be unpresent in the payload</li></ul> |
| birth_date         |          | <ul><li>Date</li><li>Format : Y-m-d</li><li>May be unpresent in the payload</li></ul>              |
| interest_ids       |          | <ul><li>present</li><li>Array</li></ul>                                                            |
| interest_ids.\*    |          | <ul><li>Number</li><li>Exists in interests table</li></ul>                                         |

### `DELETE` - /api/contacts/{id}

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Payload

No payload requierd.

## Deals

### `GET` - /api/deals

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Pagination's data [^1]

-   id
-   heading
-   description
-   datetime
-   is_annual
-   image
-   interest_ids
-   tag_ids

### `GET` - /api/deals/{id}

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Data

-   id
-   heading
-   description
-   datetime
-   is_annual
-   image
-   tag_ids
-   interest_ids

### `POST` - /api/deals

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Payload

| Field           | Required | Default | rules                                                             |
| --------------- | -------- | ------- | ----------------------------------------------------------------- |
| heading         | ✔        |         | <ul><li>String</li><li>Max length is 255</li></ul>                |
| description     | ✔        |         | <ul><li>String</li></ul>                                          |
| datetime        | ✔        |         | <ul><li>Date</li><li>Format : Y-m-d H:i:s</li></ul>               |
| is_annual       |          | `false` | <ul><li>Boolean</li><li>May be unpresent in the payload</li></ul> |
| image           |          |         | <ul><li>String</li><li>May be unpresent in the payload</li></ul>  |
| interest_ids    |          |         | <ul><li>present</li><li>Array</li></ul>                           |
| interest_ids.\* |          |         | <ul><li>Number</li><li>Exists in interests table</li></ul>        |
| tag_ids         |          |         | <ul><li>present</li><li>Array</li></ul>                           |
| tag_ids.\*      |          |         | <ul><li>Number</li><li>Exists in tags table</li></ul>             |

### `PUT` - /api/deals/{id}

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Payload

| Field           | Required | rules                                                             |
| --------------- | -------- | ----------------------------------------------------------------- |
| heading         | ✔        | <ul><li>String</li><li>Max length is 255</li></ul>                |
| description     | ✔        | <ul><li>String</li></ul>                                          |
| datetime        | ✔        | <ul><li>Date</li><li>Format : Y-m-d H:i:s</li></ul>               |
| is_annual       |          | <ul><li>Boolean</li><li>May be unpresent in the payload</li></ul> |
| image           |          | <ul><li>String</li><li>May be unpresent in the payload</li></ul>  |
| interest_ids    |          | <ul><li>present</li><li>Array</li></ul>                           |
| interest_ids.\* |          | <ul><li>Number</li><li>Exists in interests table</li></ul>        |
| tag_ids         |          | <ul><li>present</li><li>Array</li></ul>                           |
| tag_ids.\*      |          | <ul><li>Number</li><li>Exists in tags table</li></ul>             |

### `DELETE` - /api/deals/{id}

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Payload

No payload requierd.

## Interests

### `GET` - /api/interests

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Collaction's Data [^2]

-   id
-   name

### `POST` - /api/interests

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Payload

| Field | Required | rules                                                                     |
| ----- | -------- | ------------------------------------------------------------------------- |
| name  | ✔        | <ul><li>String</li><li>Max length is 255</li><li>Must be unique</li></ul> |

## Tags

### `GET` - /api/tags

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Collaction's Data [^2]

-   id
-   name

### `POST` - /api/tags

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Payload

| Field | Required | rules                                                                     |
| ----- | -------- | ------------------------------------------------------------------------- |
| name  | ✔        | <ul><li>String</li><li>Max length is 255</li><li>Must be unique</li></ul> |

## Locations

### `GET` - /api/locations

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Collaction's Data [^2]

-   id
-   name

### `POST` - /api/locations

#### Headers

`Accept` : `application/json`

`Authorization` : `Bearer <Token>`

#### Payload

| Field | Required | rules                                                                     |
| ----- | -------- | ------------------------------------------------------------------------- |
| name  | ✔        | <ul><li>String</li><li>Max length is 255</li><li>Must be unique</li></ul> |

[^1]: The data in the key `data` in laravel pagination.
[^2]: The data in the key `data` in a collaction.
