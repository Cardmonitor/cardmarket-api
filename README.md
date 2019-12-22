# Wrapper for Cardmarket.com API

[Cardmonitor](https://www.cardmonitor.de)

[Cardmarket](https://www.cardmarket.com)

[API Documentation](https://api.cardmarket.com/ws/documentation/API_2.0:Main_Page)


## Installation

You can install the package via composer:

```
composer require cardmonitor/cardmarket-api
```

## Configuration

```php
$config = [
    'app_token' => 'app_token',
    'app_secret' => 'app_secret',
    'access_token' => 'access_token',
    'access_token_secret' => 'access_token_secret',
    'debug' => false,
    'url' => Cardmonitor\Cardmarket\Api::URL_API
];

$api = new Cardmonitor\Cardmarket\Api($config);
```

## Usage

### Access

#### Login Link

```php
$language = 'de';
$link = $api->access->link($language);
```

#### Token

```php
$request_token = 'TOKEN';
$accessdata = $api->access->token($request_token);
```

### Account Management

#### Account information

```php
$data = $api->account->get();
```

#### Change Vacation Status

#### Change Display Language

#### Messages GET

```php
$data = $api->messages->get();
```

#### Messages POST

```php
$data = $api->messages->send($userId, $message);
```

#### Messages DELETE

```php
$data = $api->messages->delete($userId, $messageId);
```

#### Logout

```php
$data = $api->account->logout();
```

### Marketplace Infromation

#### Expansions

```php
$gameId = 1; // Magic
$data = $api->expansion->find($gameId);
```

#### Expansion Singles

```php
$expansionId = 1469; 
$data = $api->expansion->singles($expansionId);
```

#### Products

```php
$data = $api->product->get($productId);
```

#### Products List (File)

```php
$data = $api->product->csv();
```

#### Find Products

```php
$data = $api->product->find($search, $parameters);
```

#### Products download Image

```php
$data = $api->product->download($imagepath, $filename);
```

