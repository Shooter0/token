<?php
namespace Vuer\Token\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Vuer\Token\Models\Token;

trait Tokenable
{
    /**
     * Generate a string for Token.
     * @param   integer  token length
     * @return  string
     */
    protected function generateTokenString($length)
    {
        return Str::random($length);
    }

    /**
     * Relation to the Token.
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function token()
    {
        return $this->morphOne(Token::class, 'tokenable');
    }

    /**
     * Get the Token by the type.
     * @param   string  $type
     * @param   string  $key
     * @return  Token
     */
    public function getToken($type, $key = 'type')
    {
        return $this->token()->where($key, $type)->first();
    }

    /**
     * Get the Tokens by the type.
     * @param   string  $type
     * @param   string  $key
     * @return  Token
     */
    public function getTokens($type, $key = 'type')
    {
        return $this->token()->where($key, $type)->get();
    }

    /**
     * Check the token.
     * @param   string  $token
     * @return  boolean
     */
    public function checkToken($token)
    {
        return (bool) $this->token()->where('token', $token)->where('expiration_date', '>', Carbon::now())->count();
    }

    /**
     * Delete the tokens.
     * @param   string $value
     * @param   string $key
     * @return  integer count of deleted tokens
     */
    public function deleteToken($value, $key = 'type')
    {
        return $this->token()->where($key, $value)->delete();
    }

    /**
     * Create new token and return the instance.
     * @param  string  $type   token type
     * @param  integer $expire expire in minutes
     * @param  integer $length key length
     * @return Token
     */
    public function createToken($type, $expire = 60, $length = 48)
    {
        return $this->token()->create([
            'token'           => $this->generateTokenString($length),
            'expiration_date' => Carbon::now()->addMinutes($expire),
            'type'            => $type,
        ]);
    }

}
