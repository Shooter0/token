# Token (Laravel 5 Package)

At the top of the file there should be a short introduction and/ or overview that explains **what** the project is. This description should match descriptions added for package managers (Gemspec, package.json, etc.)

## Installation

You can install this package via composer using this command:
  
```
composer require vuer/token
```

Next, you must install the service provider:

``` php
// config/app.php
'providers' => [
    ...
    Vuer\Token\Providers\TokenServiceProvider::class,
];
```

Publish migration:

```
php artisan vendor:publish
```

After the migration has been published you can create the token-table by running the migrations:
```
php artisan migrate
```

## Usage
### Preparing your model

To associate token with a model, the model must implement the following trait:
``` php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vuer\Token\Traits\Tokenable;

class User extends Model
{
    use Tokenable;
   ...
}
```

### Generating token
You can associate a token with a model like this:
``` php
$user  = User::find(1);
$token = $user->createToken('token_name');
```
You can also specify own expiration time or token length:
``` php
// 180 minutes, 100 characters.
$token = $user->createToken('token_name', 180, 100);
```
To check token you can use **checkToken** method:
``` php
if ($user->checkToken('tc0kml61DT3t6xciInw7gjqwmfvZ2799max7lMMGWl2yL9TB')) {
    // token is valid
}
```
You can also delete token:
``` php
// Delete token by name.
$user->deleteToken('token_name');
// Delete token by value:
$user->deleteToken('tc0kml61DT3t6xciInw7gjqwmfvZ2799max7lMMGWl2yL9TB', 'token');
```
To get Token instance use methods:
``` php
// Get one token by name:
$user->getToken('token_name');

// Get collection of tokens by name:
$user->getTokens('token_name');

// Get one token by value:
$user->getToken('tc0kml61DT3t6xciInw7gjqwmfvZ2799max7lMMGWl2yL9TB', 'token');

// Get collection of tokens by value:
$user->getTokens('tc0kml61DT3t6xciInw7gjqwmfvZ2799max7lMMGWl2yL9TB', 'token');
```
