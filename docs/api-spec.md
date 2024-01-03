# Api Spesification

## User API

### Server
```
https://dyonestrankers-laravel-api.vercel.app/
```
| Endpoint | Method |
| --- | --- |
| /users | Post |
| /users/login | Post |
| /users/current | Get |
| /users/current | Patch |
| /users/logout | Delete |

See more information about [User Api](https://github.com/RifkyMuhamad/LaravelAPIGateway/blob/main/docs/user-api.json)

## Contact API

### Server
```
https://dyonestrankers-laravel-api.vercel.app/
```
| Endpoint | Method |
| --- | --- |
| /contacts | Post |
| /contacts | Get |
| /contacts/{id} | Put |
| /contacts/{id} | Get |
| /contacts/{id} | Delete |

See more information about [Contact Api](https://github.com/RifkyMuhamad/LaravelAPIGateway/blob/main/docs/contact-api.json)

## Address API

### Server
```
https://dyonestrankers-laravel-api.vercel.app/
```
| Endpoint | Method |
| --- | --- |
| /contacts/{idContact}/addresses | Post |
| /contacts/{idContact}/addresses | Get |
| /contacts/{idContact}/addresses/{idAddress} | Get |
| /contacts/{idContact}/addresses/{idAddress} | Put |
| /contacts/{idContact}/addresses/{idAddress} | Delete |

See more information about [Address Api](https://github.com/RifkyMuhamad/LaravelAPIGateway/blob/main/docs/address-api.json)
